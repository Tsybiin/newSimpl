<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Cassandra\Date;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\KeyVpn;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestController extends AbstractController
{
    public function test(ManagerRegistry $doctrine, ValidatorInterface $validator,LoggerInterface $logger,): Response
    {
        $entityManager = $doctrine->getManager();
        $obKeyVpn = new KeyVpn();
        $obKeyVpn->setNAME('test');
        $obKeyVpn->setDATESEND();
        $errors = $validator->validate($obKeyVpn);

        if ($errors->count() > 0) {
            $arResponse['status'] = false;
            $arResponse['error'] = $errors->offsetGet(0)
                ->getMessage();
        } else {
            $entityManager->persist($obKeyVpn);
            $entityManager->flush();
            $arResponse['status'] = true;
            $arResponse['data']['user_id'] = $obKeyVpn->getId();
            $arResponse['data']['user_id'] = $obKeyVpn->getNAME();
            $arResponse['data']['email'] = $obKeyVpn->getDATESEND();
        }
        return new Response($this->json($arResponse));


        return new Response($this->json(['$arResponse']));

    }
}