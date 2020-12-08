<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()  
    {
        return [SeasonFixtures::class];  
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i=0; $i < 30; $i++) {
            $episode = new Episode();
            $episode->setNumber($faker->randomDigit);
            $episode->setTitle($faker->words($nb = 3, $asText = true) );
            $episode->setSynopsis($faker->paragraph(3, true));
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(0, 29)));
            $manager->persist($episode);
        }
        $manager->flush();
    }
}
