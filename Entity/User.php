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
use FTD\SaasBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as JMS;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>

 * @ORM\Table(name="ftd_saas_user")
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
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\Account", inversedBy="users", cascade={"persist"})
     */
    protected $account;

    /**
     * @return Account
     */
    public function getAccount(): \FTD\SaasBundle\Model\Account
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
