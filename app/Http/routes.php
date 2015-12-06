<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', "ArticlesController@index");
Route::get("/articles/{slug}", "ArticlesController@show");

Route::get('sitemap', function(){

    // create new sitemap object
    $sitemap = App::make("sitemap");

    // add items to the sitemap (url, date, priority, freq)
    $sitemap->add(URL::to('/'), date("Y-m-d H:i:s"), '1.0', 'daily');

    // get all posts from db
    $articles = \App\Article::orderBy("post_date")->get();

    // add every post to the sitemap
    foreach ($articles as $article)
    {
      $url = URL::to("/articles/" . $article->slug);
      $sitemap->add($url, $article->updated_at, '0.7', 'monthly');
    }

    return $sitemap->render('xml');

});

// manual processing of articles
Route::get("/asdfh4kljh23lh4", function(){
  $service = $this->app->make('App\Lib\Services\MediumService');
  $service->processArticles();
});