<?php

namespace Tests\Notification;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Tests\Notification\Fixtures\TestClient;

class HttpTestCase extends TestCase
{
    use AssertHelper, StringUtil;

    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var MockHandler
     */
    protected $mock;
    /**
     * @var HandlerStack
     */
    protected $handler;
    /**
     * @var array
     */
    protected $stack;
    /**
     * @var TestClient
     */
    protected $mockedClient;

    public function setUp()
    {
        $nullHandler = new NullHandler();
        $this->logger = new Logger('IO', [$nullHandler]);
        $this->mock = new MockHandler([]);
        $this->handler = HandlerStack::create($this->mock);

        $this->stack = [];
        $history = Middleware::history($this->stack);
        $this->handler->push($history);

        $this->mockedClient = new TestClient($this->handler);
    }

    /**
     * @return Client
     */
    public function getMockedClient()
    {
        return $this->mockedClient;
    }

    /**
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->getRequestForIndex(0);
    }

    /**
     * @param $index
     * @return Request
     */
    public function getRequestForIndex($index)
    {
        return $this->stack[$index]['request'];
    }

    /**
     * @param $responses
     */
    protected function addToExpectedResponses($responses)
    {
        $this->mock->append($responses);
    }


}