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

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
interface SubscriptionManagerInterface extends CRUDEntityManagerInterface
{
    /**
     * The function has to contain logic to create a subscription object.
     *
     * @return Subscription
     */
    public function create(): Subscription;

    /**
     * The function has to contains logic to save the passing subscription entity to database.
     *
     * @param object $account
     * @param bool   $flush
     *
     * @return mixed
     */
    public function update($account, $flush = true);

    /**
     * @param Account $account
     *
     * @return Subscription[]
     */
    public function getByAccount(Account $account);

    /**
     * The function returns the class-name of the entity which represents the subscription.
     *
     * @return string
     */
    public function getClass(): string;
}
