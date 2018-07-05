<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Page;

/**
 * Class PageFixtures
 * @package App\DataFixtures
 */
class PageFixtures extends Fixture implements DependentFixtureInterface
{

    public const MAX = 15;
    public const PAGE_REFERENCE = 'Page ';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        for( $i = 1; $i <= self::MAX; $i++){
            $title = self::PAGE_REFERENCE.$i;
            $page = new Page();
            $page->setTitle($title);

            $manager->persist($page);

            $this->addReference($title, $page);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}