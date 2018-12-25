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
     */
    protected $name;
}
