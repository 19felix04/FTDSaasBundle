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
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FTD\SaasBundle\Model\Subscription as BaseSubscription;
use JMS\Serializer\Annotation as JMS;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 *
 * @ORM\Table(name="ftd_saas_subscription")
 * @ORM\Entity(repositoryClass="FTD\SaasBundle\Repository\SubscriptionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Subscription extends BaseSubscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="FTD\SaasBundle\Entity\User", mappedBy="subscription", cascade={"persist"})
     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function getUsers(): ArrayCollection
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
}
