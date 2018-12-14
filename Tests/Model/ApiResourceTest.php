<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests\Model;

use FTD\SaasBundle\Tests\TestApiResource;
use PHPUnit\Framework\TestCase;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class ApiResourceTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $apiResource = new TestApiResource();
        $apiResource->setId(10);
        $this->assertSame(10, $apiResource->getId());

        $apiResource->setSelf('http://127.0.0.1:8000/api/resources/10');
        $this->assertSame('http://127.0.0.1:8000/api/resources/10', $apiResource->getSelf());
    }
}
