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
     * @ORM\OneToMany(targetEntity="User", mappedBy="account", cascade={"persist"})
     */
    protected $users;
}
