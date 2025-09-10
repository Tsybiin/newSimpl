<?php

namespace App\Repository;

use App\Entity\KeyVpn;
use App\Entity\UserTG;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @extends ServiceEntityRepository<UserTG>
 *
 * @method UserTG|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTG|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTG[]    findAll()
 * @method UserTG[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTGRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,ValidatorInterface $validator)
    {
        parent::__construct($registry, UserTG::class);
        $this->validator = $validator;
    }

   /**
    * @return UserTG[] Returns an array of User objects
    */
    public function setUser(object $obValue): ?UserTG
    {
        $entityManager = $this->getEntityManager();
        $obUser = new UserTG();
        $obUser->setFirstName(property_exists($obValue,'first_name') ? $obValue->first_name : '');
        $obUser->setLastName(property_exists($obValue,'last_name') ? $obValue->last_name : '');
        $obUser->setUsername(property_exists($obValue,'username') ? $obValue->username : '');
        $obUser->setIdTelegram($obValue->id);
        $obUser->setDateRegister();
        $obUser->setAuthDate();

        $errors = $this->validator->validate($obUser);
        if ($errors->count() > 0) {
            $errors->offsetGet(0)
                ->getMessage();
            return false;
        } else {
            $entityManager->persist($obUser);
            $entityManager->flush();
            return $obUser;
         }
    }


    public function updateUser(UserTG $obUserTG): ?UserTG
    {
        $obEnintyUserTG = $this->getEntityManager()->find(UserTG::class, $obUserTG->getId());

        $obEnintyUserTG->setFirstName(property_exists($obUserTG, 'first_name') ? $obUserTG->first_name : '');
        $obEnintyUserTG->setLastName(property_exists($obUserTG, 'last_name') ? $obUserTG->last_name : '');
        $obEnintyUserTG->setUsername(property_exists($obUserTG, 'username') ? $obUserTG->username : '');
        $obEnintyUserTG->setIdTelegram($obUserTG->getIdTelegram());
        $obEnintyUserTG->setAuthDate();

        $errors = $this->validator->validate($obEnintyUserTG);
        if ($errors->count() > 0) {
            $errors->offsetGet(0)
                ->getMessage();
            return false;
        } else {
            $this->getEntityManager()->flush();
            return $obEnintyUserTG;
        }
    }


   public function getUser($id): ?UserTG
   {

       return $this->findOneBy(['id_telegram' => $id]);
   }
}
