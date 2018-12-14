<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests\Util;

use FTD\SaasBundle\Util\TokenGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class TokenGeneratorTest extends TestCase
{
    public function testGenerateToken()
    {
        $tokenGenerator = new TokenGenerator();
        $this->assertTrue(is_string($tokenGenerator->generateToken()));
    }
}
