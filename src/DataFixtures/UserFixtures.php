<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct (UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User;
        $user->setUsername("User");
        $user->setPassword($this->hasher->hashPassword($user,"123456"));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        //tạo role Admin
        $user = new User;
        $user->setUsername("Admin");
        $user->setPassword($this->hasher->hashPassword($user,"123456"));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        //tạo role Manager
        $user = new User;
        $user->setUsername("Manager");
        $user->setPassword($this->hasher->hashPassword($user,"123456"));
        $user->setRoles(['ROLE_MANAGER']);
        $manager->persist($user);

        $manager->flush();
    }
}
