<?php
namespace App\Repository;

use App\Entity\KeyVpn;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeyVpnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,ValidatorInterface $validator)
    {
        parent::__construct($registry, KeyVpn::class);
        $this->validator = $validator;
    }


    public function getUserKeyById($idUser): array
    {
        return $this->findBy(['id_user' => $idUser],  $orderBy = null, $limit = null, $offset = null);
    }


    public function setKey(object $obValue,$idUser): ?KeyVpn
    {

        $entityManager = $this->getEntityManager();
        $obKey = new KeyVpn();
        $obKey->setIdUser($idUser);
        $obKey->setName($obValue->name);
        $obKey->setDateSend();

        $errors =$this->validator->validate($obKey);

        if ($errors->count() > 0) {
            $errors->offsetGet(0)
                ->getMessage();
            return false;
        } else {
            $entityManager->persist($obKey);
            $entityManager->flush();
            return $obKey;
        }
    }







    // Метод для поиска продуктов по части названия
    public function findByNamePart(string $namePart): array
    {
        return $this->createQueryBuilder()->delete();
    }

    // Дополнительные методы по необходимости
}