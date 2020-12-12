<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;     
    }

    public function getDependencies()  
    {
        return [SeasonFixtures::class];  
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i=0; $i < 20; $i++) {
            $episode = new Episode();
            $episode->setNumber($faker->randomDigit);
            $episode->setTitle($faker->words($nb = 3, $asText = true) );
            $episode->setSynopsis($faker->paragraph(3, true));
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(0, 29)));
            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $manager->persist($episode);
        }
        $manager->flush();
    }
}
