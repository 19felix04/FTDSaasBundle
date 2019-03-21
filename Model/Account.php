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
use Doctrine\ORM\Mapping as ORM;
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
     * @var
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $confirmationToken;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $confirmationRequestAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FTD\SaasBundle\Entity\User", mappedBy="account", cascade={"persist"})
     */
    protected $users;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\User", cascade={"persist"})
     */
    protected $currentUser;

    /**
     * @var string
     */
    protected $plainPassword;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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
     * @return string|null
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
     * @param \FTD\SaasBundle\Model\User $user
     *
     * @return Account
     */
    public function addUser(\FTD\SaasBundle\Model\User $user)
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAccount($this);
        }

        return $this;
    }

    /**
     * @return \FTD\SaasBundle\Model\User|null
     */
    public function getCurrentUser(): ?\FTD\SaasBundle\Model\User
    {
        return $this->currentUser;
    }

    /**
     * @param \FTD\SaasBundle\Model\User|null $currentUser
     */
    public function setCurrentUser(?\FTD\SaasBundle\Model\User $currentUser): void
    {
        $this->currentUser = $currentUser;
    }
}
