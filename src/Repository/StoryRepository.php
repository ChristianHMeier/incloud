<?php
namespace App\Repository;

use App\Entity\Story;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class StoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Story::class);
    }
    
    /**
     * @param $filters
     * @param $offset
     * @return Story[]
     */
    /*function findByPagedStories($filters, $offset): array
    {
        /*$stories = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findLatest();
        $stories = $this->createQueryBuilder('p')
            ->andWhere('p.price > :price')
            ->setParameter('price', $price)
            ->orderBy('p.price', 'ASC')
            ->getQuery();*/

        //return $qb->execute();
    //}
}