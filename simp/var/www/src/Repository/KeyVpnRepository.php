<?php
namespace App\Repository;

use App\Entity\KeyVpn;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeyVpnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeyVpn::class);
    }

    // Метод для поиска продуктов по части названия
    public function findByNamePart(string $namePart): array
    {
        return $this->createQueryBuilder()->delete();
    }

    // Дополнительные методы по необходимости
}