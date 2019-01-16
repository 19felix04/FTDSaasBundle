<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Validator\Constraints;

use FTD\SaasBundle\Manager\UserManagerInterface;
use FTD\SaasBundle\Model\User;
use FTD\SaasBundle\Service\Authentication;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class UserConstraintValidator extends ConstraintValidator
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @param Authentication       $authentication
     * @param UserManagerInterface $userManager
     */
    public function __construct(
        Authentication $authentication,
        UserManagerInterface $userManager
    ) {
        $this->authentication = $authentication;
        $this->userManager = $userManager;
    }

    /**
     * @param mixed                     $value
     * @param UserConstraint|Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (
            get_class($value) !== $this->userManager->getClass()
            && !$value instanceof User
        ) {
            throw new \LogicException(
                sprintf(
                    '%s validates only objects of type %s. %s given.',
                    __CLASS__,
                    $this->userManager->getClass(),
                    get_class($value)
                )
            );
        }

        $subscription = null !== $value->getSubscription()
                ? $value->getSubscription() : $this->authentication->getCurrentSubscription();

        $username = $value->getUsername();
        $user = $this->userManager->getUserBySubscriptionAndUsername($subscription, $username);

        if (null !== $user) {
            $this->context->buildViolation($constraint->usernameAlreadyExists)->atPath('username')->addViolation();
        }

        $email = $value->getEmail();
        $user = $this->userManager->getUserBySubscriptionAndEmail($subscription, $email);

        if (null !== $user) {
            $this->context->buildViolation($constraint->emailAlreadyExists)->atPath('email')->addViolation();
        }
    }
}
