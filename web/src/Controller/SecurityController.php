<?php

namespace App\Controller;

use App\Security\Authentication;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\NonUniqueResultException;
use JMS\Serializer\Serializer;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route("security")
 */
class SecurityController
{
    /**
     * @Route("/login", methods={"POST"}, name="security_login")
     * @uses $_POST['username']
     * @uses $_POST['password']
     * @param Request $request
     * @param Authentication $authentication
     * @param Serializer $serializer
     * @return Response
     * @throws NonUniqueResultException
     */
    public function login(Request $request, Authentication $authentication, Serializer $serializer){

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $authentication->connect($username, $password);

        return new Response($serializer->serialize($user, 'json'));
    }


    /**
     * @Route("/logout", methods={"GET"}, name="security_logout")
     * @param Authentication $authentication
     * @return Response
     */
    public function logout(Authentication $authentication){
        $authentication->disconnect();

        return new Response('');
    }
}