<?php

namespace App\DataFixtures;

use App\Entity\Sequence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class SequenceFixtures extends Fixture implements DependentFixtureInterface
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
        $faker= Factory::create("fr_FR");
        for ($i=1;$i<20;$i++){
            $sequence = new Sequence();
            $sequence->setTitre($faker->word($faker->numberBetween(1,3)));
            $sequence->setSlug($this->slugger->slug($sequence->getTitre()));
            $sequence->setRelation($this->getReference("niveau".$faker->numberBetween(3,7)));
            $this->addReference("sequence".$i,$sequence);
            $manager->persist($sequence);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            NiveauFixtures::class
        ];
    }
}
