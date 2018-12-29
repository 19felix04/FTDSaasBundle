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

/**
 * @JMS\ExclusionPolicy("ALL")
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
abstract class User
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
     * @var Account
     */
    protected $account;

    /**
     * @param Subscription $subscription
     */
    abstract public function setSubscription(Subscription $subscription): void;

    /**
     * @return Subscription|null
     */
    abstract public function getSubscription(): ?Subscription;

    /**
     * @param string|null $email
     *
     * @return mixed
     */
    abstract public function setEmail(?string $email);

    /**
     * @param Account $account
     *
     * @return mixed
     */
    abstract public function setAccount(Account $account);
}
