<?php

namespace App\Repository;

use App\Entity\OpenVpnStatus;
use App\Entity\UserTG;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @extends ServiceEntityRepository<OpenVpnStatus>
 *
 * @method OpenVpnStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpenVpnStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpenVpnStatus[]    findAll()
 * @method OpenVpnStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpenVpnStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpenVpnStatus::class);
        // $this->validator = $validator;
    }

    /**
     * @param array $obValue
     *
     * @return OpenVpnStatus|null Returns an array of User objects
     */
    public function addUser(OpenVpnStatus $obValue): ?OpenVpnStatus
    {
        $entityManager = $this->getEntityManager();
        $obValue->setDateUpdate();
        $entityManager->persist($obValue);
        $entityManager->flush();
        return $obValue;

    }

    public function updateUser(OpenVpnStatus $obValue): ?OpenVpnStatus
    {
        $product = $this->getEntityManager()->find(OpenVpnStatus::class, $obValue->getId());
        $product->setDateUpdate();
        $product->setBytesReceived($obValue->getBytesReceived(),false);
        $product->setBytesSent($obValue->getBytesSent(),false);
        $this->getEntityManager()->flush();

        $this->getEntityManager()->refresh($product);

        return $obValue;
    }


    public function setUserTest(array $obValue): ?OpenVpnStatus{

        $obOpenVpnStatusRepository = new OpenVpnStatus ();
        $obOpenVpnStatusRepository->setName($obValue['name']);
        $obOpenVpnStatusRepository->setIp($obValue['ip']);
        $obOpenVpnStatusRepository->setBytesSent($obValue['bytes_sent']);
        $obOpenVpnStatusRepository->setBytesReceived($obValue['bytes_received']);
        $obOpenVpnStatusRepository->setConnectedSince($obValue['connected_since']);
        $obOpenVpnStatusRepository->setDateUpdate();
        return  $obOpenVpnStatusRepository;
    }


    public function getList($arName): array
    {
        $startOfDay = new \DateTime('today');
        $startOfDay->setTime(02, 0, 0);

        $qb = $this->createQueryBuilder('p');
        $qb->where($qb->expr()->in('p.name', ':var1'))
            ->setParameter('var1', $arName)
            ->andWhere('p.date_update > :startOfDay')
            ->setParameter('startOfDay', $startOfDay);
        $arProducts = $qb->getQuery()
            ->getResult();
        $arResult = [];
        foreach ($arProducts as $obProduct) {
            $arResult[$obProduct->getName()] = $obProduct;
        }
        return $arResult;
    }

}
