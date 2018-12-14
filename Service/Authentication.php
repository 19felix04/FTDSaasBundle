<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Service;

use FTD\SaasBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * The class contains functions to get data about the logged in user.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class Authentication
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * Constructor with injecting core authentication service.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * The function returns the current user or null if no user logged in.
     *
     * @return User|null|object
     */
    public function getUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

    /**
     * The function returns the current user subscription or null if no user logged in.
     *
     * @return \FTD\SaasBundle\Entity\Subscription|null
     */
    public function getCurrentSubscription()
    {
        if ($this->getUser() instanceof User) {
            return $this->getUser()->getSubscription();
        }

        return null;
    }
}
