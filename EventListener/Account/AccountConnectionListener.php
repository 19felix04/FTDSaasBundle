<?php

namespace FTD\SaasBundle\EventListener\Account;

use FTD\SaasBundle\Event\AccountEvent;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Manager\AccountManager;
use FTD\SaasBundle\Manager\SubscriptionManager;
use FTD\SaasBundle\Manager\UserManager;
use FTD\SaasBundle\Model\Account;
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
     * @var bool $settingsSoftwareAsAService
     */
    private $settingsSoftwareAsAService;

    /**
     * @var bool
     */
    private $settingsCreateUserAutomatically;

    /**
     * @var bool
     */
    private $settingsCreateSubscriptionAutomatically;

    /**
     * @var UserManager
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
     * @param AccountManager      $accountManager
     * @param SubscriptionManager $subscriptionManager
     * @param bool                $settingsCreateUserAutomatically
     * @param bool                $settingsCreateSubscriptionAutomatically
     * @param bool                $settingsSoftwareAsAService
     * @param TranslatorInterface $translator
     * @param UserManager         $userManager
     */
    public function __construct(
        AccountManager $accountManager,
        SubscriptionManager $subscriptionManager,
        bool $settingsCreateUserAutomatically,
        bool $settingsCreateSubscriptionAutomatically,
        bool $settingsSoftwareAsAService,
        TranslatorInterface $translator,
        UserManager $userManager
    ) {
        $this->accountManager = $accountManager;
        $this->settingsCreateUserAutomatically = $settingsCreateUserAutomatically;
        $this->settingsCreateSubscriptionAutomatically = $settingsCreateSubscriptionAutomatically;
        $this->settingsSoftwareAsAService = $settingsSoftwareAsAService;
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
            FTDSaasBundleEvents::ACCOUNT_CREATE => 'connectOrCreateUser',
        ];
    }

    /**
     * @param AccountEvent $accountEvent
     *
     * @throws \Exception
     */
    public function connectOrCreateUser(AccountEvent $accountEvent)
    {
        $account = $accountEvent->getAccount();
        $users = $this->userManager->getUsersByEmail($account->getEmail());

        if (count($users) > 0) {
            foreach ($users as $i => $user) {
                $account->addUser($user);
                if ($i === 0) {
                    $user->setAccount($account);
                    $account->setCurrentUser($user);

                    $this->userManager->update($user);
                }

                $this->accountManager->update($account);
            }

            return;
        }

        if ($this->settingsCreateUserAutomatically) {
            $user = $this->userManager->create();
            $user->setUsername($account->getEmail());
            $user->setEmail($account->getEmail());
            $user->setLastActivityAt(new \DateTime());
            $user->setAccount($account);

            $account->setCurrentUser($user);
            $this->userManager->update($user);

            if (
                $this->settingsSoftwareAsAService === true
                && $this->settingsCreateSubscriptionAutomatically
            ) {
                $subscription = $this->subscriptionManager->create();
                $subscription->setName($this->translator->trans('factory.subscription.name', [], 'ftd_saas'));
                $subscription->addUser($user);
                $this->subscriptionManager->update($subscription);
            }
        }
    }
}
