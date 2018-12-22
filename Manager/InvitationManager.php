<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Manager;

use FTD\SaasBundle\Entity\Invitation;

/**
 * The class InvitationManager manage the updating and finding of an invitation entity.
 *
 * @method InvitationRepository getRepository()
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class InvitationManager extends BaseEntityManager
{
    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return Invitation::class;
    }
}
