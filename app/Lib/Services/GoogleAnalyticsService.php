<?php

namespace App\Lib\Services;

class GoogleAnalyticsService{

  public $apikey = "AIzaSyCg14NFJ5o8YWya9Qw185ejJTouVGF0rEo";

  public $client;
  public $service;

  public function __construct()
  {

    $this->client = new \Google_Client();
    $this->client->setApplicationName("BryantHughes.com");
    $this->client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
    $this->service = new \Google_Service_Analytics($this->client);

    $key = file_get_contents(base_path() . "/BryantHughes-9a9ccece839d.p12");

    $cred = new \Google_Auth_AssertionCredentials(
        "89063657226-flehl1lkgfnkpul47huhgo0sn66apifu@developer.gserviceaccount.com",
        array(\Google_Service_Analytics::ANALYTICS_READONLY),
        $key
    );

    $this->client->setAssertionCredentials($cred);
    if($this->client->getAuth()->isAccessTokenExpired())
    {
      $this->client->getAuth()->refreshTokenWithAssertion($cred);
    }

  }

  public function getData()
  {

    $data = $this->service->data_ga->get(
       'ga:17966247',
       '3650daysAgo',
       'today',
       'ga:sessions, ga:avgSessionDuration');

    return [
      "avgSessionDuration" => (float) $data["rows"][0][1],
      "totalSessions" => (int) $data["rows"][0][0],
    ];

  }

}
