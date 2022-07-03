<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=10;$i++)
        {
            $category = new Category();
            $category->setName("category $i");
            $category->setDateOfManufacture(\DateTime::createFromFormat('Y-m-d', '2001-03-20'));

            $manager->persist($category);
        }


        $manager->flush();
    }
}
