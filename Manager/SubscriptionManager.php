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
use FTD\SaasBundle\Repository\SubscriptionRepository;

/**
 * The class SubscriptionManager manage the updating and finding of an subscription entity.
 *
 * @method SubscriptionRepository getRepository()
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SubscriptionManager extends BaseEntityManager implements SubscriptionManagerInterface
{
    /**
     * @return Subscription
     */
    public function create(): Subscription
    {
        $subscription = new \FTD\SaasBundle\Entity\Subscription();

        return $subscription;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return \FTD\SaasBundle\Entity\Subscription::class;
    }

    /**
     * @param Account $account
     *
     * @return \FTD\SaasBundle\Model\Subscription[]
     */
    public function getByAccount(Account $account) :array
    {
        return $this->getRepository()->findByAccount($account);
    }
}
