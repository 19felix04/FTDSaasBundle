<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Service\Subscription;

use FTD\SaasBundle\Model\Subscription;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
interface SubscriptionCreationHandlerInterface
{
    /**
     * @param Subscription $subscription
     *
     * @return void
     */
    public function process(Subscription $subscription): void;
}
