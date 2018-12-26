<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Manager;

use FTD\SaasBundle\Entity\User;
use FTD\SaasBundle\Repository\UserRepository;

/**
 * The class UserManager manage the updating and finding of an user entity.
 *
 * @method UserRepository getRepository()
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class UserManager extends BaseEntityManager
{
    /**
     * @return User
     */
    public function create()
    {
        $user = new User();

        if (null !== ($subscription = $this->authentication->getCurrentSubscription())) {
            $user->setSubscription($this->authentication->getCurrentSubscription());
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return User::class;
    }

    /**
     * @param string $email
     *
     * @return User[]
     */
    public function getUsersByEmail(string $email)
    {
        return $this->getRepository()->findBy(['email' => $email]);
    }
}
