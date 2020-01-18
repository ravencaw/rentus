<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    // /**
    //  * @return Usuario[] Returns an array of Usuario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneByCorreoAndPass($correo, $pass): array
    {
        $qb = $this->createQueryBuilder('u')
            ->where("u.correo = :mail")
            ->andWhere('u.password = :password')
            ->setParameter('mail', $correo)
            ->setParameter('password', $pass)
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
