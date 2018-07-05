<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Page;

/**
 * Class ArticleFixtures
 * @package App\DataFixtures
 */
class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public const MAX = 15;
    public const URL = 'https://loripsum.net/api/1/short/plaintext';
    public const ARTICLE_REFERENCE = 'Article ';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {


        for( $i = 1; $i <= PageFixtures::MAX; $i++){
            /** @var Page $page */
            $page = $this->getReference( PageFixtures::PAGE_REFERENCE.$i);

            $lorem = file_get_contents(self::URL);
            for( $y = 1; $y <= self::MAX; $y++){

                $article = new Article();
                $article->setPage($page);
                $article->setDescription($lorem);

                $manager->persist($article);
                $this->addReference(self::ARTICLE_REFERENCE.$i.'_'.$y, $article);

            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            PageFixtures::class,
            UserFixtures::class
        );
    }


}