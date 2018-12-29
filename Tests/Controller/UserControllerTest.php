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

use FOS\RestBundle\View\View;
use FTD\SaasBundle\Controller\UserController;
use FTD\SaasBundle\Form\UserType;
use FTD\SaasBundle\Manager\UserManager;
use FTD\SaasBundle\Service\Authentication;
use FTD\SaasBundle\Service\Request\CRUDHandler;
use FTD\SaasBundle\Tests\TestUser;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
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
     * @var UserManager
     */
    private $userManager;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $user = new TestUser();
        $user->setId(10);
        $user->setUsername('test.user');
        $this->authentication = $this->createMock(Authentication::class);
        $this->authentication->method('getCurrentUser')->willReturn($user);

        $this->crudHandler = $this->createMock(CRUDHandler::class);
        $this->userManager = $this->createMock(UserManager::class);
    }

    public function testGetMeAction()
    {
        $userController = new UserController($this->authentication, $this->crudHandler, $this->userManager, UserType::class, true);

        $this->assertSame(View::class, get_class($userController->getMeAction()));
        $this->assertArrayHasKey('user', $userController->getMeAction()->getData());
    }

    public function testPostMeActionNotSoftwareAsAService()
    {
        $userController = new UserController($this->authentication, $this->crudHandler, $this->userManager, UserType::class, false);

        $this->assertSame(View::class, get_class($userController->postMeAction()));
        $this->assertSame(404, $userController->postMeAction()->getStatusCode());
    }
}
