<?php

namespace App\Controller;

use App\Entity\Servers;
use Doctrine\ORM\ORMException;
use App\Repository\ServersRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class ServersController
 * @package App\Controller
 */
class ServersController
{
    /**
     * @var ServersRepository
     */
    private $serversRepository;

    /**
     * ServersController constructor.
     * @param ServersRepository $serversRepository
     */
    public function __construct(ServersRepository $serversRepository)
    {
        $this->serversRepository = $serversRepository;
    }

    /**
     * Function accepts the excel data and uploads into servers table
     *
     * @param Request $request
     * @return mixed
     */
    public function upload(Request $request)
    {
        $file = $request->files->get('file');

        $fileFolder = __DIR__ . '/../../public/uploads/';

        $filePathName = md5(uniqid()) . $file->getClientOriginalName();
        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            return new JsonResponse([
                'success' => false,
                'data'    => [],
                'message' => 'Something went wrong when file upload.'
            ], Response::HTTP_BAD_REQUEST);
        }
        $spreadsheet = IOFactory::load($fileFolder . $filePathName);
        $sheetData   = $spreadsheet
            ->getActiveSheet()
            ->toArray(null, true, true, true);

        foreach ($sheetData as $row) {
            if ($row['B'] == 'RAM') {
                continue;
            }
            $slug   = $this->slugify($row['A']);
            $server = $this->serversRepository->findOneBy(['model_slug' => $slug]);
            if (!$server) {
                //TODO: Validate data before inserting
                $this->insertServer($row, $slug);
            }
        }

        return new JsonResponse([
            'success' => true,
            'data'    => [],
            'message' => 'Uploaded the file.'
        ], Response::HTTP_OK);

    }

    /**
     * Function to get list of server based on filters
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $inputData = $request->query->all();
        $criteria = [];
        if (!empty($inputData['ram_size'])) {
            $criteria['ram_size'] = $inputData['ram_size'];
        }
        if (!empty($inputData['ram_type'])) {
            $criteria['ram_type'] = $inputData['ram_type'];
        }
        if (!empty($inputData['hdd_type'])) {
            $criteria['hdd_type'] = $inputData['hdd_type'];
        }
        if (!empty($inputData['hdd_size'])) {
            $criteria['hdd_size'] = $inputData['hdd_size'];
        }

        $servers = $this->serversRepository->findBy($criteria);
        $data    = [];
        foreach ($servers as $server) {
            $data[] = $server->toArray();
        }

        return new JsonResponse([
            'success' => true,
            'data'    => $data
        ], Response::HTTP_OK);
    }


    /**
     * Function to slugify the  model name
     *
     * @param $text
     * @return string
     */
    private function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Function to format and insert the server entry
     *
     * @param $row
     * @param $slug
     * @return false|void
     */
    private function insertServer($row, $slug)
    {
        $price    = ltrim($row['E'], '€');
        $hdd      = preg_split("/(SAS|SATA|SSD)/", $row['C'], -1, PREG_SPLIT_DELIM_CAPTURE);
        $ram      = preg_split("/(DDR3|DDR4)/", $row['B'], -1, PREG_SPLIT_DELIM_CAPTURE);

        $newServer = new Servers();

        $newServer
            ->setUuid(uuid_create(UUID_TYPE_RANDOM))
            ->setModelName($row['A'])
            ->setModelSlug($slug)
            ->setRamSize($ram[0])
            ->setRamType($ram[1])
            ->setHddSize($hdd[0])
            ->setHddType($hdd[1])
            ->setLocation($row['D'])
            ->setPrice((float)$price)
            ->setCurrency('euro');

        try {
            return $this->serversRepository->saveServer($newServer);
        } catch (OptimisticLockException $e) {
            return false;
        } catch (ORMException $e) {
            return false;
        }
    }
}