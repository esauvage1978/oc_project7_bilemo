<?php

namespace App\Service;

use App\Entity\User;
use App\Validator\UserValidator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var UserValidator
     */
    private $validator;

    public function __construct(EntityManagerInterface $manager, UserValidator $validator)
    {
        $this->manager = $manager;
        $this->validator = $validator;
    }

    public function update(User $entity): bool
    {
        $this->initialise($entity);

        if (!$this->validator->isValid($entity)) {
            return false;
        }

        $this->manager->persist($entity);
        $this->manager->flush();

        return true;
    }

    public function initialise(User $user)
    {
        if(!$user->getCreatedAt()) {
            $user->setCreatedAt(new \DateTime());
        } else {
            $user->setModifyAt(new \DateTime());
        }

        return true;
    }

    public function getErrors(User $entity)
    {
        return $this->validator->getErrors($entity);
    }

    public function remove(User $entity)
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }

}
