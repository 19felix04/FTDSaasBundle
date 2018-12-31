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
}
