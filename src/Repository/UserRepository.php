<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function isEmailUnique($email)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM user u
            WHERE u.email = :email
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['email' => $email]);
        $res = $resultSet->fetchAllAssociative();

        if ($res){
            return 'Votre email est déjà utilisé sur ce site.';
        }else{
            return true;
        }
    }

    public function isNicknameUnique($nickname)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM user u
            WHERE u.nickname = :nickname
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['nickname' => $nickname]);
        $res =  $resultSet->fetchAllAssociative();

        if ($res){
            return 'Votre pseudo est déjà utilisé sur ce site.';
        }else{
            return true;
        }
    }


}