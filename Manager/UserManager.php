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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FTD\SaasBundle\Entity\User;
use FTD\SaasBundle\Repository\UserRepository;
use FTD\SaasBundle\Service\Authentication;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

        if(($subscription = $this->authentication->getCurrentSubscription()) !== null) {
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
