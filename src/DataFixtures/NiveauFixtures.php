<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class NiveauFixtures extends Fixture
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
        for ($i=3;$i<=6;$i++){
            $niveau = new Niveau();
            $niveau->setTitre($i." eme");
            $niveau->setSlug($this->slugger->slug($niveau->getTitre()));
            $this->addReference("niveau".$i,$niveau);
            $manager->persist($niveau);
        }
        $niveau = new Niveau();
        $niveau->setTitre( "Chorale");
        $niveau->setSlug($this->slugger->slug($niveau->getTitre()));
        $this->addReference("niveau7",$niveau);
        $manager->persist($niveau);


        $manager->flush();
    }
}
