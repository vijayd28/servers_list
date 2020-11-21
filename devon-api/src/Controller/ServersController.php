<?php

namespace App\Controller;

use App\Services\ServerService;
use App\Services\FileUploadService;
use App\Services\FileFilterService;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ServersController
 * @package App\Controller
 */
class ServersController
{
    /**
     * @var FileUploadService
     */
    private $fileUploadService;
    /**
     * @var ServerService
     */
    private $serverService;

    /**
     * ServersController constructor.
     * @param FileUploadService $fileUploadService
     * @param ServerService $serverService
     */
    public function __construct(
        FileUploadService $fileUploadService,
        ServerService  $serverService
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->serverService = $serverService;
    }

    /**
     * Function to get list of server based on filters
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function listFromFile(Request $request): JsonResponse
    {
        $file = $request->files->get('file');
        $path = $this->fileUploadService->upload($file);
        $inputData = $request->query->all();
        $fileFilterService = new FileFilterService($path);
        if (!empty($inputData['ram_size'])) {
            $fileFilterService->setRule('', $inputData['ram_size']);
        }
        if (!empty($inputData['ram_type'])) {
            $fileFilterService->setRule('', $inputData['ram_type']);
        }
        if (!empty($inputData['hdd_type'])) {
            $fileFilterService->setRule('', $inputData['hdd_type']);
        }
        if (!empty($inputData['hdd_size'])) {
            $fileFilterService->setRule('', $inputData['hdd_size']);
        }

        return new JsonResponse([
                                    'success' => true,
                                    'data'    => $fileFilterService->toArray()
                                ], Response::HTTP_OK);

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
        $spreadsheet = IOFactory::load($this->fileUploadService->upload($file));
        $sheetData   = $spreadsheet
            ->getActiveSheet()
            ->toArray(null, true, true, true);

        array_shift($sheetData); //Remove titles
        foreach ($sheetData as $row) {
            //TODO: Validate data before inserting
            $this->serverService->insertServer($row);
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

        return new JsonResponse([
            'success' => true,
            'data'    => $this->serverService->list($inputData)
        ], Response::HTTP_OK);
    }

}