<?php

namespace App\Repository;

use App\Entity\Servers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Servers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Servers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Servers[]    findAll()
 * @method Servers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServersRepository extends ServiceEntityRepository
{
    /**
     * ServersRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Servers::class);
    }

    /**
     * @param Servers $server
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveServer(Servers $server)
    {
        $this->getEntityManager()->persist($server);
        $this->getEntityManager()->flush();
    }
}
