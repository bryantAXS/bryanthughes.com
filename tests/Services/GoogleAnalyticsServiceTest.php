<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use GuzzleHttp\Client;
// use GuzzleHttp\Handler\MockHandler;
// use GuzzleHttp\HandlerStack;
// use GuzzleHttp\Psr7\Response;


class GoogleAnalyticsServiceTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGet()
    {

        $service = $this->app->make("App\Lib\Services\GoogleAnalyticsService");
        $data = $service->getData();

        $this->assertEquals(isset($data["totalSessions"]), true);
        $this->assertEquals(isset($data["avgSessionDuration"]), true);

    }

}
