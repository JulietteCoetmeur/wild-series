<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()  
    {
        return [ProgramFixtures::class];  
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i=0; $i < 30; $i++) {
            $season = new Season();
            $season->setNumber($faker->randomDigit);
            $season->setYear($faker->year('now'));
            $season->setDescription($faker->paragraph(3, true));
            $season->setProgram($this->getReference('program_' . $faker->numberBetween(0, 5)));
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);
        }
        $manager->flush();
    }
}
