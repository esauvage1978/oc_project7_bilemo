<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Validator\ClientValidator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixtures extends Fixture
{
    /**
     * @var ClientValidator
     */
    private $validator;

    public function __construct(ClientValidator $validator)
    {
        $this->validator = $validator;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < count(self::DATA); ++$i) {
            $client = new Client();

            $client
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = 'Europe/Paris'))
                ->setEmail(self::DATA[$i]['email'])
                ->setName(self::DATA[$i]['name'])
                ->setPassword(self::DATA[$i]['password'])
                ->setCompagny(self::DATA[$i]['compagny']);

            if (!$this->validator->isValide($client)) {
                throw  new \InvalidArgumentException($this->validator->getErrors($client));
            }

            $manager->persist($client);

            $this->addReference('client-'.$i , $client);
        }
        for ($i = 0; $i < 10; ++$i) {
            $client = new Client();

            $client
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = 'Europe/Paris'))
                ->setCompagny($faker->company)
                ->setEmail($faker->companyEmail)
                ->setName($faker->userName)
                ->setPassword($faker->password);

            if (!$this->validator->isValide($client)) {
                throw  new \InvalidArgumentException($this->validator->getErrors($client));
            }

            $manager->persist($client);

            $this->addReference('client-'.($i + count(self::DATA)) , $client);
        }
        $manager->flush();
    }

    const DATA =
        [
            [
                'compagny' => 'Mylostuniver',
                'name' => 'Emmanuel Sauvage',
                'email' => 'emmanuel.sauvage@live.fr',
                'password' => 'mdp',
            ],
        ];


}
