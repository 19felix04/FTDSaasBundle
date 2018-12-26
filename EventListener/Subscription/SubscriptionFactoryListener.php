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
use FTD\SaasBundle\Event\UserEvent;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Manager\SubscriptionManager;
use FTD\SaasBundle\Manager\UserManager;
use FTD\SaasBundle\Service\Authentication;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SubscriptionFactoryListener implements EventSubscriberInterface
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var SubscriptionManager
     */
    private $subscriptionManager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param Authentication      $authentication
     * @param UserManager         $userManager
     * @param SubscriptionManager $subscriptionManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        Authentication $authentication,
        UserManager $userManager,
        SubscriptionManager $subscriptionManager,
        TranslatorInterface $translator
    ) {
        $this->authentication = $authentication;
        $this->userManager = $userManager;
        $this->subscriptionManager = $subscriptionManager;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FTDSaasBundleEvents::USER_CREATE => 'createSubscription',
            FTDSaasBundleEvents::SUBSCRIPTION_CREATE => 'createUser',
        ];
    }

    /**
     * @param UserEvent $userEvent
     */
    public function createSubscription(UserEvent $userEvent)
    {
        $user = $userEvent->getUser();

        if (null === $user->getSubscription()) {
            $subscription = $this->subscriptionManager->create();
            $subscription->addUser($user);
            $subscription->setName($this->translator->trans('factory.subscription.name', [], 'ftd_saas'));

            $this->subscriptionManager->update($subscription);
        }
    }

    /**
     * @param SubscriptionEvent $subscriptionEvent
     */
    public function createUser(SubscriptionEvent $subscriptionEvent)
    {
        $subscription = $subscriptionEvent->getSubscription();

        $user = $this->userManager->create();
        $user->setUsername($this->authentication->getCurrentAccount()->getEmail());
        $user->setEmail($this->authentication->getCurrentAccount()->getEmail());
        $user->setAccount($this->authentication->getCurrentAccount());
        $this->authentication->getCurrentAccount()->setCurrentUser($user);
        $user->setSubscription($subscription);

        $this->userManager->update($user);
    }
}
