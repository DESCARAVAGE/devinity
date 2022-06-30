<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private const NAMES = 
    [
        'Fabrice',
        'Kyle',
        'Dimitri',
    ];
    private const SECTORS = 
    [
        'Accountant',
        'Developer',
        'Front Design',
    ];
    private const IDEAS = 3;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $user = new User();
            $user->setName(self::NAMES[$i]);
            $user->setSector(self::SECTORS[$i]);
            $user->setRoles(['ROLE_CONTRIBUTOR']);
            $password = 'toto';
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $password
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $this->addReference('user' . $i, $user);
            for ($j = 0; $j < self::IDEAS; $j++) {
                $user->addIdea($this->getReference('idea' . $j));
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            IdeaFixtures::class,
        ];
    }
}
