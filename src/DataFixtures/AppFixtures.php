<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 11; $i++) {
            $category = new Category();
            $category->setName('Category ' . $i);
            $manager->persist($category);
        }
        $manager->flush();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        
        for ($i = 1; $i < 21; $i++)
        {
            $category = $categories[array_rand($categories)];
            $film = new Film();
            $film->setTitle('Film ' . $i);
            $film->setDescription('Description ' . $i);
            $film->setCategories( $category );
            $film->setCreatingDate(new \DateTime());
            $film->setPoster('https://picsum.photos/id/' . $i . '/200/300');
            $manager->persist($film);
        }
        $manager->flush();
    }
}
