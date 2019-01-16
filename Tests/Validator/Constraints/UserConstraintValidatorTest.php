<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests\Validator\Constraints;

use FTD\SaasBundle\Entity\User;
use FTD\SaasBundle\Manager\UserManager;
use FTD\SaasBundle\Service\Authentication;
use FTD\SaasBundle\Tests\Model\ApiResourceTest;
use FTD\SaasBundle\Validator\Constraints\UserConstraint;
use FTD\SaasBundle\Validator\Constraints\UserConstraintValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class UserConstraintValidatorTest extends TestCase
{
    /**
     * @var Authentication|MockObject
     */
    private $authentication;

    /**
     * @var UserManager|MockObject
     */
    private $userManager;

    public function setUp()
    {
        $this->authentication = $this->createMock(Authentication::class);

        $this->userManager = $this->createMock(UserManager::class);
        $this->userManager->method('getClass')->willReturn(User::class);
    }

    public function testInvalidValue()
    {
        $apiResource = new ApiResourceTest();
        $userConstraintValidator = new UserConstraintValidator($this->authentication, $this->userManager);

        $this->expectException(\LogicException::class);
        $userConstraintValidator->validate($apiResource, new UserConstraint());
    }

    public function testUsernameAlreadyExists()
    {
        $this->userManager->method('getUserBySubscriptionAndUsername')->willReturn(new User());
        $userConstraintValidator = new UserConstraintValidator($this->authentication, $this->userManager);

        // Todo
    }
}
