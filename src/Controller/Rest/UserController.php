<?php

namespace App\Controller\Rest;

use App\Entity\User;
use App\Exception\ResourceValidationException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

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

        return $user;
    }
}
