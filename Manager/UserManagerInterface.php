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
use FTD\SaasBundle\Model\Subscription;
use FTD\SaasBundle\Model\User;

/**
 * The class UserManager manage the updating and finding of an user entity.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
interface UserManagerInterface extends CRUDEntityManagerInterface
{
    /**
     * @return User
     */
    public function create(): User;

    /**
     * @param string $email
     *
     * @return User[]
     */
    public function getUsersByEmail(string $email): array;

    /**
     * The function returns the class-name of the entity which represents the user.
     *
     * @return string
     */
    public function getClass(): string;

    /**
     * @param int     $subscriptionID
     * @param Account $account
     *
     * @return User|null
     */
    public function getUserBySubscriptionIDAndAccount(int $subscriptionID, Account $account): ?User;

    /**
     * The functions returns a user with the passing subscription and the passing username.
     * If not user is found, null will returned.
     *
     * @param Subscription $subscription
     * @param string       $username
     *
     * @return User|null
     */
    public function getUserBySubscriptionAndUsername(
        Subscription $subscription,
        string $username
    ): ?User;

    /**
     * The functions returns a user with the passing subscription and the passing email.
     * If not user is found, null will returned.
     *
     * @param Subscription $subscription
     * @param string       $email
     *
     * @return User|null
     */
    public function getUserBySubscriptionAndEmail(
        Subscription $subscription,
        string $email
    ): ?User;
}
