<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Service\Account;

use FTD\SaasBundle\Model\Account;
use FTD\SaasBundle\Model\User;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
interface AccountCreationHandlerInterface
{
    /**
     * @param Account $account
     * @param User[]  $users
     *
     * @return void
     */
    public function process(Account $account, array $users): void;
}
