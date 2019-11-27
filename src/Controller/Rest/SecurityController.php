<?php

namespace App\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route(name="api_login", path="/login_check",methods={"GET"})
     * @return JsonResponse
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
