<?php

namespace App\Validator;

use App\Entity\Product;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductValidator
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
     * @param Product $product
     * @return bool
     */
    public function isValide(Product $product): bool
    {
        $this->initialiseError($product);

        return  !count($this->errors) ? true : false;
    }

    /**
     * @param Product $product
     */
    private function initialiseError(Product $product)
    {
        $this->errors = $this->validator->validate($product);
    }

    /**
     * @param Product $product
     * @return string|null
     */
    public function getErrors(Product $product): ?string
    {
        $this->initialiseError($product);

        return (string) $this->errors;
    }
}
