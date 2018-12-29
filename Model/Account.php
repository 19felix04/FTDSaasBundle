<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The Account-class is the main context to secure the application via UserInterface.
 * An Account can contains a lot of users connected to different plans/subscriptions.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 * @JMS\ExclusionPolicy("all")
 */
abstract class Account implements UserInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $password;

    /**
     * @var string|null
     */
    protected $plainPassword;

    /**
     * @var User[]|ArrayCollection
     */
    protected $users;

    /**
     * @var User
     */
    protected $currentUser;

    /**
     * @var string|null
     */
    protected $confirmationToken;

    /**
     * @var \DateTime|null
     */
    protected $confirmationRequestAt;

    /**
     * @var Account|null
     */
    protected $account;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getRoles()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return md5(uniqid());
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return int
     */
    abstract public function getId(): int;

    /**
     * @param string|null $password
     */
    abstract public function setPassword(?string $password);

    /**
     * The function returns the email of the account or null.
     *
     * @return string|null
     */
    abstract public function getEmail(): ?string;

    /**
     * The function adds an user to an account. Duplicated users shouldn't exist after adding.
     *
     * @param User $user
     *
     * @return Account
     */
    abstract public function addUser(User $user): Account;

    /**
     * The function set the current active user of the account.
     *
     * @param User|null $currentUser
     */
    abstract public function setCurrentUser(?User $currentUser): void;
}
