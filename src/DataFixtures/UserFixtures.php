<?php
declare(strict_types=1);
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder )
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setUsername('admin');
         $user->setEmail('admin@localhost.local');
         $user->setRoles(['ROLE_ADMIN']);
         $user->setPassword($this->passwordEncoder->encodePassword($user,'Q@wertyuiop'));
         $manager->persist($user);

        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@localhost.local');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'Q@wertyuiop'));
        $manager->persist($user);

        $manager->flush();
    }
}
