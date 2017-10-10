<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use StudealPushBundle\Notification\AbstractNotificationService;
use StudealPushBundle\Notification\Exception\NotificationException;
use StudealPushBundle\Notification\Security\TokenInterface;
use StudealPushBundle\Provider\Firebase\FirebaseNotificationMessage;
use Tests\Integration\kernel\AppKernel;

/**
 * Class InIntegrationKernelTest
 */
class InIntegrationKernelTest extends TestCase
{
    public function testShouldLoadKernel()
    {
        $kernel = new AppKernel('test', true);

        $kernel->boot();

        self::assertNotNull($kernel->getContainer()->get('notification_provider'));
        /** @var AbstractNotificationService $service */
        $service = $kernel->getContainer()->get('notification_provider');
        $message = new FirebaseNotificationMessage('coucou', 'envoyé depuis le bundle', [
            'id',
        ], [
            "postId"=> 2141,
            "associationId"=> 283
        ]);
        /** @var TokenInterface $token */
        $token = $kernel->getContainer()->get('notification_provider_token');
        $this->expectException(NotificationException::class);

        $service->sendNotification($message, $token);
    }
}