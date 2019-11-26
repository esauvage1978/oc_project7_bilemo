<?php

namespace App\Controller\Rest;

use App\Entity\Product;
use App\Exception\ResourceValidationException;
use App\Repository\ProductRepository;
use App\Representation\Products;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path="/products/{id}",
     *     name="api_product_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @param string $id
     * @param Product $product
     * @return Product
     * @Rest\View(StatusCode = 200)
     *
     * @throws ResourceValidationException
     */
    public function showAction(string $id, Product $product = null): Product
    {
        if (!$product) {
            throw new ResourceValidationException(
                sprintf('Ressource %d not found', $id));
        }

        return $product;
    }

    /**
     * @Rest\Get("/products", name="app_product_list")
     *
     * @Rest\QueryParam(
     *     name="wordsearch",
     *     requirements="[a-zA-Z0-9]*",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="5",
     *     description="Max number of articles per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     *
     * @Rest\View
     * @param ProductRepository $productRepository
     * @param ParamFetcherInterface $paramFetcher
     * @return Products
     */
    public function listAction(ParamFetcherInterface $paramFetcher,ProductRepository $productRepository)
    {
        $pager = $productRepository->search(
            $paramFetcher->get('wordsearch'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Products($pager,$paramFetcher->get('wordsearch'));
    }
}
