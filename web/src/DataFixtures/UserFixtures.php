<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const IS_ACTIVE = 'isActive';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     */
    public function __construct(UserPasswordEncoderInterface $encoder, TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $datas = array(
            array(
                self::USERNAME=>'test@test.fr',
                self::PASSWORD=>'123456',
                self::IS_ACTIVE=>true
            ),
            array(
                self::USERNAME=>'test2@test2.fr',
                self::PASSWORD=>'123456',
                self::IS_ACTIVE=>true
            )
        );
        foreach($datas as $data){
            $user = new User();
            $user->setUsername($data[self::USERNAME]);
            $user->setEmail($data[self::USERNAME]);
            $user->setIsActive($data[self::IS_ACTIVE]);
            $user->setPassword($this->encoder->encodePassword($user, $data[self::PASSWORD]));
            $manager->persist($user);
        }
        $manager->flush();


        /** @var User $user */
        $user = $manager->getRepository(User::class)->findOneBy(array('username'=>'test@test.fr'));
        $this->setToken($user);

    }

    /**
     * @param User $user
     */
    private function setToken(User $user){
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);
        $this->session->set('_security_main', serialize($token));
    }

}