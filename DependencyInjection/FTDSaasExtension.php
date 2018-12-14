<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class FTDSaasExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');

        $container->setParameter('ftd_saas.passwordResetTime', $config['passwordResetTime']);
        $container->setParameter('ftd_saas.template.passwordForget', $config['template']['passwordForget']);
        $container->setParameter('ftd_saas.template.accountCreate', $config['template']['accountCreate']);
        $container->setParameter('ftd_saas.mailer.address', $config['mailer']['address']);
        $container->setParameter('ftd_saas.mailer.sender_name', $config['mailer']['sender_name']);
    }
}
