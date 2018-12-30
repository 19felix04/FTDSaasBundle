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

use FTD\SaasBundle\Model\Account;
use FTD\SaasBundle\Repository\AccountRepository;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
interface AccountManagerInterface
{
    /**
     * The function has to contain logic to create an account object.
     *
     * @return Account
     */
    public function create(): Account;

    /**
     * The function has to contains logic to save the passing account entity to database.
     *
     * @param object $account
     * @param bool   $flush
     *
     * @return mixed
     */
    public function update($account, $flush = true);

    /**
     * @param string $email
     *
     * @return null|Account
     */
    public function getAccountByEmail($email): ?Account;

    /**
     * @param string $confirmationToken
     *
     * @return Account|null
     */
    public function getByConfirmationToken(string $confirmationToken): ?Account;

    /**
     * @return AccountRepository
     */
    public function getRepository(): AccountRepository;

    /**
     * The function returns the class-name of the entity which represents the account.
     *
     * @return string
     */
    public function getClass(): string;
}
