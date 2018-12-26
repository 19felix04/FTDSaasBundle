<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\Tests\Controller;

use FTD\SaasBundle\Controller\SubscriptionController;
use FTD\SaasBundle\Manager\SubscriptionManager;
use FTD\SaasBundle\Service\Authentication;
use FTD\SaasBundle\Service\Request\CRUDHandler;
use FTD\SaasBundle\Tests\TestSubscription;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubscriptionControllerTest extends TestCase
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
     * {@inheritdoc}
     */
    public function setUp()
    {
        $subscription = new TestSubscription();
        $subscription->setId(10);

        $this->authentication = $this->createMock(Authentication::class);
        $this->crudHandler = $this->createMock(CRUDHandler::class);
        $this->subscriptionManager = $this->createMock(SubscriptionManager::class);
    }

    public function testPostSubscriptionActionNoSoftwareAsAService()
    {
        $this->expectExceptionObject(new NotFoundHttpException());
        $subscriptionController = new SubscriptionController(
            $this->authentication, $this->crudHandler, $this->subscriptionManager, false
        );
        $subscriptionController->postSubscriptionAction();
    }
}
