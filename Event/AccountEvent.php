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

use FTD\SaasBundle\Entity\Account;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class AccountEvent extends Event
{
    /**
     * @var Account
     */
    private $account;

    /**
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * The function returns the Account-entity of the event.
     *
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}
