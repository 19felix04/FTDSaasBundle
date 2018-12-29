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

use FTD\SaasBundle\Model\User;

/**
 * The class UserManager manage the updating and finding of an user entity.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
interface UserManagerInterface extends CRUDEntityManagerInterface
{
    /**
     * @return User
     */
    public function create(): User;

    /**
     * @param string $email
     *
     * @return User[]
     */
    public function getUsersByEmail(string $email): array;

    /**
     * The function returns the class-name of the entity which represents the user.
     *
     * @return string
     */
    public function getClass(): string;
}
