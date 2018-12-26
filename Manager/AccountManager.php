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

use Doctrine\ORM\EntityManagerInterface;
use FTD\SaasBundle\Entity\Account;
use FTD\SaasBundle\Repository\AccountRepository;
use FTD\SaasBundle\Service\Authentication;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 *
 * @method AccountRepository getRepository()
 */
class AccountManager extends BaseEntityManager
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $userPasswordEncoder;

    /**
     * @param EntityManagerInterface       $entityManager
     * @param Authentication               $authentication
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        Authentication $authentication,
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        parent::__construct($entityManager, $authentication);
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * The function saves the.
     *
     * @param Account $account
     * @param bool    $flush
     */
    public function update($account, $flush = true)
    {
        if (null != $account->getPlainPassword()) {
            $account->setPassword(
                $this->userPasswordEncoder->encodePassword($account, $account->getPlainPassword())
            );
        }

        parent::update($account, $flush);
    }

    /**
     * @param string $email
     *
     * @return mixed
     */
    public function getAccountByEmail($email)
    {
        return $this->getRepository()->findOneBy(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return Account::class;
    }

    /**
     * @return Account
     */
    public function create()
    {
        return new Account();
    }
}
