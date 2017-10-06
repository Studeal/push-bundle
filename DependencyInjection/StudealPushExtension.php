<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Studeal\PushBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class StudealPushExtension extends Extension
{
    const NOTIFICATION_BASE_URI = 'base_uri';
    const NOTIFICATION_APP_ID = 'app_id';
    const NOTIFICATION_APP_SECRET = 'app_secret';
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (isset($config[self::NOTIFICATION_BASE_URI])) {
            $container->setParameter('notification.base_uri', $config[self::NOTIFICATION_BASE_URI]);
        }

        if (isset($config[self::NOTIFICATION_APP_ID])) {
            $container->setParameter('notification.app_id', $config[self::NOTIFICATION_APP_ID]);
        }

        if (isset($config[self::NOTIFICATION_APP_SECRET])) {
            $container->setParameter('notification.app_secret', $config[self::NOTIFICATION_APP_SECRET]);
        }
    }
}
