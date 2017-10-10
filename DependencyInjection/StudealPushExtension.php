<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\DependencyInjection;

use StudealPushBundle\DependencyInjection\Configuration\ProvidersConfiguration;
use StudealPushBundle\Notification\Http\GuzzleHttpClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class StudealPushExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['provider']) && isset($config['apiKey'])) {

            $configurationProvider = ProvidersConfiguration::factory($config['provider'], $config['apiKey']);
            $httpClient = new GuzzleHttpClient($configurationProvider->getBaseUri());

            $container->set('notification_provider', $configurationProvider->instanciateClass([$httpClient, $container->get('logger')]));
        }
    }
}
