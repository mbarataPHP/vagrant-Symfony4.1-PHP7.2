<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

/**
 * Class ApiKeyAuthenticator
 * @package App\Security
 */
class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     * @return PreAuthenticatedToken
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {

        if (!$userProvider instanceof ApiKeyUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of ApiKeyUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $apiKey = $token->getCredentials();
       // $username = $userProvider->getUsernameForApiKey($apiKey);

        $user = $this->entityManager->getRepository(User::class)->loadUserByAPI($apiKey);
        if (is_null($user)) {
            // CAUTION: this message will be returned to the client
            // (so don't put any un-trusted messages / error strings here)

            throw new CustomUserMessageAuthenticationException(
                sprintf('API Key "%s" does not exist.', $apiKey)
            );
        }


        return new PreAuthenticatedToken(
            $user,
            $apiKey,
            $providerKey,
            $user->getRoles()
        );
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function createToken(Request $request, $providerKey)
    {
        // look for an apikey query parameter
        $apiKey = $request->query->get('apikey');




        if (!$apiKey) {
            throw new BadCredentialsException();

            // or to just skip api key authentication
            // return null;
        }

        return new PreAuthenticatedToken(
            'anon.',
            $apiKey,
            $providerKey
        );
    }
}