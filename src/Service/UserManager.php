<?php

namespace App\Service;

use App\Entity\User;
use App\Validator\UserValidator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

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

    /**
     * @var Security
     */
    private $securityContext;

    public function __construct(EntityManagerInterface $manager, UserValidator $validator, Security $securityContext)
    {
        $this->manager = $manager;
        $this->validator = $validator;
        $this->securityContext = $securityContext;
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

        if(empty( $user->getClient())) {
            $user->setClient( $this->securityContext->getToken()->getUser());
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
