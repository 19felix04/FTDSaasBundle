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
use FTD\SaasBundle\Manager\AccountManager;
use FTD\SaasBundle\Manager\SubscriptionManager;
use FTD\SaasBundle\Manager\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class AccountConnectionListener implements EventSubscriberInterface
{
    /**
     * @var AccountManager
     */
    private $accountManager;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var SubscriptionManager
     */
    private $subscriptionManager;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @param AccountManager       $accountManager
     * @param SubscriptionManager  $subscriptionManager
     * @param TranslatorInterface  $translator
     * @param UserManagerInterface $userManager
     */
    public function __construct(
        AccountManager $accountManager,
        SubscriptionManager $subscriptionManager,
        TranslatorInterface $translator,
        UserManagerInterface $userManager
    ) {
        $this->accountManager = $accountManager;
        $this->subscriptionManager = $subscriptionManager;
        $this->translator = $translator;
        $this->userManager = $userManager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FTDSaasBundleEvents::ACCOUNT_CREATE => 'connectAccountToExistingAccount',
        ];
    }

    /**
     * @param AccountEvent $accountEvent
     *
     * @throws \Exception
     */
    public function connectAccountToExistingAccount(AccountEvent $accountEvent)
    {
        $account = $accountEvent->getAccount();
        $users = $this->userManager->getUsersByEmail($account->getEmail());

        if (count($users) > 0) {
            foreach ($users as $i => $user) {
                $account->addUser($user);
                if (0 === $i) {
                    $user->setAccount($account);
                    $account->setCurrentUser($user);
                    $this->userManager->update($user);
                    $this->accountManager->update($account);

                    return;
                }
            }
        }
    }
}
