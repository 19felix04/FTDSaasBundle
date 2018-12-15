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

        $this->loadConfigByArray('settings', $config, $container);
        $this->loadConfigByArray('template', $config, $container);
        $this->loadConfigByArray('mailer', $config, $container);
    }

    public function loadConfigByArray(string $name, array $configs, ContainerBuilder $container)
    {
        foreach ($configs[$name] as $configName => $config) {
            $container->setParameter(sprintf('ftd_saas.%s.%s', $name, $configName), $config);
        }
    }
}
