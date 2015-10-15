<?php

namespace App\Lib\Medium\Services;

use Illuminate\Database\Eloquent\Collection as Collection;

class MediumService{

  /**
   * Caching our requests posts for a few other calls
   * @var [type]
   */
  public $requestedPostsCollection = false;

  public function __construct(\GuzzleHttp\Client $client)
  {
    $this->client = $client;
  }

  /**
   * Getting our featured Post
   * @return [type] [description]
   */
  public function featuredPost()
  {

    if(! $this->requestedPostsCollection)
    {
      $this->posts();
    }

    $featuredPost = $this->requestedPostsCollection->first();
    $slug = str_replace("https://medium.com", "", $featuredPost->url);

    // Create a client with a base URI
    $client = new $this->client(['base_url' => 'https://medium.com']);
    $response = $client->get($slug . "?format=json");
    $body = $this->removeGarbage($response->getBody());
    $json = json_decode($body);

    $featuredPostModel = new \App\FeaturedPost();
    $featuredPostModel->paragraphs = $json->payload->value->content->bodyModel->paragraphs;
    $featuredPostModel->parse();

    return $featuredPostModel;

  }

  /**
   * Getting our most recent posts
   * @return [type] [description]
   */
  public function posts()
  {

    // Create a client with a base URI
    $client = new $this->client(['base_url' => 'https://medium.com']);
    $response = $client->get("/@bryantaxs?format=json");
    $body = $this->removeGarbage($response->getBody());
    $json = json_decode($body);

    $postsCollection = new Collection();

    // Create our models
    foreach($json->payload->latestPosts as $post)
    {
      $postsCollection->push( $this->createModel($post) );
    }

    // saving this for any other calls during the same request
    $this->requestedPostsCollection = $postsCollection;

    return $postsCollection;

  }

  /**
   * Creating a Post model from our raw Post json
   * @param  [type] $rawPost [description]
   * @return [type]          [description]
   */
  public function createModel($rawPost)
  {
    $postModel = new \App\Post();
    $postModel->title = $rawPost->title;
    $postModel->subtitle = $rawPost->virtuals->subtitle;
    $postModel->intro = $rawPost->virtuals->emailSnippet;
    $postModel->url = "https://medium.com/@bryantaxs/" . $rawPost->uniqueSlug;
    $postModel->published_at = $rawPost->firstPublishedAt;

    return $postModel;
  }

  /**
   * Removing some BS string from the beginning of our response
   * @param  [type] $string [description]
   * @return [type]         [description]
   */
  public function removeGarbage($string)
  {
    return str_replace("])}while(1);</x>","", $string);
  }

}