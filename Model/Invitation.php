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
 * @author Felix Niedballa <schreib@felixniedballa.de>
 * @JMS\ExclusionPolicy("all")
 */
abstract class Invitation extends ApiResource
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail", "list"})
     */
    protected $email;

    /**
     * {@inheritdoc}
     */
    public function getApiPath()
    {
        return 'invitations';
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanCreate(\FTD\SaasBundle\Entity\User $user)
    {
        return $user->isAdmin();
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanEdit(\FTD\SaasBundle\Entity\User $user)
    {
        return $user->isAdmin();
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanSee(\FTD\SaasBundle\Entity\User $user)
    {
        return $user->isAdmin();
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanDelete(\FTD\SaasBundle\Entity\User $user)
    {
        return $user->isAdmin();
    }
}
