<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Swagger\Annotations as SWG;

class SecurityController extends AbstractController
{

    /**
     * @Route(name="api_login", path="/login_check",methods={"GET"})
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="Returns valid token for Client. This is this token you can use for get list of products, users...",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="'Invalid JSON' error appears when customer's account values are not present.
      in Postman / body (raw), you can use :
        {
            'username': 'username of client',
            'password': 'password of client
        }"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="'Invalid credentials' Error apprears when customer's account are not correct. you can check this on this page https://bilemo.mylostuniver.com/"
     * )
     * @SWG\Parameter(
     *     name="Connexion",
     *     in="body",
     *     required=true,
     *         description="username and password of Client",
     *         @SWG\Schema(
     *            type="object",
     *            @SWG\Property(property="username", type="string"),
     *            @SWG\Property(property="password", type="string"),
     *          example={"username":"manu@live.fr","password":"mdp"}
     *         )
     * )
     * @SWG\Tag(name="Client")
     *
     */
    public function api_login(): JsonResponse
    {
        $Client = $this->getUser();

        return new JsonResponse([
            'Username' => $Client->getUsername(),
            'roles' => $Client->getRoles(),
        ]);
    }


}
