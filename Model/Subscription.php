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
use Doctrine\ORM\Mapping as ORM;

/**
 * @JMS\ExclusionPolicy("all")
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
abstract class Subscription
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $name;

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
     * @return ArrayCollection|User[]
     */
    public abstract function getUsers(): ArrayCollection;

    /**
     * @param User $user
     *
     * @return Subscription
     */
    public abstract function addUser(User $user);

    /**
     * @param User $user
     *
     * @return Subscription
     */
    public abstract function removeUser(User $user);
}
