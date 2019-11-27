<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Validator\UserValidator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture  implements DependentFixtureInterface
{
    /**
     * @var UserValidator
     */
    private $validator;

    public function __construct(UserValidator $validator)
    {
        $this->validator = $validator;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < count(self::DATA); ++$i) {
            $user = new User();

            $user
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = 'Europe/Paris'))
                ->setEmail(self::DATA[$i]['email'])
                ->setUsername(self::DATA[$i]['username'])
                ->setClient($this->getReference('client-0'));

            if (!$this->validator->isValid($user)) {
                throw  new \InvalidArgumentException($this->validator->getErrors($user));
            }

            $manager->persist($user);

            $this->addReference('user-'.$i , $user);
        }
        for ($i = 0; $i < 100; ++$i) {
            $user = new User();

            $user
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = 'Europe/Paris'))
                ->setEmail($faker->email)
                ->setUsername($faker->userName)
                ->setClient($this->getReference('client-' . mt_rand(0, 9+count(ClientFixtures::DATA))));

            if (!$this->validator->isValid($user)) {
                throw  new \InvalidArgumentException($this->validator->getErrors($user));
            }

            $manager->persist($user);

        }
        $manager->flush();
    }

    const DATA =
        [
            [
                'username' => 'Paul Bonte',
                'email' => 'amz_kergava@outlook.fr',
            ],
            [
                'username' => 'Emmanuel Sauvage',
                'email' => 'emmanuel.sauvage@live.fr',
            ],
        ];

    public function getDependencies()
    {
        return array(

            ClientFixtures::class

        );
    }
}
