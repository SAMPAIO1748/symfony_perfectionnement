<?php

namespace App\DataFixtures;

use App\Entity\Command;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

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
        }

        $manager->flush();
    }
}
