<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Event;

use FTD\SaasBundle\Model\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class UserEvent extends Event
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * The function returns the User-entity of the event.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
