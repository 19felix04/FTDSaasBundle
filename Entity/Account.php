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
use Doctrine\ORM\Mapping as ORM;
use FTD\SaasBundle\Model\Account as BaseAccount;
use JMS\Serializer\Annotation as JMS;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 *
 * @ORM\Table(name="ftd_saas_account")
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

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return null|\FTD\SaasBundle\Model\User
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
