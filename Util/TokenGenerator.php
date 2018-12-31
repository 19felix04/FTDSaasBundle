<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Util;

/**
 * The class contains a function to generate a unique token.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class TokenGenerator
{
    /**
     * The function returns a unique token.
     *
     * @return string
     */
    public function generateToken()
    {
        return base64_encode(md5(uniqid(strtotime(rand(0, 99999) . ' seconds'))));
    }
}
