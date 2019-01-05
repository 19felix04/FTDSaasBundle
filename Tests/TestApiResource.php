<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests;

use FTD\SaasBundle\Model\ApiResource;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class TestApiResource extends ApiResource
{
    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getApiPath()
    {
        return 'apiResources';
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanCreate(\FTD\SaasBundle\Model\User $user)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanEdit(\FTD\SaasBundle\Model\User $user)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanSee(\FTD\SaasBundle\Model\User $user)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserCanDelete(\FTD\SaasBundle\Model\User $user)
    {
        return true;
    }
}
