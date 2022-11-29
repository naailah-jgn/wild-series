<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAM = [
        'Walking dead', 
        'Breaking bad',
        'Supernatural',
        'Game of thrones',
        'Friends',
    ];
    public function load(ObjectManager $manager)
    {
    foreach (self::PROGRAM as $programName) {
        $program = new Program();
        $program->setTitle($programName);
        $program->setSynopsis('Daily lives of 6 friends');
        $program->setPoster('example');
        $program->setCategory($this->getReference('category_Romantique'));
        $manager->persist($program);
        $manager->flush();
        }
    }


    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
    
}
