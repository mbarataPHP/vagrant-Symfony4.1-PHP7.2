<?php

namespace App\Security;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use DateTime;

/**
 * Class Authentication
 * @package App\Security
 */
class Authentication
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;

    }

    public function disconnect(){
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $user->setApiKey(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->tokenStorage->setToken(null);
    }

    /**
     * @param string $username
     * @param string $password
     * @throws NonUniqueResultException
     * @return User
     */
    public function connect(string $username, string $password)
    {

        $user = $this->entityManager->getRepository(User::class)->loadUserByUsername($username);

        if(is_null($user)){
            throw new BadCredentialsException();
        }


        if(!$this->encoder->isPasswordValid($user, $password)){
            throw new BadCredentialsException();
        }

        $user->setApiKey($this->createToken($username));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param string $username
     * @return string
     */
    private function createToken(string $username): string
    {
        $dateTime = new DateTime();

        return $dateTime->format('Y-m-d-h-m-s').'_'.md5($username).'_'.$this->generateString();
    }

    /**
     * @return string
     */
    private function generateString(): string
    {
        $chain = 'abcdefghijklmnopqrstuvwyzABCDEFGHIJKLMNOPQRSTUVWYZ0123456789';
        $max = 15;


        $return = '';
        for($i = 1; $i <= $max; $i++){
            $random = rand(0, strlen($chain)-1);
            $return .= $chain[$random];
        }

        return $return;
    }
}