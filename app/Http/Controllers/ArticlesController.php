<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lib\Services\MediumService;
use App\Lib\Services\MediumArticleParserService;
use App\Article;

class ArticlesController extends Controller
{

    public function __construct(MediumService $medium)
    {
        $this->gaService = new \App\Lib\Services\GoogleAnalyticsService();
        $mediumService = $medium;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // analytics
        $analytics = \Cache::store("file")->get("analytics", false);

        if(!$analytics)
        {
          $analytics = $this->gaService->getData();
          \Cache::store("file")->put("analytics", $analytics, 360);
        }

        // articles
        $articles = Article::orderBy("post_date")->take(9)->get();
        $featuredArticle = $articles->pop();
        $featuredArticle->paragraph_1_first_letter = substr($featuredArticle->paragraph_1, 0, 1);
        $featuredArticle->paragraph_1_display_text = substr($featuredArticle->paragraph_1, 1);

        $articles = $articles->reverse();

        // number of commits
        $number = shell_exec("git rev-list HEAD --count");
        $number = (int) str_replace("\n", "", $number);

        return view('index', [
            "analytics" => [
                "avgSessionDuration" => round($analytics["avgSessionDuration"] / 60, 1),
                "totalSessions" => $this->_formatNumber($analytics["totalSessions"])
            ],
            "totalCommits" => $number,
            "articles" => $articles,
            "featuredArticle" => $featuredArticle
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $results = Article::where("slug", $id)->get();

        // send them to the home page
        if(! $results->count())
        {
            return redirect("/");
        }

        // send them to the medium page
        else
        {

            $article = $results->first();

            if(\Crawler::isCrawler()) {
                $articleJson = json_decode($article->json);
                $paragraphs = $articleJson->content->bodyModel->paragraphs;

                $service = new MediumArticleParserService();
                $paragraphs = $service->parse($paragraphs);

                return view('article', [
                    "article" => $article,
                    "paragraphs" => $paragraphs
                ]);
            }

            else
            {
                return redirect($article->medium_url);
            }

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function _formatNumber($n)
    {
        // first strip any formatting;
        $n = (0+str_replace(",","",$n));

        // is this a number?
        if(!is_numeric($n)) return false;

        // now filter it;
        if($n>1000000000000) return round(($n/1000000000000),1).' trillion';
        else if($n>1000000000) return round(($n/1000000000),1).' billion';
        else if($n>1000000) return round(($n/1000000),1).' million';
        else if($n>1000) return round(($n/1000),1).' K';

        return number_format($n);
    }
}
