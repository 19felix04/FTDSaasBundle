<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Controller;

use FTD\SaasBundle\Manager\InvitationManager;
use FTD\SaasBundle\Service\Request\CRUDHandler;

/**
 * The class contains API-Endpoints to handle Invitation-entities.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class InvitationController
{
    /**
     * @var CRUDHandler
     */
    private $crudHandler;

    /**
     * @var InvitationManager
     */
    private $invitationManager;

    /**
     * @param CRUDHandler       $crudHandler
     * @param InvitationManager $invitationManager
     */
    public function __construct(CRUDHandler $crudHandler, InvitationManager $invitationManager)
    {
        $this->crudHandler = $crudHandler;
        $this->invitationManager = $invitationManager;
    }
}
