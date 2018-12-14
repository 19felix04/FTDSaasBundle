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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $confirmationToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $confirmationRequestAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastActivityAt;

    /**
     * @ORM\ManyToOne(targetEntity="FTD\SaasBundle\Entity\Subscription", inversedBy="users")
     */
    protected $subscription;
}
