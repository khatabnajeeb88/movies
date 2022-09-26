<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actor = new Actor();
        $actor->setName('Khatab Khatir');
        $manager->persist($actor);

        $actor2 = new Actor();
        $actor2->setName('Jerry schnfield');
        $manager->persist($actor2);

        $actor3 = new Actor();
        $actor3->setName('Lara');
        $manager->persist($actor3);

        $actor4 = new Actor();
        $actor4->setName('Lana');
        $manager->persist($actor4);

        $manager->flush();

        $this->addReference('khatab', $actor);
        $this->addReference('jerry', $actor2);
        $this->addReference('lara', $actor3);
        $this->addReference('lana', $actor4);
    }
}
