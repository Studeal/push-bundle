<?php

namespace Tests\Notification\OneSignal;

use GuzzleHttp\Psr7\Response;
use StudealPushBundle\Notification\Exception\NotificationException;
use StudealPushBundle\Provider\OneSignal\OneSignalNotificationMessage;
use StudealPushBundle\Provider\OneSignal\OneSignalNotificationService;
use StudealPushBundle\Provider\OneSignal\OneSignalToken;
use Tests\Tools\HttpTestCase;

/**
 * Class OneSignalNotificationServiceTest
 */
class OneSignalNotificationServiceTest extends HttpTestCase
{
    /**
     * @var OneSignalToken
     */
    protected $token;

    public function setUp()
    {
        parent::setUp();
        $this->token  = new OneSignalToken('appId', 'key');
    }

    /**
     * @return \StudealPushBundle\Notification\Message\NotificationMessageInterface
     */
    private function aNotificationMessage(){

        $devices = [
            "6392d91a-b206-4b7b-a620-cd68e32c3a76",
            "76ece62b-bcfe-468c-8a78-839aeaa8c5fa",
            "8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86",
            "5fdc92b2-3b2a-11e5-ac13-8fdccfe4d986",
            "00cb73f8-5815-11e5-ba69-f75522da5528"
        ];
        $payload = [
            "postId" => "1454",
            "associationId" => "3"
        ];

        return new OneSignalNotificationMessage("Titre Français", "Message Français", $devices, $payload, [
            'notificationId' => "5eb5a37e-b458-11e3-ac11-000c2940e62c",
            'appId' => "5eb5a37e-b458-11e3-ac11-000c2940e62c"

        ], 'fr');
    }

    /**
     * @return string
     */
    private function aNotificationRequest()
    {
        return '{"app_id":"5eb5a37e-b458-11e3-ac11-000c2940e62c","included_segments":["All"],"headings":{"en":"Titre Fran\u00e7ais","fr":"Titre Fran\u00e7ais"},"contents":{"en":"Message Fran\u00e7ais","fr":"Message Fran\u00e7ais"},"include_player_ids":["6392d91a-b206-4b7b-a620-cd68e32c3a76","76ece62b-bcfe-468c-8a78-839aeaa8c5fa","8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86","5fdc92b2-3b2a-11e5-ac13-8fdccfe4d986","00cb73f8-5815-11e5-ba69-f75522da5528"],"data":{"payload":{"postId":"1454","associationId":"3"}}}';

    }



    public function testShouldReturnAttendedResponseWhenCancellingANotification()
    {
        $this->addToExpectedResponses(new Response(200, [], file_get_contents(__DIR__ . '/Fixtures/body_success.json')));
        $service = new OneSignalNotificationService($this->mockedClient, $this->logger);

        $notif = new OneSignalNotificationMessage(null, null, [], [], [
            'appId' => 'appId',
            'notificationId' => 'notifId'
        ]);

        $response = $service->cancelNotification($notif, $this->token);

        $req = $this->getRequestForIndex(0);

        self::assertEquals('', $req->getBody()->getContents());
        self::assertRequestsContentTypeIsApplicationJson($req);
        self::assertMethodIsDelete($req);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('{"success": "true"}', $response->getBody()->getContents());
    }

    public function testShouldSendWithSuccessNotifications()
    {
        $this->addToExpectedResponses(new Response(200, [], file_get_contents(__DIR__ . '/Fixtures/send_success.json')));
        $service = new OneSignalNotificationService($this->mockedClient, $this->logger);

        $notif = $this->aNotificationMessage();
        $response = $service->sendNotification($notif, $this->token);

        $req = $this->getRequestForIndex(0);

        self::assertEquals($this->aNotificationRequest(), $req->getBody()->getContents());
        self::assertRequestsContentTypeIsApplicationJson($req);
        self::assertMethodIsPost($req);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('{"id": "458dcec4-cf53-11e3-add2-000c2940e62c","recipients": 5}', $response->getBody()->getContents());
    }

    public function testShouldSendWithSuccessNotificationsButNoSubscribers()
    {
        $this->addToExpectedResponses(new Response(200, [], file_get_contents(__DIR__ . '/Fixtures/send_success_no_subscribers.json')));
        $service = new OneSignalNotificationService($this->mockedClient, $this->logger);

        $notif = $this->aNotificationMessage();
        $response = $service->sendNotification($notif, $this->token);

        $req = $this->getRequestForIndex(0);

        self::assertEquals($this->aNotificationRequest(), $req->getBody()->getContents());
        self::assertRequestsContentTypeIsApplicationJson($req);
        self::assertMethodIsPost($req);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('{"id": "","recipients": 0,"errors": ["All included players are not subscribed"]}', $response->getBody()->getContents());
    }

    public function testShouldSendWithSuccessNotificationsButSomeDeviceIdsAreMissings()
    {
        $this->addToExpectedResponses(new Response(200, [], file_get_contents(__DIR__ . '/Fixtures/send_success_invalid_ids.json')));
        $service = new OneSignalNotificationService($this->mockedClient, $this->logger);

        $notif = $this->aNotificationMessage();
        $response = $service->sendNotification($notif, $this->token);

        $req = $this->getRequestForIndex(0);

        self::assertEquals($this->aNotificationRequest(), $req->getBody()->getContents());
        self::assertRequestsContentTypeIsApplicationJson($req);
        self::assertMethodIsPost($req);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('{"errors": {"invalid_player_ids": ["5fdc92b2-3b2a-11e5-ac13-8fdccfe4d986","00cb73f8-5815-11e5-ba69-f75522da5528"]}}', $response->getBody()->getContents());
    }

    public function testShouldNotSendWithErrorNotifications()
    {
        $this->addToExpectedResponses(new Response(400, [], file_get_contents(__DIR__ . '/Fixtures/send_bad_request.json')));
        $this->expectException(NotificationException::class);

        $service = new OneSignalNotificationService($this->mockedClient, $this->logger);

        $notif = $this->aNotificationMessage();
        $response = $service->sendNotification($notif, $this->token);

        $req = $this->getRequestForIndex(0);

        self::assertEquals($this->aNotificationRequest(), $req->getBody()->getContents());
        self::assertRequestsContentTypeIsApplicationJson($req);
        self::assertMethodIsPost($req);
    }


}