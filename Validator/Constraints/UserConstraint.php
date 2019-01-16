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

use Symfony\Component\Validator\Constraint;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class UserConstraint extends Constraint
{
    public $emailAlreadyExists = 'user.emailAlreadyExists';
    public $usernameAlreadyExists = 'user.usernameAlreadyExists';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
