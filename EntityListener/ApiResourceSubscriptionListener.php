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
use FTD\SaasBundle\Service\Authentication;

/**
 * The class listens to database events and sets the current subscription to these entities.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class ApiResourceSubscriptionListener implements EventSubscriber
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var bool
     */
    private $settingsSoftwareAsAService;

    /**
     * Constructor with injecting authentication service to get current Subscription.
     *
     * @param Authentication $authentication
     * @param bool           $settingsSoftwareAsAService
     */
    public function __construct(
        Authentication $authentication,
        bool $settingsSoftwareAsAService
    ) {
        $this->authentication = $authentication;
        $this->settingsSoftwareAsAService = $settingsSoftwareAsAService;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate, Events::prePersist,
        ];
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     */
    public function preUpdate(LifecycleEventArgs $lifecycleEventArgs)
    {
        $this->setSubscriptionOnApiResource($lifecycleEventArgs->getEntity());
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     */
    public function prePersist(LifecycleEventArgs $lifecycleEventArgs)
    {
        $this->setSubscriptionOnApiResource($lifecycleEventArgs->getEntity());
    }

    /**
     * The function checks if the passing object is an instance of ApiResource and sets the current subscription.
     *
     * @param $entity
     */
    public function setSubscriptionOnApiResource($entity)
    {
        if (
            true === $this->settingsSoftwareAsAService
            && $entity instanceof ApiResource
            && null === $entity->getSubscription()
            && null !== ($subscription = $this->authentication->getCurrentSubscription())
        ) {
            $entity->setSubscription($subscription);
        }
    }
}
