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

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use FTD\SaasBundle\Tests\TestApiResource;
use FTD\SaasBundle\Tests\TestUser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class SelfPathListenerTest extends TestCase
{
    /**
     * @var SelfPathSettingListener
     */
    private $selfPathSettingListener;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var TestUser
     */
    private $apiResourceEntity;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $currentRequest = $this->createMock(Request::class);
        $currentRequest->method('getSchemeAndHttpHost')->willReturn('http://127.0.0.1/');

        $this->requestStack = $this->createMock(RequestStack::class);
        $this->requestStack->method('getCurrentRequest')->willReturn($currentRequest);

        $this->selfPathSettingListener = new SelfPathSettingListener($this->requestStack);
        $this->objectManager = $this->createMock(ObjectManager::class);
    }

    public function testGetSubscribedEvents()
    {
        $this->assertSame(['postLoad', 'postUpdate'], $this->selfPathSettingListener->getSubscribedEvents());
    }

    public function testPostLoad()
    {
        $this->apiResourceEntity = new TestApiResource();
        $this->apiResourceEntity->setId(10);
        $this->selfPathSettingListener->postLoad(
            new LifecycleEventArgs($this->apiResourceEntity, $this->objectManager)
        );

        $this->assertSame('http://127.0.0.1/api/apiResources/10', $this->apiResourceEntity->getSelf());
    }

    public function testPostUpdate()
    {
        $this->apiResourceEntity = new TestApiResource();
        $this->apiResourceEntity->setId(11);
        $this->selfPathSettingListener->postUpdate(
            new LifecycleEventArgs($this->apiResourceEntity, $this->objectManager)
        );

        $this->assertSame('http://127.0.0.1/api/apiResources/11', $this->apiResourceEntity->getSelf());
    }
}
