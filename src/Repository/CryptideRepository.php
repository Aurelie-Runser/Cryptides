<?php

namespace App\Repository;

use App\Entity\Cryptide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cryptide>
 */
class CryptideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cryptide::class);
    }

    public function cryptidesByContinent(string $continentChoose=null):array {

        return $this->createQueryBuilder('cry')
        ->select('cry.id', 'cry.name', 'cry.slug', 'cry.img', 'con.slug as slugContinent')
        ->leftJoin('cry.idContinent', 'con')
        ->where('con.slug = :continentChoose')
        ->orderBy('cry.name', 'ASC')
        ->setParameter('continentChoose', $continentChoose)
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Cryptide[] Returns an array of Cryptide objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Cryptide
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
