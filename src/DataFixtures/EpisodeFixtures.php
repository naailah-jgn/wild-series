<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 500; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->sentence());
            $episode->setNumber($faker->numberBetween(1, 100));
            $episode->setSynopsis($faker->text(1000));
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(1, 10)));
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }

        $manager->flush();
    }

	public function getDependencies(): array 
    {
        return [
            SeasonFixtures::class,
         ];
	}
}
