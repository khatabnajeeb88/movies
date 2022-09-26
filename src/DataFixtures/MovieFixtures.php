<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle("UP");
        $movie->setReleaseYear(2008);
        $movie->setDescription("UP is a great movie");
        $movie->setImagePath("https://m.media-amazon.com/images/M/MV5BMTk3NDE2NzI4NF5BMl5BanBnXkFtZTgwNzE1MzEyMTE@._V1_FMjpg_UX1000_.jpg");
        
        // Data to pivot table
        $movie->addActor($this->getReference('khatab'));
        $movie->addActor($this->getReference('lara'));
        $movie->addActor($this->getReference('lana'));
        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2->setTitle("Bee");
        $movie2->setReleaseYear(2004);
        $movie2->setDescription("Bee is a great movie");
        $movie2->setImagePath("https://resizing.flixster.com/18icyRbPRhjrgvKB_7-9Z8lNrI0=/ems.cHJkLWVtcy1hc3NldHMvbW92aWVzLzA0MzljODE3LTgzMDMtNGRiOS1iOTM0LTM1ODk1ODMwNDIyOC53ZWJw");
        
        // Data to pivot table
        $movie2->addActor($this->getReference('jerry'));
        $manager->persist($movie2);

        $manager->flush();
    }
}
