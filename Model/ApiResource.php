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
 * A class which implements this interface can be access as REST-Resource and will be connected to the current
 * subscription of the logged in user.
 *
 * @JMS\ExclusionPolicy("all")
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
abstract class ApiResource
{
    /**
     * @var int
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list", "connectedList"})
     */
    protected $id;

    /**
     * @var bool
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list", "connectedList"})
     */
    protected $userCanEdit;

    /**
     * @var bool
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list", "connectedList"})
     */
    protected $userCanDelete;

    /**
     * @var bool
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list", "connectedList"})
     */
    protected $userCanSee;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "connectedList"})
     */
    protected $self;

    /**
     * @var \DateTime
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \FTD\SaasBundle\Entity\User
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\User")
     */
    protected $createdBy;

    /**
     * @var \FTD\SaasBundle\Entity\Subscription
     *
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\Subscription")
     */
    protected $subscription;

    public function __clone()
    {
        $this->id = null;
        $this->createdAt = null;
        $this->createdBy = null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The function sets the link to the object which implements this interface.
     *
     * @param string $self
     *
     * @return $this
     */
    public function setSelf(string $self)
    {
        $this->self = $self;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSelf(): ?string
    {
        return $this->self;
    }

    /**
     * @return bool
     */
    public function getUserCanEdit()
    {
        return $this->userCanEdit;
    }

    /**
     * @param bool $userCanEdit
     *
     * @return $this
     */
    public function setUserCanEdit($userCanEdit)
    {
        $this->userCanEdit = $userCanEdit;

        return $this;
    }

    /**
     * @param bool $userCanDelete
     *
     * @return $this
     */
    public function setUserCanDelete($userCanDelete)
    {
        $this->userCanDelete = $userCanDelete;

        return $this;
    }

    /**
     * @param bool $userCanSee
     *
     * @return $this
     */
    public function setUserCanSee($userCanSee)
    {
        $this->userCanSee = $userCanSee;

        return $this;
    }

    /**
     * The function get the resource-specific path.
     *
     * @return string
     */
    abstract public function getApiPath();

    /**
     * @param \FTD\SaasBundle\Entity\User $user
     *
     * @return bool
     *
     * The function checks if the passing user can create this resource
     */
    abstract public function checkUserCanCreate(\FTD\SaasBundle\Entity\User $user);

    /**
     * @param \FTD\SaasBundle\Entity\User $user
     *
     * @return bool
     *
     * The function checks if the passing user can edit this resource
     */
    abstract public function checkUserCanEdit(\FTD\SaasBundle\Entity\User $user);

    /**
     * @param \FTD\SaasBundle\Entity\User $user
     *
     * @return bool
     *
     * The function checks if the passing user can see this resource
     */
    abstract public function checkUserCanSee(\FTD\SaasBundle\Entity\User $user);

    /**
     * @param \FTD\SaasBundle\Entity\User $user
     *
     * @return bool
     *
     * The function checks if the passing user can delete this resource
     */
    abstract public function checkUserCanDelete(\FTD\SaasBundle\Entity\User $user);

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \FTD\SaasBundle\Entity\User
     */
    public function getCreatedBy(): \FTD\SaasBundle\Entity\User
    {
        return $this->createdBy;
    }

    /**
     * @param \FTD\SaasBundle\Entity\User $createdBy
     *
     * @return self
     */
    public function setCreatedBy(\FTD\SaasBundle\Entity\User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return \FTD\SaasBundle\Entity\Subscription
     */
    public function getSubscription(): ?\FTD\SaasBundle\Entity\Subscription
    {
        return $this->subscription;
    }

    /**
     * @param \FTD\SaasBundle\Entity\Subscription $subscription
     *
     * @return self
     */
    public function setSubscription(?\FTD\SaasBundle\Entity\Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }
}
