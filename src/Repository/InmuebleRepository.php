<?php

namespace App\Repository;

use App\Entity\Inmueble;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Inmueble|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inmueble|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inmueble[]    findAll()
 * @method Inmueble[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InmuebleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inmueble::class);
    }

    // /**
    //  * @return Inmueble[] Returns an array of Inmueble objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneById($id): array
    {
        $qb = $this->createQueryBuilder('u')
            ->where("u.id = :id")
            ->setParameter('id', $id)
        ;

        $query = $qb->getQuery();
        $usuario = $query->setMaxResults(1)->getOneOrNullResult();

        $normalizers = new \Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer();
        if($usuario){
            $norm = $normalizers->normalize($usuario);
        }else{
            $norm = [];
        }

        return $norm;
    }
    

}
