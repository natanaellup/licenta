<?php
/**
 * Created by PhpStorm.
 * User: Naty
 * Date: 3/31/2016
 * Time: 10:14 AM
 */

namespace BookBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AuthorRepository extends EntityRepository
{
    public function getAllActiveUsers()
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.active = 1');

        return $qb->getQuery()->getResult();
    }
}