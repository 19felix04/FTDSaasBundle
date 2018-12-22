<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle;

/**
 * Contains all events thrown in the FTDSaasBundle.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
final class FTDSaasBundleEvents
{
    /**
     * The event occurs when an user creates an.
     */
    const ACCOUNT_CREATE = 'ftd.saas_bundle.account.create';

    /**
     * The event occurs when an user reset the password.
     */
    const ACCOUNT_PASSWORD_RESET = 'ftd.saas_bundle.account.password_reset';

    /**
     * The event occurs when an user update his or her password.
     */
    const ACCOUNT_PASSWORD_UPDATE = 'ftd.saas_bundle.account.password_update';

    /**
     * The event occurs when an user create an invitation.
     */
    const INVITATION_CREATE = 'ftd.saas_bundle.invitation.create';

    /**
     * The event occurs when an user delete an invitation.
     */
    const INVITATION_DELETE = 'ftd.saas_bundle.invitation.delete';
}
