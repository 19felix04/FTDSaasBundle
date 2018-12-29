<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Event;

use FTD\SaasBundle\Model\Subscription;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SubscriptionEvent extends Event
{
    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * The function returns the Subscription-entity of the event.
     *
     * @return Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }
}
