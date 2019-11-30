<?php

namespace App\Controller\Rest;

use App\Entity\Product;
use App\Exception\ResourceValidationException;
use App\Repository\ProductRepository;
use App\Representation\Products;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

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
     *
     * @Cache(expires="tomorrow")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns product details",
     *     @SWG\Schema(
     *         type="array",
     *         example={"id": 10,"name": "bipbop","content": "description du bipbop","weight": 10,"available_at": "10/10/2019","ref": "bb","_links": {"self": {"href": "http://bilemo/api/products/10"}}},
     *         @SWG\Items(ref=@Model(type=Product::class))
     *     )
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returned when ressource is not found"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="'Invalid JWT Token' error appears when the token are not correct.
     'Expired JWT Token' error appears when token are expired. you must reload the token."
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="id number of the product"
     * )
     * @SWG\Tag(name="Product")
     * @Security(name="Bearer")
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
     * @Cache(expires="tomorrow")
     *
     * @Rest\View
     * @param ProductRepository $productRepository
     * @param ParamFetcherInterface $paramFetcher
     * @return Products
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of all products",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Product::class))
     *     )
     * )
     * @SWG\Response(
     *     response=401,
     *     description="'Invalid JWT Token' error appears when the token are not correct.
    'Expired JWT Token' error appears when token are expired. you must reload the token."
     * )
     * @SWG\Parameter(
     *     name="wordsearch",
     *     in="query",
     *     type="string",
     *     description="Search for a model name with a keyword"
     * )
     * @SWG\Tag(name="Product")
     * @Security(name="Bearer")
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
