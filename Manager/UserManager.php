<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Manager;

use FTD\SaasBundle\Model\User;
use FTD\SaasBundle\Repository\UserRepository;

/**
 * The class UserManager manage the updating and finding of an user entity.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class UserManager extends BaseEntityManager implements UserManagerInterface
{
    /**
     * @return User
     */
    public function create(): User
    {
        $user = new \FTD\SaasBundle\Entity\User();

        if (null !== ($subscription = $this->authentication->getCurrentSubscription())) {
            $user->setSubscription($this->authentication->getCurrentSubscription());
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return \FTD\SaasBundle\Entity\User::class;
    }

    /**
     * @param string $email
     *
     * @return User[]
     */
    public function getUsersByEmail(string $email): array
    {
        return $this->getRepository()->findBy(['email' => $email]);
    }

    /**
     * @return UserRepository
     */
    public function getRepository(): UserRepository
    {
        return $this->entityManager->getRepository($this->getClass());
    }
}
