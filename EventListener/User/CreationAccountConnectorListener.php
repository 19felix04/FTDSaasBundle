<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\EventListener\User;

use FTD\SaasBundle\Event\UserEvent;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Manager\AccountManagerInterface;
use FTD\SaasBundle\Model\Account;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class CreationAccountConnectorListener implements EventSubscriberInterface
{
    /**
     * @var AccountManagerInterface
     */
    private $accountManager;

    /**
     * @param AccountManagerInterface $accountManager
     */
    public function __construct(AccountManagerInterface $accountManager)
    {
        $this->accountManager = $accountManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FTDSaasBundleEvents::USER_CREATE => ['connectToAccount', 10],
        ];
    }

    /**
     * @param UserEvent $userEvent
     */
    public function connectToAccount(UserEvent $userEvent)
    {
        $account = $this->accountManager->getAccountByEmail($userEvent->getUser()->getEmail());
        if ($account instanceof Account) {
            $userEvent->getUser()->setAccount($account);
        }
    }
}
