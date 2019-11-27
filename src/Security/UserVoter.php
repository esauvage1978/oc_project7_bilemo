<?php

namespace App\Security;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{
    const UPDATE = 'update';
    const DELETE = 'delete';
    const CREATE = 'create';
    const SHOW = 'show';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::CREATE, self::UPDATE, self::DELETE, self::SHOW])) {
            return false;
        }

        if ($subject!==null and !$subject instanceof USER) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $client = $token->getUser();

        if (!$client instanceof Client) {
            return false;
        }

        /** @var User $user */
        $user = $subject;

        switch ($attribute) {
            case self::UPDATE:
                return $this->canUpdate($user, $client);
            case self::CREATE:
                return $this->canCreate($user, $client);
            case self::DELETE:
                return $this->canDelete($user, $client);
            case self::SHOW:
                return $this->canShow($user, $client);
        }

        throw new \LogicException('This code should not be reached!');
    }


    private function canUpdate(User $user, Client $client)
    {
        return $client === $user->getClient();
    }

    private function canCreate(?User $user, Client $client)
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return true;
        }
        return false;
    }

    private function canDelete(User $user, Client $client)
    {
        return $client === $user->getClient();
    }

    private function canShow(User $user, Client $client)
    {
        return $client === $user->getClient();
    }
}