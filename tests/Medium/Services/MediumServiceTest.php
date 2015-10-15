<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use GuzzleHttp\Client;
// use GuzzleHttp\Handler\MockHandler;
// use GuzzleHttp\HandlerStack;
// use GuzzleHttp\Psr7\Response;


class MediumServiceTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testPosts()
    {

        $service = $this->app->make("App\Lib\Medium\Services\MediumService");
        $postsCollection = $service->posts();

        $post = $postsCollection->first();

        $this->assertTrue(isset($post->title));
        $this->assertTrue(isset($post->subtitle));
        $this->assertTrue(isset($post->intro));
        $this->assertTrue(isset($post->url));
        $this->assertTrue(isset($post->published_at));

    }

    public function testFeaturedPost()
    {
        $service = $this->app->make("App\Lib\Medium\Services\MediumService");
        $featuredPost = $service->featuredPost();

        $this->assertTrue(isset($featuredPost->title));
        $this->assertTrue(isset($featuredPost->subtitle));
        $this->assertTrue(isset($featuredPost->intro));
        $this->assertTrue(isset($featuredPost->intro2));
    }

}
