<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FTD\SaasBundle\Event\SubscriptionEvent;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Manager\SubscriptionManagerInterface;
use FTD\SaasBundle\Service\Authentication;
use FTD\SaasBundle\Service\Request\CRUDHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * The class contains API-Endpoints to handle Subscription-entities.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SubscriptionController
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var CRUDHandler
     */
    private $crudHandler;

    /**
     * @var SubscriptionManagerInterface
     */
    private $subscriptionManager;

    /**
     * @var string
     */
    private $subscriptionTypeClass;

    /**
     * @var bool
     */
    private $settingsSoftwareAsAService;

    /**
     * @param Authentication               $authentication
     * @param CRUDHandler                  $crudHandler
     * @param SubscriptionManagerInterface $subscriptionManager
     * @param string                       $subscriptionTypeClass
     * @param bool                         $settingsSoftwareAsAService
     */
    public function __construct(
        Authentication $authentication,
        CRUDHandler $crudHandler,
        SubscriptionManagerInterface $subscriptionManager,
        string $subscriptionTypeClass,
        bool $settingsSoftwareAsAService
    ) {
        $this->authentication = $authentication;
        $this->crudHandler = $crudHandler;
        $this->subscriptionManager = $subscriptionManager;
        $this->subscriptionTypeClass = $subscriptionTypeClass;
        $this->settingsSoftwareAsAService = $settingsSoftwareAsAService;

        if (false === $this->settingsSoftwareAsAService) {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @Rest\Get("subscriptions")
     */
    public function getSubscriptionsAction()
    {
        return View::create(
            [
                'results' => $this->subscriptionManager->getByAccount($this->authentication->getCurrentAccount()),
            ]
        );
    }

    /**
     * @return View
     *
     * @Rest\Put("subscriptions/current")
     */
    public function putCurrentSubscriptionAction()
    {
        $subscription = $this->authentication->getCurrentSubscription();

        if($subscription === null) {
            return View::create([], Response::HTTP_NOT_FOUND);
        }

        return $this->crudHandler->handleUpdateRequest(
            $subscription,
            $this->subscriptionManager,
            $this->subscriptionTypeClass,
            'subscription',
            Response::HTTP_OK,
            FTDSaasBundleEvents::SUBSCRIPTION_UPDATE,
            new SubscriptionEvent($subscription)
        );
    }

    /**
     * @return View
     *
     * @Rest\Get("subscriptions/current")
     */
    public function getCurrentSubscriptionAction()
    {
        $subscription = $this->authentication->getCurrentSubscription();

        if($subscription === null) {
            return View::create([], Response::HTTP_NOT_FOUND);
        }

        return View::create([
            'subscription' => $subscription
        ]);
    }

    /**
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\Post("subscriptions")
     */
    public function postSubscriptionAction()
    {
        $subscription = $this->subscriptionManager->create();

        return $this->crudHandler->handleUpdateRequest(
            $subscription,
            $this->subscriptionManager,
            $this->subscriptionTypeClass,
            'subscription',
            Response::HTTP_CREATED,
            FTDSaasBundleEvents::SUBSCRIPTION_CREATE,
            new SubscriptionEvent($subscription)
        );
    }
}
