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
use FTD\SaasBundle\Form\SubscriptionType;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Manager\SubscriptionManager;
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
     * @var SubscriptionManager
     */
    private $subscriptionManager;

    /**
     * @var bool
     */
    private $settingsSoftwareAsAService;

    /**
     * @param Authentication      $authentication
     * @param CRUDHandler         $crudHandler
     * @param SubscriptionManager $subscriptionManager
     * @param bool                $settingsSoftwareAsAService
     */
    public function __construct(
        Authentication $authentication,
        CRUDHandler $crudHandler,
        SubscriptionManager $subscriptionManager,
        bool $settingsSoftwareAsAService
    ) {
        $this->authentication = $authentication;
        $this->crudHandler = $crudHandler;
        $this->subscriptionManager = $subscriptionManager;
        $this->settingsSoftwareAsAService = $settingsSoftwareAsAService;

        if (false === $this->settingsSoftwareAsAService) {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @Rest\Get("subscription")
     */
    public function getSubscriptionsAction()
    {
        return View::create([
            'results' => $this->subscriptionManager->getByAccount($this->authentication->getCurrentAccount()),
        ]);
    }

    /**
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\Post("subscription")
     */
    public function postSubscriptionAction()
    {
        $subscription = $this->subscriptionManager->create();

        return $this->crudHandler->handleUpdateRequest(
            $subscription,
            $this->subscriptionManager,
            SubscriptionType::class,
            'subscription',
            Response::HTTP_CREATED,
            FTDSaasBundleEvents::SUBSCRIPTION_CREATE,
            new SubscriptionEvent($subscription)
        );
    }
}
