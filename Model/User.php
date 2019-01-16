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

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("ALL")
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
abstract class User extends ApiResource
{
    /**
     * @var int
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $id;

    /**
     * @var Subscription
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\Subscription", inversedBy="users", cascade={"persist"})
     */
    protected $subscription;

    /**
     * @var string|null
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @var string|null
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string|null
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $self;

    /**
     * @var \DateTime
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastActivityAt;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\Account")
     */
    protected $account;

    /**
     * {@inheritdoc}
     */
    public function getApiPath()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanCreate(User $user)
    {
        return $this->getSubscription() === $user->getSubscription();
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanEdit(User $user)
    {
        return $this->getSubscription() === $user->getSubscription();
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanSee(User $user)
    {
        return $this->getSubscription() === $user->getSubscription();
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanDelete(User $user)
    {
        return false;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
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
     * @return string|null
     */
    public function getSelf(): ?string
    {
        return $this->self;
    }

    /**
     * @param string|null $self
     */
    public function setSelf(?string $self): void
    {
        $this->self = $self;
    }

    /**
     * @return \DateTime
     */
    public function getLastActivityAt(): \DateTime
    {
        return $this->lastActivityAt;
    }

    /**
     * @param \DateTime $lastActivityAt
     */
    public function setLastActivityAt(\DateTime $lastActivityAt): void
    {
        $this->lastActivityAt = $lastActivityAt;
    }

    /**
     * @return Account
     */
    public function getAccount(): ?\FTD\SaasBundle\Model\Account
    {
        return $this->account;
    }

    /**
     * @param \FTD\SaasBundle\Model\Account $account
     */
    public function setAccount(\FTD\SaasBundle\Model\Account $account): void
    {
        $this->account = $account;
    }
}
