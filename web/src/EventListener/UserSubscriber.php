<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Entity\Page;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class UserSubscriber
 * @package App\EventListener
 */
class UserSubscriber implements EventSubscriber
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage){
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {

        return array(

            'prePersist'
        );
    }

    public function prePersist(LifecycleEventArgs $args){
        $this->setUser($args);
    }

    private function setUser(LifecycleEventArgs $args){
        $entity = $args->getObject();

        if($entity instanceof Page || $entity instanceof Article){

            $entity->setUser(

                $args->getObjectManager()
                    ->getRepository(User::class)
                    ->find(

                        $this->tokenStorage
                            ->getToken()
                            ->getUser()
                            ->getId()

                    )

            );
        }

    }
}