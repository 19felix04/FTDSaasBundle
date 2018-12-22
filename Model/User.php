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

use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @JMS\ExclusionPolicy("ALL")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
abstract class User implements UserInterface
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
     */
    protected $subscription;

    /**
     * @var string|null
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $username;

    /**
     * @var string|null
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $email;

    /**
     * @var bool
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $enabled;

    /**
     * @var string|null
     */
    protected $password;

    /**
     * @var string|null
     */
    protected $plainPassword;

    /**
     * @var string|null
     */
    protected $oldPassword;

    /**
     * @var string|null
     */
    protected $confirmationToken;

    /**
     * @var \DateTime
     */
    protected $confirmationRequestAt;

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
     */
    protected $lastActivityAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Subscription
     */
    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public function setSubscription(?Subscription $subscription): void
    {
        $this->subscription = $subscription;
    }

    /**
     * @return?string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param?string $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return?string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param?string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return?string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param?string $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return?string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param?string $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return?string
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @param?string $oldPassword
     */
    public function setOldPassword(?string $oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return?string
     */
    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    /**
     * @param?string $confirmationToken
     */
    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @return \DateTime
     */
    public function getConfirmationRequestAt(): \DateTime
    {
        return $this->confirmationRequestAt;
    }

    /**
     * @param \DateTime $confirmationRequestAt
     */
    public function setConfirmationRequestAt(?\DateTime $confirmationRequestAt): void
    {
        $this->confirmationRequestAt = $confirmationRequestAt;
    }

    /**
     * @return?string
     */
    public function getSelf(): ?string
    {
        return $this->self;
    }

    /**
     * @param?string $self
     */
    public function setSelf(string $self): void
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
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return base64_encode(md5(uniqid(strtotime(rand(0, 99999).' seconds'))));
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        return null;
    }
}
