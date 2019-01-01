<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\EventListener\Subscription;

use FTD\SaasBundle\Event\SubscriptionEvent;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Service\Subscription\SubscriptionCreationHandlerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SubscriptionCreationHandlerTriggerListener implements EventSubscriberInterface
{
    /**
     * @var SubscriptionCreationHandlerInterface
     */
    private $subscriptionCreationHandler;

    /**
     * @param SubscriptionCreationHandlerInterface $subscriptionCreationHandler
     */
    public function __construct(
        SubscriptionCreationHandlerInterface $subscriptionCreationHandler
    ) {
        $this->subscriptionCreationHandler = $subscriptionCreationHandler;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FTDSaasBundleEvents::SUBSCRIPTION_CREATE => 'triggerHandler',
        ];
    }

    /**
     * @param SubscriptionEvent $subscriptionEvent
     */
    public function triggerHandler(SubscriptionEvent $subscriptionEvent)
    {
        $subscription = $subscriptionEvent->getSubscription();
        $this->subscriptionCreationHandler->process($subscription);
    }
}
