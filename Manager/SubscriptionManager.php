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

use FTD\SaasBundle\Entity\Account;
use FTD\SaasBundle\Entity\Subscription;
use FTD\SaasBundle\Repository\SubscriptionRepository;

/**
 * The class SubscriptionManager manage the updating and finding of an subscription entity.
 *
 * @method SubscriptionRepository getRepository()
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SubscriptionManager extends BaseEntityManager
{
    /**
     * @return Subscription
     */
    public function create()
    {
        $subscription = new Subscription();

        return $subscription;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return Subscription::class;
    }

    /**
     * @param Account $account
     *
     * @return Subscription[]
     */
    public function getByAccount(Account $account)
    {
        return $this->getRepository()->findByAccount($account);
    }
}
