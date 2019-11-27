<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ConstraintViolationListInterface
     */
    private $errors;

    /**
     * ProductValidator constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isValid(User $user): bool
    {
        $this->initialiseError($user);

        return  !count($this->errors) ? true : false;
    }

    /**
     * @param User $user
     */
    private function initialiseError(User $user)
    {
        $this->errors = $this->validator->validate($user);
    }

    /**
     * @param User $user
     * @return string|null
     */
    public function getErrors(User $user): ?string
    {
        $this->initialiseError($user);

        return (string) $this->errors;
    }
}
