<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;


class MediumServiceTest extends TestCase
{

    // use DatabaseMigrations;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    // public function test_getProfileJSON()
    // {
    //     $service = $this->app->make("App\Lib\Services\MediumService");
    //     $service->isTesting = true;
    //     $data = $service->_getProfileJSON();
    //     $this->assertEquals(isset($data->success), true);
    // }

    /**
     * Article exists and is current
     * @return [type] [description]
     */
    // public function testProcessArticles_ExistsIsCurrent()
    // {

    //     $clientMock = Mockery::mock('GuzzleHttp\Client');
    //     $mock = Mockery::mock('App\Lib\Services\MediumService[articleExists, articleIsCurrent, getArticleFields, updateArticle, saveArticle]', [$clientMock]);
    //     $mock->shouldReceive("articleExists")->twice()->andReturn(1);
    //     $mock->shouldReceive("articleIsCurrent")->twice()->andReturn(1);
    //     $mock->isTesting = true;
    //     $data = $mock->processArticles();
    // }

    /**
     * Article exists and is current
     * @return [type] [description]
     */
    // public function testProcessArticles_ExistsIsNotCurrent()
    // {

    //     $clientMock = Mockery::mock('GuzzleHttp\Client');

    //     $mock = Mockery::mock('App\Lib\Services\MediumService[articleExists, articleIsCurrent, _getArticleFields, updateArticle, saveArticle]', [$clientMock]);
    //     $mock->shouldReceive("articleExists")->twice()->andReturn(1);
    //     $mock->shouldReceive("articleIsCurrent")->twice()->andReturn(0);
    //     $mock->shouldReceive("_getArticleFields")->twice()->andReturn([]);
    //     $mock->shouldReceive("updateArticle")->twice()->andReturn(true);
    //     $mock->isTesting = true;

    //     $data = $mock->processArticles();
    // }

    /**
     * Article exists and is current
     * @return [type] [description]
     */
    // public function testProcessArticles_DoesNotExist()
    // {

    //     $clientMock = Mockery::mock('GuzzleHttp\Client');
    //     $mock = Mockery::mock('App\Lib\Services\MediumService[articleExists, articleIsCurrent, _getArticleFields, updateArticle, saveArticle]', [$clientMock]);
    //     $mock->shouldReceive("articleExists")->twice()->andReturn(0);
    //     $mock->shouldReceive("_getArticleFields")->twice()->andReturn([]);
    //     $mock->shouldReceive("saveArticle")->twice()->andReturn(true);
    //     $mock->isTesting = true;
    //     $data = $mock->processArticles();
    // }

    // public function testGetArticleFields()
    // {
    //     $clientMock = Mockery::mock('GuzzleHttp\Client');
    //     $mock = Mockery::mock('App\Lib\Services\MediumService', [$clientMock])->makePartial();
    //     $mock->isTesting = true;

    //     $postObject = $mock->_getProfileJSON();
    //     $post = $postObject->payload->latestPosts[0];
    //     $data = $mock->_getArticleFields($post);

    //     $this->assertEquals($data["name"], "How you run is how you do everything");
    //     $this->assertEquals($data["subtitle"], "A few thoughts I had, coincidentally enough, while running.");
    //     $this->assertEquals($data["paragraph_1"], "70% of the time I’m focused a few steps ahead. Conscious enough to dodge obstacles a strides length away; more importantly, working through larger — more grandiose — challenges, beyond the immediacy of the path.");
    //     $this->assertEquals($data["paragraph_2"], "20% of the time my glance moves upward, surveying the environment and being appreciative of the beauty within the run. During this time, the infuriating nuances of the daily grind seem so small and petty. Cares fade away and a smile emerges, finding solitude surveying the world I’m passing.");
    //     $this->assertEquals($data["slug"], "how-you-run-is-how-you-do-everything-4b68d2c27eca");
    //     $this->assertEquals($data["latest_published_version"], "32be5f6e8155");
    //     $this->assertEquals($data["post_date"], 1445529215725);
    //     $this->assertEquals($data["medium_url"], "https://medium.com/@bryantaxs/how-you-run-is-how-you-do-everything-4b68d2c27eca");
    //     $this->assertEquals($data["article_id"], "4b68d2c27eca");
    // }

    public function testProcessArticles()
    {
        $service = $this->app->make("App\Lib\Services\MediumService");
        $service->processArticles();
    }

}
