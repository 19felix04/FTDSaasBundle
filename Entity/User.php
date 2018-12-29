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

use Doctrine\ORM\Mapping as ORM;
use FTD\SaasBundle\Model\Account;
use FTD\SaasBundle\Model\Subscription;
use FTD\SaasBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as JMS;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>

 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="FTD\SaasBundle\Repository\UserRepository")
 * @JMS\ExclusionPolicy("ALL")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastActivityAt;

    /**
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\Subscription", inversedBy="users", cascade={"persist"})
     */
    protected $subscription;

    /**
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\Account", inversedBy="users", cascade={"persist"})
     */
    protected $account;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|Subscription
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public function setSubscription(Subscription $subscription): void
    {
        $this->subscription = $subscription;
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
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }
}
