<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests\EntityListener;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use FTD\SaasBundle\Entity\Subscription;
use FTD\SaasBundle\EntityListener\ApiResourceSubscriptionListener;
use FTD\SaasBundle\Service\Authentication;
use FTD\SaasBundle\Tests\TestApiResource;
use FTD\SaasBundle\Tests\TestSubscription;
use PHPUnit\Framework\TestCase;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class ApiResourceSubscriptionListenerTest extends TestCase
{
    /**
     * @var ApiResourceSubscriptionListener
     */
    private $apiResourceSubscriptionListener;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var Subscription
     */
    private $subscription;

    public function setUp()
    {
        $this->subscription = new TestSubscription();
        $this->subscription->setId(30);

        $this->authentication = $this->createMock(Authentication::class);
        $this->authentication->method('getCurrentSubscription')->willReturn($this->subscription);

        $this->objectManager = $this->createMock(ObjectManager::class);
    }

    public function testGetSubscribedEvents()
    {
        $this->apiResourceSubscriptionListener = new ApiResourceSubscriptionListener($this->authentication, false);
        $this->assertSame(['postUpdate', 'postPersist'], $this->apiResourceSubscriptionListener->getSubscribedEvents());
    }

    public function testNotSoftwareAsAServicePostUpdate()
    {
        $apiResource = new TestApiResource();
        $this->apiResourceSubscriptionListener = new ApiResourceSubscriptionListener($this->authentication, false);

        $this->apiResourceSubscriptionListener->postUpdate(new LifecycleEventArgs(
            $apiResource, $this->objectManager
        ));

        $this->assertNull($apiResource->getSubscription());
    }

    public function testSoftwareAsAServicePostUpdate()
    {
        $apiResource = new TestApiResource();
        $this->apiResourceSubscriptionListener = new ApiResourceSubscriptionListener(
            $this->authentication,
            true
        );

        $this->apiResourceSubscriptionListener->postUpdate(new LifecycleEventArgs(
            $apiResource, $this->objectManager
        ));

        $this->assertEquals($this->subscription, $apiResource->getSubscription());
    }
}
