<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    /**
     * @param SluggerInterface $slugger
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=1;$i<50;$i++){
            $faker = Factory::create("fr_FR");
            $article = new Article();
            $article->setTitre($faker->words($faker->numberBetween(1,3),true))
                ->setSlug($this->slugger->slug($article->getTitre()))
                ->setCreateAt(new \DateTime())
                ->setContenu($faker->paragraphs($faker->numberBetween(1,3),true))
                ->setSequence($this->getReference("sequence".$faker->numberBetween(1,19)));
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SequenceFixtures::class
        ];
    }
}