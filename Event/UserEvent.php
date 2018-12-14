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

use FTD\SaasBundle\Entity\User;
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
     * Constructor with injecting User-entity to event.
     *
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
