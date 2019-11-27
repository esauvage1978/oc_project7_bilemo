<?php

namespace App\Controller\Rest;

use App\Entity\User;
use App\Exception\ResourceValidationException;
use App\Repository\UserRepository;
use App\Representation\Users;
use App\Security\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;

class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path="/users/{id}",
     *     name="api_user_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @param string $id
     * @param User $user
     * @return User
     * @Rest\View(StatusCode = 200)
     *
     * @throws ResourceValidationException
     */
    public function showAction(string $id, User $user = null): User
    {
        if (!$user) {
            throw new ResourceValidationException(
                sprintf('Ressource %d not found', $id));
        }

        $this->denyAccessUnlessGranted(UserVoter::SHOW, $user);

        return $user;
    }

    /**
     * @Rest\Get("/users", name="app_user_list")
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
     *     default="10",
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
     * @param UserRepository $userRepository
     * @param ParamFetcherInterface $paramFetcher
     * @return Users
     *
     */
    public function listAction(ParamFetcherInterface $paramFetcher,UserRepository $userRepository)
    {
        $client = $this->getUser();
        $pager = $userRepository->search(
            $client->getId(),
            $paramFetcher->get('wordsearch'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Users($pager,$paramFetcher->get('wordsearch'));
    }

    /**
     * @Rest\Delete(
     *     path = "/users/{id}",
     *     name = "api_user_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View( StatusCode = 204)
     * @param int $id
     * @param UserRepository $repo
     * @param EntityManagerInterface $manager
     * @return string
     * @throws ResourceValidationException
     *
     *
     */
    public function deleteAction(int $id,  UserRepository $repo,  EntityManagerInterface $manager)
    {
        $user=$repo->findOneBy(['id'=>$id]);


        if (!$user) {
            $message = 'No users match the number ' . $id;
            throw new ResourceValidationException($message);
        }

        $this->denyAccessUnlessGranted(UserVoter::DELETE, $user);

        $manager->remove($user);
        $manager->flush();
    }
}
