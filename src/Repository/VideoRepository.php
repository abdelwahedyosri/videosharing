<?php

namespace App\Repository;

use App\Entity\Video;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Video::class);
        $this->paginator=$paginator;
    }
    public function findByChildIds(array $value, int $page)
    {

        $dbquery = $this->createQueryBuilder('v')
            ->andWhere('v.category IN (:val)')
            ->setParameter('val', $value)
            ->getQuery();

        $pagination = $this->paginator->paginate($dbquery, $page, 5);
        return $pagination;
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
