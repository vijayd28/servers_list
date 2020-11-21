<?php

namespace App\Services;

use App\Entity\Servers;
use App\Repository\ServersRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ServerService
{
    /**
     * @var ServersRepository
     */
    private $serversRepository;

    /**
     * ServerService constructor.
     * @param ServersRepository $serversRepository
     */
    public function __construct(ServersRepository $serversRepository)
    {
        $this->serversRepository = $serversRepository;
    }

    /**
     * @param $row
     * @return false|void
     */
    public function insert($row)
    {
        $price    = $row['E'];
        $hdd      = preg_split("/(SAS|SATA|SSD)/", $row['C'], -1, PREG_SPLIT_DELIM_CAPTURE);
        $ram      = preg_split("/(DDR3|DDR4)/", $row['B'], -1, PREG_SPLIT_DELIM_CAPTURE);

        $newServer = new Servers();

        $newServer
            ->setUuid(uuid_create(UUID_TYPE_RANDOM))
            ->setModelName($row['A'])
            ->setRamSize($ram[0])
            ->setRamType($ram[1])
            ->setHddSize($hdd[0])
            ->setHddType($hdd[1])
            ->setLocation($row['D'])
            ->setPrice($price)
            ->setCurrency('euro');

        try {
            return $this->serversRepository->saveServer($newServer);
        } catch (OptimisticLockException $e) {
            return false;
        } catch (ORMException $e) {
            return false;
        }
    }

    /**
     * @param $inputData
     * @return array
     */
    public function list($inputData)
    {
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

        return $data;
    }
}