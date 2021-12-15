<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Type;
use App\Entity\Brand;
use App\Entity\Command;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 5; $i++) {
            $command = new Command();

            $command->setNumberOrder("Command-00" . $i);
            $command->setPrice($faker->numberBetween($min = 10, $max = 500));
            $command->setAdress($faker->text);
            $command->setCity($faker->word);
            $command->setName($faker->name);
            $command->setEmail($faker->email);

            $manager->persist($command);

            $type = new Type();

            $type->setName($faker->word);
            $type->setDescription($faker->text);

            $manager->persist($type);



            $brand = new Brand();

            $brand->setName($faker->word);
            $brand->setDescription($faker->text);

            $manager->persist($brand);

            $product = new Product();

            $product->setName($faker->word);
            $product->setPrice($faker->numberBetween(5, 500));
            $product->setDescription($faker->text);
            $product->setStock($faker->numberBetween(5, 20));
            $product->setType($type);
            $product->setBrand($brand);

            $manager->persist($product);
        }


        $manager->flush();
    }
}
