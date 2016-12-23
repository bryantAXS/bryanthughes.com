<?php

namespace App\Lib\Services;

class GoogleAnalyticsService{

  public $apikey = "AIzaSyCg14NFJ5o8YWya9Qw185ejJTouVGF0rEo";

  public $client;
  public $service;

  public function __construct()
  {


    $client = new \Google_Client();
    $client->setApplicationName("BryantHughes.com");
    $client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
    $client->setDeveloperKey($this->apikey);

    $this->service = new \Google_Service_Analytics($client);

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
