<?php

namespace App\Controller\Rest;

use App\Entity\Product;
use App\Exception\ResourceValidationException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path="/products/{id}",
     *     name="api_product_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @param Product $product
     *
     * @return Product
     * @Rest\View(StatusCode = 200)
     *
     * @throws ResourceValidationException
     */
    public function showAction(string $id, Product $product = null): Product
    {
        if (!$product) {
            throw new ResourceValidationException(sprintf('Ressource %d not found', $id));
        }

        return $product;
    }
}
