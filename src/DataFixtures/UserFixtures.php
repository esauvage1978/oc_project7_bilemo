<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Validator\UserValidator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    /**
     * @var UserValidator
     */
    private $productValidator;

    public function __construct(UserValidator $productValidator)
    {
        $this->productValidator = $productValidator;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < count(self::DATA); ++$i) {
            $user = new User();

            $user
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = 'Europe/Paris'))
                ->setEmail(self::DATA[$i]['email'])
                ->setUsername(self::DATA[$i]['username']);

            if (!$this->productValidator->isValide($user)) {
                throw  new \InvalidArgumentException($this->productValidator->getErrors($user));
            }

            $manager->persist($user);
        }
        for ($i = 0; $i < 100; ++$i) {
            $user = new User();

            $user
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = 'Europe/Paris'))
                ->setEmail($faker->email)
                ->setUsername($faker->userName);

            if (!$this->productValidator->isValide($user)) {
                throw  new \InvalidArgumentException($this->productValidator->getErrors($user));
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
}
