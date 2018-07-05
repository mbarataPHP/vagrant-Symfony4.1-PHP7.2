<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\Serializer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route("api/user")
 */
class UserController
{
    /**
     * @Route("/", methods={"GET"}, name="user_index")
     * @param TokenStorageInterface $tokenStorage
     * @param Serializer $serializer
     * @return Response
     */
    public function index(TokenStorageInterface $tokenStorage, Serializer $serializer){

        /** @var User $user */
        $user = $tokenStorage->getToken()->getUser();

        return new Response($serializer->serialize($user, 'json'));
    }
}