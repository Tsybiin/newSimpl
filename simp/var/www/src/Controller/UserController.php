<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Cassandra\Date;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{

    public function createUser(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $entityManager = $doctrine->getManager();
        $request = Request::createFromGlobals();
        $email = $request->get('email');

        $firstName = $request->get('first_name');

        $user = new User();
        $user->setEmail($email);
        $user->setFirstName(htmlspecialchars($firstName));
        $user->setDateRegister();

        $errors = $validator->validate($user);

        if ($errors->count() > 0) {
            $arResponse['status'] = false;
            $arResponse['error'] = $errors->offsetGet(0)
                ->getMessage();
        } else {
            $entityManager->persist($user);
            $entityManager->flush();
            $arResponse['status'] = true;
            $arResponse['data']['user_id'] = $user->getId();
            $arResponse['data']['email'] = $user->getEmail();
        }

        return new Response($this->json($arResponse));
    }

}