<?php

namespace App\Validator;

use App\Entity\Client;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function count;

class ClientValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ConstraintViolationListInterface
     */
    private $errors;

    public function __construct( ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Client $client
     * @return bool
     */
    public function isValide(Client $client): bool
    {
        $this->initialiseError($client);

        return  !count($this->errors) ? true : false;
    }

    /**
     * @param Client $client
     */
    private function initialiseError(Client $client)
    {
        $this->errors = $this->validator->validate($client);
    }

    /**
     * @param Client $client
     * @return string|null
     */
    public function getErrors(Client $client): ?string
    {
        $this->initialiseError($client);

        return (string) $this->errors;
    }

}