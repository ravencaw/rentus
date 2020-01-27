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
    
    public function findInmueblesFiltrados($array_filtros)
    {
        $qb = $this->createQueryBuilder('i')
        ->where('i.tipoInmueble = :tipo')
        ->setParameter('tipo', $array_filtros["tipo"])
        ;
        
        if(isset($array_filtros["precio_min"])){
            $qb -> andWhere('i.precio > :precio_min')
            ->setParameter('precio_min', $array_filtros["precio_min"]);
        }
        if(isset($array_filtros["precio_max"])){
            $qb -> andWhere('i.precio < :precio_max')
            ->setParameter('precio_max', $array_filtros["precio_max"]);
        }

        if(isset($array_filtros["superficie"])){
            $qb -> andWhere('i.superficie = :superficie')
            ->setParameter('superficie', $array_filtros["superficie"]);
        }

        if(isset($array_filtros["zona"])){
            $qb -> andWhere('i.zona = :zona')
            ->setParameter('zona', $array_filtros["zona"]);
        }
        if(isset($array_filtros["n_habitaciones"])){
            $qb -> andWhere('i.habitaciones = :n_habitaciones')
            ->setParameter('n_habitaciones', $array_filtros["n_habitaciones"]);
        }
        if(isset($array_filtros["n_banyos"])){
            $qb -> andWhere('i.bathroom = :n_banyos')
            ->setParameter('n_banyos', $array_filtros["n_banyos"]);
        }

        $query = $qb->getQuery();
        $inmuebles = $query->getResult();

        return $inmuebles;
    }
    

    
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
