<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\EntityListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use FTD\SaasBundle\Model\ApiResource;
use FTD\SaasBundle\Model\Subscription;
use FTD\SaasBundle\Service\Authentication;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class PermissionSettingListener implements EventSubscriber
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [Events::postLoad, Events::prePersist];
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     */
    public function postLoad(LifecycleEventArgs $lifecycleEventArgs)
    {
        $entity = $lifecycleEventArgs->getEntity();

        if ($entity instanceof ApiResource) {
            $this->setApiResourcePermissions($entity);
        }
        if ($entity instanceof Subscription) {
            $this->setSubscriptionPermissions($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     */
    public function prePersist(LifecycleEventArgs $lifecycleEventArgs)
    {
        $entity = $lifecycleEventArgs->getEntity();

        if ($entity instanceof ApiResource) {
            $this->setApiResourcePermissions($entity);
        }
        if ($entity instanceof Subscription) {
            $this->setSubscriptionPermissions($entity);
        }
    }

    /**
     * @param ApiResource $apiResource
     */
    public function setApiResourcePermissions(ApiResource $apiResource)
    {
        $user = $this->authentication->getCurrentUser();

        if (null !== $user) {
            $apiResource->setUserCanDelete($apiResource->checkUserCanDelete($user));
            $apiResource->setUserCanEdit($apiResource->checkUserCanEdit($user));
            $apiResource->setUserCanSee($apiResource->checkUserCanSee($user));
        }
    }

    /**
     * @param Subscription $subscription
     */
    public function setSubscriptionPermissions(Subscription $subscription)
    {
        $user = $this->authentication->getCurrentUser();

        if (null !== $user) {
            $subscription->setUserCanEdit($subscription->checkUserCanEdit($user));
        }
    }
}
