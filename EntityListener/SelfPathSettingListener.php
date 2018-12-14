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
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Subscriber listen to load and update events of ApiResource entities to set paths.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SelfPathSettingListener implements EventSubscriber
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(Events::postLoad, Events::postUpdate);
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     */
    public function postUpdate(LifecycleEventArgs $lifecycleEventArgs)
    {
        $this->setSelfPath($lifecycleEventArgs->getEntity());
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     */
    public function postLoad(LifecycleEventArgs $lifecycleEventArgs)
    {
        $this->setSelfPath($lifecycleEventArgs->getEntity());
    }

    /**
     * @param $entity
     */
    private function setSelfPath($entity)
    {
        if ($entity instanceof ApiResource) {
            $entity->setSelf(sprintf(
                '%sapi/%s/%s',
                $this->requestStack->getCurrentRequest()->getBaseUrl(),
                $entity->getApiPath(),
                $entity->getId()
            ));
        }
    }
}
