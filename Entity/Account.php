<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FTD\SaasBundle\Model\Account as BaseAccount;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="FTD\SaasBundle\Repository\AccountRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Account extends BaseAccount
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="account", cascade={"persist"})
     */
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     */
    protected $currentUser;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $confirmationToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $confirmationRequestAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection|User[] $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    /**
     * @param User $user
     *
     * @return Account
     */
    public function addUser(User $user): Account
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAccount($this);
        }

        return $this;
    }

    /**
     * @return User
     */
    public function getCurrentUser(): User
    {
        return $this->currentUser;
    }

    /**
     * @param User $currentUser
     */
    public function setCurrentUser(User $currentUser): void
    {
        $this->currentUser = $currentUser;
    }

    /**
     * @return null|string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param string|null $confirmationToken
     *
     * @return self
     */
    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getConfirmationRequestAt()
    {
        return $this->confirmationRequestAt;
    }

    /**
     * @param \DateTime|null $confirmationRequestAt
     *
     * @return self
     */
    public function setConfirmationRequestAt(?\DateTime $confirmationRequestAt): self
    {
        $this->confirmationRequestAt = $confirmationRequestAt;

        return $this;
    }
}
