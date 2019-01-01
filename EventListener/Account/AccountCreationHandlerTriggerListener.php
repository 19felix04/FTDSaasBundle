<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\EventListener\Account;

use FTD\SaasBundle\Event\AccountEvent;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Manager\UserManagerInterface;
use FTD\SaasBundle\Service\Account\AccountCreationHandlerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class AccountCreationHandlerTriggerListener implements EventSubscriberInterface
{
    /**
     * @var AccountCreationHandlerInterface
     */
    private $accountCreationHandler;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @param AccountCreationHandlerInterface $accountCreationHandler
     * @param UserManagerInterface            $userManager
     */
    public function __construct(
        AccountCreationHandlerInterface $accountCreationHandler,
        UserManagerInterface $userManager
    ) {
        $this->accountCreationHandler = $accountCreationHandler;
        $this->userManager = $userManager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FTDSaasBundleEvents::ACCOUNT_CREATE => 'triggerHandler',
        ];
    }

    /**
     * @param AccountEvent $accountEvent
     */
    public function triggerHandler(AccountEvent $accountEvent)
    {
        $account = $accountEvent->getAccount();
        $users = $this->userManager->getUsersByEmail($account->getEmail());

        $this->accountCreationHandler->process($account, $users);
    }
}
