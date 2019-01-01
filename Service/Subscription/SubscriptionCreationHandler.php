<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Service\Subscription;

use FTD\SaasBundle\Manager\SubscriptionManager;
use FTD\SaasBundle\Manager\UserManagerInterface;
use FTD\SaasBundle\Model\Subscription;
use FTD\SaasBundle\Service\Authentication;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SubscriptionCreationHandler implements SubscriptionCreationHandlerInterface
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var UserManagerInterface
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
     * @param Authentication       $authentication
     * @param UserManagerInterface $userManager
     * @param SubscriptionManager  $subscriptionManager
     * @param TranslatorInterface  $translator
     */
    public function __construct(
        Authentication $authentication,
        UserManagerInterface $userManager,
        SubscriptionManager $subscriptionManager,
        TranslatorInterface $translator
    ) {
        $this->authentication = $authentication;
        $this->userManager = $userManager;
        $this->subscriptionManager = $subscriptionManager;
        $this->translator = $translator;
    }

    /**
     * @param Subscription $subscription
     *
     * @return void
     */
    public function process(Subscription $subscription): void
    {
        $user = $this->userManager->create();
        $user->setUsername($this->authentication->getCurrentAccount()->getEmail());
        $user->setEmail($this->authentication->getCurrentAccount()->getEmail());
        $user->setAccount($this->authentication->getCurrentAccount());
        $this->authentication->getCurrentAccount()->setCurrentUser($user);
        $user->setSubscription($subscription);

        $this->userManager->update($user);
    }
}
