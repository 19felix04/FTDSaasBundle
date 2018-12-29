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

use FTD\SaasBundle\Form\AccountType;
use FTD\SaasBundle\Form\SubscriptionType;
use FTD\SaasBundle\Form\UserType;
use FTD\SaasBundle\Manager\AccountManager;
use FTD\SaasBundle\Manager\SubscriptionManager;
use FTD\SaasBundle\Manager\UserManager;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ftd_saas');
        $rootNode
            ->children()
                ->arrayNode('settings')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('passwordResetTime')->defaultValue(216000)->end()
                        ->booleanNode('softwareAsAService')->defaultValue(true)->end()
                    ->end()
                ->end()
                ->arrayNode('mailer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('address')->isRequired()->end()
                        ->scalarNode('sender_name')->isRequired()->end()
                    ->end()
                ->end()
                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('passwordForget')->defaultValue('false')->end()
                        ->scalarNode('accountCreate')->defaultValue('false')->end()
                    ->end()
                ->end()
                ->arrayNode('form')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('accountType')->defaultValue(AccountType::class)->end()
                        ->scalarNode('userType')->defaultValue(UserType::class)->end()
                        ->scalarNode('subscriptionType')->defaultValue(SubscriptionType::class)->end()
                    ->end()
                ->end()
                ->arrayNode('manager')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('accountManager')->defaultValue(AccountManager::class)->end()
                        ->scalarNode('userManager')->defaultValue(UserManager::class)->end()
                        ->scalarNode('subscriptionManager')->defaultValue(SubscriptionManager::class)->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
