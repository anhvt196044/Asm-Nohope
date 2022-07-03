<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=15;$i++){
            $product = new Product();
            $product->setName("Product $i");
            $product->setColor("Black");
            $product->setDescription("Best seller");
            $product->setPrice((float)(rand(203,20001)));
            $product->setImage("https://media.dior.com/couture/ecommerce/media/catalog/product/r/v/1570182303_943J605A0554_C989_E01_ZH.jpg");

            $manager->persist($product);
        }


        $manager->flush();
    }
}
