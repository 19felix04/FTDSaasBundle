<?php

namespace FTD\SaasBundle\Service\Account;

use FTD\SaasBundle\Manager\AccountManagerInterface;
use FTD\SaasBundle\Manager\UserManagerInterface;
use FTD\SaasBundle\Model\Account;
use FTD\SaasBundle\Model\User;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class AccountCreationHandler implements AccountCreationHandlerInterface
{
    /**
     * @var AccountManagerInterface
     */
    private $accountManager;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @param AccountManagerInterface $accountManager
     * @param UserManagerInterface    $userManager
     */
    public function __construct(
        AccountManagerInterface $accountManager,
        UserManagerInterface $userManager
    ) {
        $this->accountManager = $accountManager;
        $this->userManager = $userManager;
    }

    /**
     * @param Account $account
     * @param User[]   $users
     *
     * @return void
     */
    public function process(Account $account, array $users) :void
    {
        if (count($users) > 0) {
            foreach ($users as $i => $user) {
                $account->addUser($user);
                if (0 === $i) {
                    $user->setAccount($account);
                    $account->setCurrentUser($user);
                    $this->userManager->update($user);
                    $this->accountManager->update($account);

                    return;
                }
            }
        }
    }
}
