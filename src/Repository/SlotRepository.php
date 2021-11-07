<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Slot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Slot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slot[]    findAll()
 * @method Slot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slot::class);
    }

    public function findInTimeframe(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo): array
    {
        $queryBuilder = $this->createQueryBuilder('slot')
            ->select()
            ->from('App:Slot', 's')
            ->where('slot.dateFrom >= :from')
            ->andWhere('slot.dateTo <= :to')
            ->setParameter('from', $dateFrom)
            ->setParameter('to', $dateTo);

        return $queryBuilder->getQuery()->execute();
    }
}
