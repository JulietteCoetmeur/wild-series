<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Actor;
use App\Service\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;     
    }
    
    const ACTORS = [
        'Norman Reedus',
        'Melissa McBride',
        'Lauren Cohan',
        'Jeffrey Dean Morgan'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $slug = $this->slugify->generate($actor->getName());
            $actor->setSlug($slug);
            $actor->addProgram($this->getReference('program_0'));
            $manager->persist($actor);
        }

        $faker  =  Faker\Factory::create('en_US');
        for ($i=0; $i < 30; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $slug = $this->slugify->generate($actor->getName());
            $actor->setSlug($slug);
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(0, 5)));
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()  
    {
        return [ProgramFixtures::class];  
    }
}