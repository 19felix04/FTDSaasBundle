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

use FTD\SaasBundle\Model\Account;
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
        $user->setCreatedAt(new \DateTime());

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
     * @param int     $subscriptionID
     * @param Account $account
     *
     * @return User|null
     */
    public function getUserBySubscriptionIDAndAccount(int $subscriptionID, Account $account): ?User
    {
        return $this->entityManager->getRepository($this->getClass())->findOneBy([
            'subscription' => $subscriptionID,
            'account' => $account->getId(),
        ]);
    }

    /**
     * @return UserRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository($this->getClass());
    }
}
