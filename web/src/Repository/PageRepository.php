<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class PageRepository
 * @package App\Repository
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }


    /**
     * @return Page[]
     */
    public function lastPage(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')->getQuery()->getResult();
    }
}