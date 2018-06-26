<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route("security")
 */
class SecurityController
{
    /**
     * @Route("/login", name="security_login")
     * @Template
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return array
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return array(
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }
}