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
use FTD\SaasBundle\Service\Authentication;
use FTD\SaasBundle\Tests\TestUser;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var UserController
     */
    private $userController;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $user = new TestUser();
        $user->setId(10);
        $user->setUsername('test.user');
        $this->authentication = $this->createMock(Authentication::class);
        $this->authentication->method('getUser')->willReturn($user);

        $this->userController = new UserController($this->authentication);
    }

    public function testGetMeAction()
    {
        $this->assertSame(View::class, get_class($this->userController->getMeAction()));
        $this->assertArrayHasKey('user', $this->userController->getMeAction()->getData());
    }
}
