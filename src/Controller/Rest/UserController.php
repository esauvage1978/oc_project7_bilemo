<?php

namespace App\Controller\Rest;

use App\Entity\User;
use App\Exception\ResourceValidationException;
use App\Repository\UserRepository;
use App\Representation\Users;
use App\Security\UserVoter;
use App\Service\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class UserController extends AbstractFOSRestController
{


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
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of all users related to an authentified client",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class))
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
     *     description="Search for a username with a keyword"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
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
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns user details",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class))
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
     * @SWG\Response(
     *     response=403,
     *     description="'Access Denied' error appears when the user exists but belongs to another client. It is therefore not possible to consult it."
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="id number of the user"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
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
     * @Rest\Delete(
     *     path = "/users/{id}",
     *     name = "api_user_delete",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View( StatusCode = 204)
     * @param string $id
     * @param User $user
     * @param UserRepository $repo
     * @param UserManager $manager
     * @return string
     * @throws ResourceValidationException
     *
     * @SWG\Response(
     *     response=204,
     *     description="User are deleted",
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
     * @SWG\Response(
     *     response=403,
     *     description="'Access Denied' error appears when the user exists but belongs to another client. It is therefore not possible to delete it."
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="id number of the user"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     */
    public function deleteAction( string $id, UserRepository $repo,  UserManager $manager, User $user=null)
    {
        if (!$user) {
            throw new ResourceValidationException(
                sprintf('Ressource %d not found', $id));
        }
        $this->denyAccessUnlessGranted(UserVoter::DELETE, $user);

        $manager->remove($user);
    }

    /**
     * @Rest\Put(
     *     path = "/users/{id}",
     *     name = "api_user_modify",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View( StatusCode = 200)
     * @param User $user
     * @param UserManager $manager
     * @param Request $request
     * @return User
     * @throws ResourceValidationException
     *
     * @SWG\Response(
     *     response=201,
     *     description="Return user modified ",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class)),
     *     )
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returned when a violation is raised by validation"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="'Invalid JWT Token' error appears when the token are not correct.
    'Expired JWT Token' error appears when token are expired. you must reload the token."
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returned when you are not authentified"
     * )
     * @SWG\Parameter(
     *     name="User",
     *     in="body",
     *     required=true,
     *         description="username and/or email of User",
     *         @SWG\Schema(
     *            type="object",
     *            @SWG\Property(property="username", type="string"),
     *            @SWG\Property(property="email", type="string"),
     *          example={"username":"manu","email":"manu@live.fr"}
     *         )
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     */
    public function modifyAction(User $user, UserManager $manager, Request $request)
    {
        $this->denyAccessUnlessGranted(UserVoter::UPDATE, $user);

        //Utilisation de request permettant l'envoi d'un json partiel (username ou email)
        //tout en restreignant les champs modifiables
        $request->get('username') &&
        $user->setUsername($request->get('username')) ;

        $request->get('email') &&
        $user->setEmail($request->get('email')) ;

        if(!$manager->update($user)  ) {
            $message = 'The JSON sent contains invalid data. ' . $manager->getErrors($user);
            throw new ResourceValidationException($message);
        }

        return $user;
    }

    /**
     * @Rest\Post("/users",
     *     name="api_user_create")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     *
     * @param User $user
     * @param  UserManager $manager
     *
     * @return User
     *
     * @throws ResourceValidationException Error to create User
     * @SWG\Response(
     *     response=201,
     *     description="User created and associated to the current client",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returned when a violation is raised by validation"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="'Invalid JWT Token' error appears when the token are not correct.
    'Expired JWT Token' error appears when token are expired. you must reload the token."
     * )
     * @SWG\Parameter(
     *     name="User",
     *     in="body",
     *     required=true,
     *         description="username and email of User",
     *         @SWG\Schema(
     *            type="object",
     *            @SWG\Property(property="username", type="string"),
     *            @SWG\Property(property="email", type="string"),
     *          example={"username":"manu","email":"manu@live.fr"}
     *         )
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     */
    public function createAction(User $user, UserManager $manager)
    {

        if(!$manager->update($user)  ) {
            $message = 'The JSON sent contains invalid data. ' . $manager->getErrors($user);
            throw new ResourceValidationException($message);
        }

        return $user;
    }
}
