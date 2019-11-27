<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Validator\ClientValidator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientFixtures extends Fixture
{
    /**
     * @var ClientValidator
     */
    private $validator;

    private $passwordEncoder;

    public function __construct(ClientValidator $validator, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->validator = $validator;
        $this->passwordEncoder = $passwordEncoder;
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
                ->setPassword($this->passwordEncoder->encodePassword(
                    $client,self::DATA[$i]['password']))
                ->setCompagny(self::DATA[$i]['compagny']);

            if (!$this->validator->isValid($client)) {
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
                ->setPassword($this->passwordEncoder->encodePassword(
                    $client,
                    $faker->password));

            if (!$this->validator->isValid($client)) {
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
