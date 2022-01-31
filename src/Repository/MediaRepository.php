<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    public function showImagesFromTrick($trickid): array
    {

        $qb = $this->createQueryBuilder('i')
            ->where('i.idtrick = :id')    
            ->andWhere('i.type = 1')     
            ->setParameter('id', $trickid);       
            
    
        $query = $qb->getQuery();
    
        return $query->execute();   
 
    }

    public function showVideosFromTrick($trickid): array
    {

        $qb = $this->createQueryBuilder('i')
            ->where('i.idtrick = :id')    
            ->andWhere('i.type = 2')     
            ->setParameter('id', $trickid);       
            
    
        $query = $qb->getQuery();
    
        return $query->execute();   
 
    }

    public function addPictures($idtrick, $name)
    {

        $conn = $this->getEntityManager()->getConnection();
    
        $sql = '
        INSERT INTO media (idtrick, type, name)
        VALUES (:idtrick, 1, :name)
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['idtrick' => $idtrick, 'name' => $name]);

    
    }

}