<?php

namespace FTD\SaasBundle\EntityListener;

use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use FTD\SaasBundle\Entity\Account;
use FTD\SaasBundle\Entity\Subscription;
use FTD\SaasBundle\Entity\User;
use FTD\SaasBundle\Manager\AccountManagerInterface;
use FTD\SaasBundle\Manager\SubscriptionManagerInterface;
use FTD\SaasBundle\Manager\UserManagerInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class ManagerResolveTargetEntityListener extends ResolveTargetEntityListener
{
    /**
     * @param AccountManagerInterface      $accountManager
     * @param SubscriptionManagerInterface $subscriptionManager
     * @param UserManagerInterface         $userManager
     */
    public function __construct(
        AccountManagerInterface $accountManager,
        SubscriptionManagerInterface $subscriptionManager,
        UserManagerInterface $userManager
    ) {
        $this->addResolveTargetEntity(Account::class, $accountManager->getClass(), []);
        $this->addResolveTargetEntity(Subscription::class, $subscriptionManager->getClass(), []);
        $this->addResolveTargetEntity(User::class, $userManager->getClass(), []);
    }
}
