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
use Doctrine\ORM\PersistentCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
abstract class Subscription
{
    /**
     * @var int
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $id;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="FTD\SaasBundle\Entity\User", mappedBy="subscription", cascade={"persist"})
     */
    protected $users;

    /**
     * @var bool
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $userCanEdit;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return Subscription
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return PersistentCollection|User[]
     */
    public function getUsers(): PersistentCollection
    {
        return $this->users;
    }

    public function addUser(\FTD\SaasBundle\Model\User $user)
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSubscription($this);
        }
    }

    public function removeUser(\FTD\SaasBundle\Model\User $user)
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            if ($user->getSubscription() === $this) {
                $user->setSubscription(null);
            }
        }
    }

    public function getApiPath()
    {
        return 'subscriptions';
    }

    public function checkUserCanEdit(User $user)
    {
        return true;
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
}
