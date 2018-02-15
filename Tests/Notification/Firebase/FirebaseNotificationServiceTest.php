<?php

namespace Tests\Notification\Firebase;

use GuzzleHttp\Psr7\Response;
use StudealPushBundle\Exception\ActionDoesNotExistsException;
use StudealPushBundle\Provider\Firebase\FirebaseNotificationMessage;
use StudealPushBundle\Provider\Firebase\FirebaseNotificationService;
use StudealPushBundle\Provider\Firebase\FirebaseToken;
use Tests\Tools\HttpTestCase;

/**
 * Class FirebaseNotificationServiceTest.
 */
class FirebaseNotificationServiceTest extends HttpTestCase
{
    /**
     * @var FirebaseToken
     */
    protected $token;

    public function setUp()
    {
        parent::setUp();
        $this->token = new FirebaseToken('token');
    }

    /**
     * @return \StudealPushBundle\Notification\Message\NotificationMessageInterface
     */
    private function aNotificationMessage()
    {
        $devices = [
            'DeViCe:Id',
        ];
        $payload = [
            'postId' => 2141,
            'associationId' => 283,
        ];

        return new FirebaseNotificationMessage('Un titre qui fait mal', 'hello ca va !?', $devices, $payload);
    }

    /**
     * @return string
     */
    private function aNotificationRequest()
    {
        return '{"notification":{"title":"Un titre qui fait mal","body":"hello ca va !?"},"registration_ids":["DeViCe:Id"],"data":{"payload":{"postId":2141,"associationId":283}}}';
    }

    public function testShoulThrowExceptionWhenCancellingANotification()
    {
        $this->expectException(ActionDoesNotExistsException::class);

        $service = new FirebaseNotificationService($this->mockedClient, $this->logger);

        $notif = new FirebaseNotificationMessage();

        $service->cancelNotification($notif, $this->token);
    }

    public function testShoulThrowExceptionWhenGettingANotification()
    {
        $this->expectException(ActionDoesNotExistsException::class);

        $service = new FirebaseNotificationService($this->mockedClient, $this->logger);

        $notif = new FirebaseNotificationMessage();

        $service->getNotification($notif, $this->token);
    }

    public function testShoulThrowExceptionWhenListingANotification()
    {
        $this->expectException(ActionDoesNotExistsException::class);

        $service = new FirebaseNotificationService($this->mockedClient, $this->logger);

        $notif = new FirebaseNotificationMessage();

        $service->listNotifications($notif, $this->token);
    }

    public function testShouldSendWithSuccessNotifications()
    {
        $this->addToExpectedResponses(new Response(200, [], file_get_contents(__DIR__.'/Fixtures/success_send.json')));
        $service = new FirebaseNotificationService($this->mockedClient, $this->logger);

        $notif = $this->aNotificationMessage();
        $response = $service->sendNotification($notif, $this->token);

        $req = $this->getRequestForIndex(0);

        self::assertEquals($this->aNotificationRequest(), $req->getBody()->getContents());
        self::assertHeaderContainValue('Authorization', $this->token->__toToken(), $req);
        self::assertRequestsContentTypeIsApplicationJson($req);
        self::assertMethodIsPost($req);
        self::assertEquals(200, $response->getStatusCode());
    }
}
