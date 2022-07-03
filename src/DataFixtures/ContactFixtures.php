<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contact = new Contact();
        $contact->setCity("Thai Binh");
        $contact->setPhone("0354254414");
        $contact->setDirection("https://goo.gl/maps/irK8cbXT6YxBbfEs6");
        $manager->persist($contact);

        $contact = new Contact();
        $contact->setCity("Tan Lap");
        $contact->setPhone("0972208243");
        $contact->setDirection("https://goo.gl/maps/BzhjmtQ76P6AiFxr5");
        $manager->persist($contact);

        $manager->flush();
    }
}
