<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests\DependencyInjection;

use FTD\SaasBundle\DependencyInjection\FTDSaasExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class FTDSaasExtensionTest extends TestCase
{
    public function testLoadConfigByArray()
    {
        $ftdSaasExtension = new FTDSaasExtension();
        $container = new ContainerBuilder();

        $sampleConfigs = [
            'mailer' => [
                'address' => 'test@local.de',
                'sender_name' => 'Test',
            ],
        ];

        $ftdSaasExtension->loadConfigByArray('mailer', $sampleConfigs, $container);

        $this->assertSame('test@local.de', $container->getParameter('ftd_saas.mailer.address'));
        $this->assertSame('Test', $container->getParameter('ftd_saas.mailer.sender_name'));
    }
}
