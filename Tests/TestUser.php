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

use FTD\SaasBundle\Entity\User;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class TestUser extends User
{
    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
