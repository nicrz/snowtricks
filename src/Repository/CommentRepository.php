<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function showValidComments($trickid)
    {

        $qb = $this->createQueryBuilder('c')
            ->where('c.idtrick = :id')    
            ->andWhere('c.valid = 1')     
            ->setParameter('id', $trickid);       
            
    
        $query = $qb->getQuery();
    
        return $query->execute();   
 
    }

    public function showPendingComments($trickid): array
    {

        $qb = $this->createQueryBuilder('c')
            ->where('c.idtrick = :id')    
            ->andWhere('c.valid = 0')     
            ->setParameter('id', $trickid);       
            
    
        $query = $qb->getQuery();
    
        return $query->execute();   
 
    }

    public function deleteComment($commentid): array
    {

        $qb = $this->createQueryBuilder('c')
            ->delete()
            ->where('c.id = :id')      
            ->setParameter('id', $commentid);       
            
    
        $query = $qb->getQuery();
    
        return $query->execute();   
 
    }



}