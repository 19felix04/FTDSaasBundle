<?php

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
     * @param User[]   $users
     *
     * @return void
     */
    public function process(Account $account, array $users) :void;
}
