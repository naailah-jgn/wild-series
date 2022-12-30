<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const Program = [
        [
            'title' => 'Walking dead', 
            'synopsis' => 'La série raconte l\'histoire d\'un petit groupe de survivants mené
            par Rick Grimes qui tente de survivre dans un 
            monde post-apocalyptique en proie à une invasion de zombies 
            qui sont ici surnommés « les rôdeurs ».',
            'category' => 'category_Horreur'
        ],
        [
            'title' => 'Breaking bad',
            'synopsis' => 'La série se concentre sur Walter White, un professeur de chimie 
            surqualifié et père de famille, 
            qui, ayant appris qu\'il est atteint d\'un cancer du poumon en phase terminale, 
            sombre dans le crime pour assurer l\'avenir financier de sa famille. 
            Pour cela, il se lance dans la fabrication et la vente 
            de méthamphétamine avec l\'aide de l\'un de ses anciens élèves, Jesse Pinkman.
             L\'histoire se déroule à Albuquerque, au Nouveau-Mexique.',
            'category' => 'category_Thriller',
        ],
        [
            'title' => 'Supernatural',
            'synopsis' => 'Les aventures et le destin des deux frères Winchester sur les traces de leur père,
             un "chasseur", à la poursuite de monstres vivant parmi les humains.',
            'category' => 'category_Horreur',
        ],
        [
            'title' => 'Game of Thrones',
            'synopsis' => 'Guerre de clan entre différent royaume pour le trone de fer.',
            'category' => 'category_Fantastique',
        ],
        [ 
            'title' =>'Friends',
            'synopsis' => 'Les péripéties de 6 jeunes New-Yorkais liés par 
            une profonde amitié. Entre amour, travail, et famille, 
            ils partagent leurs bonheurs et leurs soucis au Central Perk, 
            leur café favori...',
            'category' => 'category_Romantique',
        ],
        [
            'title' => 'Sherlock',
            'synopsis' => 'Les aventures de Sherlock Holmes et de son 
            acolyte de toujours, le docteur Watson, sont transposées au XXIème siècle...',
            'category' => 'category_Aventure'
        ],
    ];
    public function load(ObjectManager $manager)
    {
    foreach (self::Program as $key =>$ProgramName) {
        $Program = new Program();
        $Program->setTitle($ProgramName['title']);
        $Program->setSynopsis($ProgramName['synopsis']);
        $Program->setPoster('walking_dead.png');
        $Program->setCategory($this->getReference($ProgramName['category']));
        $manager->persist($Program);
        $this->addReference('Program_' . $key, $Program);
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
