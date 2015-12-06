<?php

namespace App\Lib\Services;

use Illuminate\Database\Eloquent\Collection as Collection;
use \App\Article as Article;

class MediumService{

  public $isTesting = false;

  public function __construct(\GuzzleHttp\Client $client)
  {
    $this->client = $client;
  }

  /**
   * Kicking things off
   * @return [type] [description]
   */
  public function processArticles()
  {

    $profileJson = $this->_getProfileJSON();
    $latestPosts = $profileJson->payload->latestPosts;

    foreach($latestPosts as $post)
    {

      if($this->articleExists($post->id))
      {

        if(! $this->articleIsCurrent($post->latestPublishedVersion))
        {

          // Updating article
          $articleId = $post->id;
          $articleFields = $this->_getArticleFields($post);
          $this->updateArticle($articleId, $articleFields);

        }

      }

      else{

        // Save article
        $articleFields = $this->_getArticleFields($post);
        $this->saveArticle($articleFields);

      }

    }

    return true;

  }

  /**
   * Does the article exist?
   * @param  [type] $latestPublishedVersion [description]
   * @return [type]                         [description]
   */
  public function articleExists($articleId)
  {
    $count = Article::where("article_id", $articleId)->count();
    return $count;
  }

  /**
   * Do we have an article that matches the lastest published version?
   * @param  [type] $latestPublishedVersion [description]
   * @return [type]                         [description]
   */
  public function articleIsCurrent($latestPublishedVersion)
  {
    return Article::where("latest_published_version", $latestPublishedVersion)->count();
  }

  /**
   * Save a new article
   * @return [type] [description]
   */
  public function updateArticle($articleId, $articleFields)
  {
    $article = Article::where("article_id", $articleId)->first();
    $article->fill($articleFields);
    $article->save();
  }

  /**
   * Save a new article
   * @return [type] [description]
   */
  public function saveArticle($articleFields)
  {
    $article = new \App\Article();
    $article->fill($articleFields);
    $article->save();
  }

  /**
   * Getting the fields we want to submit into our model
   * @return [type] [description]
   */
  public function _getArticleFields($postObject)
  {

    $json = $this->_getArticleJson("@bryantaxs", $postObject->uniqueSlug);
    $articleData = $json->payload->value;

    return [
      "name" => $articleData->title,
      "subtitle" => $articleData->content->subtitle,
      "paragraph_1" => $articleData->content->bodyModel->paragraphs[2]->text,
      "paragraph_2" => $articleData->content->bodyModel->paragraphs[3]->text,
      "slug" => $articleData->uniqueSlug,
      "latest_published_version" => $articleData->latestPublishedVersion,
      "post_date" => $articleData->latestPublishedAt,
      "medium_url" => $articleData->canonicalUrl,
      "json" => json_encode($articleData),
      "article_id" => $articleData->id,
    ];

  }

  /**
   * Getting the JSON from our profile
   * @return [type] [description]
   */
  public function _getProfileJSON()
  {

    if($this->isTesting)
    {
      $body = '])}while(1);</x>{"success":true,"payload":{"value":{"userId":"9c91192bec64","name":"Bryant Hughes","username":"bryantaxs","createdAt":1366033582061,"lastPostCreatedAt":1444792284443,"imageId":"1*ZB608XuWmWIlXwM76JDIoA.png","backgroundImageId":"","bio":"Web developer, designer, and partner at @authenticff","twitterScreenName":"BryantAXS","facebookAccountId":"","type":"User"},"collections":[],"collectionCount":0,"latestPosts":[{"id":"4b68d2c27eca","versionId":"32be5f6e8155","creatorId":"9c91192bec64","homeCollectionId":"","title":"How you run is how you do everything","detectedLanguage":"en","latestVersion":"32be5f6e8155","latestPublishedVersion":"32be5f6e8155","hasUnpublishedEdits":false,"latestRev":447,"createdAt":1444792284443,"updatedAt":1445529215725,"acceptedAt":0,"firstPublishedAt":1445525752347,"latestPublishedAt":1445529215725,"isRead":false,"vote":false,"experimentalCss":"","displayAuthor":"","virtuals":{"createdAtRelative":"a month ago","updatedAtRelative":"20 days ago","acceptedAtRelative":"","createdAtEnglish":"October 13, 2015","updatedAtEnglish":"October 22, 2015","acceptedAtEnglish":"","firstPublishedAtEnglish":"October 22, 2015","latestPublishedAtEnglish":"October 22, 2015","allowNotes":true,"snippet":"A few thoughts I had, coincidentally enough, while running.","previewImage":{"imageId":"","filter":"","backgroundSize":"","originalWidth":0,"originalHeight":0,"strategy":"resample","height":0,"width":0},"wordCount":244,"imageCount":0,"readingTime":0.9207547169811321,"subtitle":"A few thoughts I had, coincidentally enough, while running.","userPostRelation":{"userId":"9c91192bec64","postId":"4b68d2c27eca","readAt":1445791974703,"readLaterAddedAt":0,"votedAt":0,"collaboratorAddedAt":0,"notesAddedAt":0,"subscribedAt":0,"lastReadSectionName":"38fa","lastReadVersionId":"32be5f6e8155","lastReadAt":1445529310679,"lastReadParagraphName":"5735","lastReadPercentage":0.07,"viewedAt":1445791974620},"usersBySocialRecommends":[],"latestPublishedAtAbbreviated":"Oct 22","firstPublishedAtAbbreviated":"Oct 22","emailSnippet":"70% of the time I’m focused a few steps ahead. Conscious enough to dodge obstacles a strides length away; more importantly, working through larger — more grandiose — challenges, beyond the immediacy of the path. ¶\n\n20% of the time my glance moves upward, surveying the environment and being appreciative of the beauty within the run. During this time, the infuriating nuances of the daily grind seem so small and petty.","recommends":0,"isBookmarked":false,"tags":[{"slug":"running","name":"Running","postCount":1244,"virtuals":{"isFollowing":false,"newTopStoriesCount":0},"metadata":{"followerCount":404,"postCount":1244,"coverImage":{"id":"1*XgSiEKDNLw8t1OvtviY6xw.jpeg","originalWidth":1754,"originalHeight":1754}},"type":"Tag"},{"slug":"meditation","name":"Meditation","postCount":732,"virtuals":{"isFollowing":false,"newTopStoriesCount":0},"metadata":{"followerCount":216,"postCount":732,"coverImage":{"id":"1*EZl-yMKkU89uKo9wej9P7Q.jpeg","originalWidth":4896,"originalHeight":6528,"backgroundSize":"","filter":"","isFeatured":false,"externalSrc":""}},"type":"Tag"},{"slug":"life","name":"Life","postCount":16232,"virtuals":{"isFollowing":false,"newTopStoriesCount":0},"metadata":{"followerCount":68477,"postCount":16232,"coverImage":{"id":"1*1GCFaiYT8nLHQ6kmu284SA.png","originalWidth":1024,"originalHeight":512}},"type":"Tag"}],"socialRecommendsCount":0,"responsesCreatedCount":0},"coverless":true,"slug":"how-you-run-is-how-you-do-everything","translationSourcePostId":"","translationSourceCreatorId":"","isApprovedTranslation":false,"inResponseToPostId":"","inResponseToRemovedAt":0,"isTitleSynthesized":true,"allowResponses":true,"importedUrl":"","importedPublishedAt":0,"visibility":0,"isViewed":false,"uniqueSlug":"how-you-run-is-how-you-do-everything-4b68d2c27eca","previewContent":{"bodyModel":{"paragraphs":[{"name":"e45c","type":3,"text":"How you run is how you do everything","markups":[],"alignment":1},{"name":"53ee","type":1,"text":"A few thoughts I had, coincidentally enough, while running.","markups":[],"alignment":1},{"name":"5735","type":1,"text":"70% of the time I’m focused a few steps ahead. Conscious enough to dodge obstacles a strides length away; more importantly, working through larger — more grandiose — challenges…","markups":[],"alignment":1}],"sections":[{"startIndex":0}]},"isFullContent":false},"license":0,"inResponseToMediaResourceId":"","approvedHomeCollectionId":"","newsletterId":"","isGeneratedSurrogate":false,"canonicalMediaResourceId":"","type":"Post"},{"id":"a39fd52586eb","versionId":"7095e540deb5","creatorId":"9c91192bec64","homeCollectionId":"","title":"Working for free","detectedLanguage":"en","latestVersion":"7095e540deb5","latestPublishedVersion":"7095e540deb5","hasUnpublishedEdits":false,"latestRev":-1,"createdAt":1381074037627,"updatedAt":1381158444397,"acceptedAt":0,"firstPublishedAt":1381085704905,"latestPublishedAt":1381158444397,"isRead":false,"vote":false,"experimentalCss":"","displayAuthor":"","virtuals":{"createdAtRelative":"2 years ago","updatedAtRelative":"2 years ago","acceptedAtRelative":"","createdAtEnglish":"October 6, 2013","updatedAtEnglish":"October 7, 2013","acceptedAtEnglish":"","firstPublishedAtEnglish":"October 6, 2013","latestPublishedAtEnglish":"October 7, 2013","allowNotes":true,"snippet":"Why is there such a stigma against pro bono work? ","previewImage":{"imageId":"0*b2UsA1baVPHvAWv4.jpeg","filter":"","backgroundSize":"","originalWidth":699,"originalHeight":466,"strategy":"resample","height":0,"width":0},"wordCount":640,"imageCount":1,"readingTime":2.6150943396226416,"subtitle":"Why is there such a stigma against pro bono work? ","userPostRelation":{"userId":"9c91192bec64","postId":"a39fd52586eb","readAt":1404826171920,"readLaterAddedAt":0,"votedAt":0,"collaboratorAddedAt":0,"notesAddedAt":0,"subscribedAt":0,"lastReadSectionName":"","lastReadVersionId":"","lastReadAt":0,"lastReadParagraphName":"","lastReadPercentage":0,"viewedAt":0},"usersBySocialRecommends":[],"latestPublishedAtAbbreviated":"Oct 7, 2013","firstPublishedAtAbbreviated":"Oct 6, 2013","emailSnippet":"I commented on a posting a few weeks ago by Dan Petty, where he tells how he started doing work for acclaimed watch maker Nixon. The story is fairly common in the web services industry: company needs work done, freelancer admires company and offers to do work for free, company appreciates work and (fingers crossed) a new relationship is formed. My comment mentioned it was great to see free work being appreciated by Nixon, and having it turn into a meaningful client relationship.","recommends":5,"isBookmarked":false,"tags":[],"socialRecommendsCount":0,"responsesCreatedCount":0},"coverless":true,"slug":"working-for-free","translationSourcePostId":"","translationSourceCreatorId":"","isApprovedTranslation":false,"inResponseToPostId":"","inResponseToRemovedAt":0,"isTitleSynthesized":false,"allowResponses":true,"importedUrl":"","importedPublishedAt":0,"visibility":0,"isViewed":false,"uniqueSlug":"working-for-free-a39fd52586eb","previewContent":{"bodyModel":{"paragraphs":[{"type":4,"text":"","layout":9,"metadata":{"id":"0*b2UsA1baVPHvAWv4.jpeg","originalWidth":699,"originalHeight":466}},{"name":"title","type":2,"text":"Working for free","alignment":1},{"name":"subtitle","type":13,"text":"Why is there such a stigma against pro bono work? ","alignment":1}],"sections":[{"startIndex":0}]},"isFullContent":false},"license":0,"inResponseToMediaResourceId":"","approvedHomeCollectionId":"","newsletterId":"","isGeneratedSurrogate":false,"canonicalMediaResourceId":"","type":"Post"}],"postsRecommendedByUser":[{"id":"45dbfeaa37c8","versionId":"e9f8b60143f9","creatorId":"7aa8a43f8aa1","homeCollectionId":"d16afa0ae7c","title":"Why Instagram Worked","detectedLanguage":"en","latestVersion":"e9f8b60143f9","latestPublishedVersion":"e9f8b60143f9","hasUnpublishedEdits":false,"latestRev":539,"createdAt":1413310521259,"updatedAt":1445034321484,"acceptedAt":0,"firstPublishedAt":1413819597147,"latestPublishedAt":1445034321484,"isRead":false,"vote":true,"experimentalCss":"","displayAuthor":"","virtuals":{"statusForCollection":"APPROVED","createdAtRelative":"a year ago","updatedAtRelative":"a month ago","acceptedAtRelative":"","createdAtEnglish":"October 14, 2014","updatedAtEnglish":"October 16, 2015","acceptedAtEnglish":"","firstPublishedAtEnglish":"October 20, 2014","latestPublishedAtEnglish":"October 16, 2015","allowNotes":true,"snippet":"A co-founder looks back at how a stalled project turned into a historic success","previewImage":{"imageId":"1*mrqD2QKUyD70IBlT-L3O3g.png","filter":"","backgroundSize":"","originalWidth":607,"originalHeight":605,"strategy":"resample","height":0,"width":0},"wordCount":1184,"imageCount":13,"readingTime":5.867924528301886,"subtitle":"A co-founder looks back at how a stalled project turned into a historic success","userPostRelation":{"userId":"9c91192bec64","postId":"45dbfeaa37c8","readAt":1420728863202,"readLaterAddedAt":0,"votedAt":1420728870963,"collaboratorAddedAt":0,"notesAddedAt":0,"subscribedAt":0,"lastReadSectionName":"2b1f","lastReadVersionId":"ee762c790cd2","lastReadAt":1420728869197,"lastReadParagraphName":"a8b1","lastReadPercentage":0,"viewedAt":1420728857088},"publishedInCount":1,"usersBySocialRecommends":[],"latestPublishedAtAbbreviated":"Oct 16","firstPublishedAtAbbreviated":"Oct 20, 2014","emailSnippet":"Earlier this month we marked four years since Instagram launched. Throughout the day, I glanced at what time it was, and thought back to what we were doing four years ago: ¶\n\n6am: Biking through a misty San Francisco morning to our shared co-working space at Dogpatch Labs. ¶\n\n7am: Stomach in knots, Kevin and I scarf down bagels from Crossroads Cafe. ¶\n\n8am: Press embargo lifts, our first users come streaming in.","recommends":1774,"isBookmarked":false,"tags":[{"slug":"tech","name":"Tech","postCount":16204,"virtuals":{"isFollowing":false,"newTopStoriesCount":0},"metadata":{"followerCount":126701,"postCount":16204,"coverImage":{"id":"1*1mSVg0Ry2Jxywr04dBo49w.jpeg","originalWidth":8256,"originalHeight":6192}},"type":"Tag"},{"slug":"instagram","name":"Instagram","postCount":1972,"virtuals":{"isFollowing":false,"newTopStoriesCount":0},"metadata":{"followerCount":196,"postCount":1972,"coverImage":{"id":"1*CYnAiVKQctEAqj4qhDt2Ww.jpeg","originalWidth":1400,"originalHeight":932}},"type":"Tag"}],"socialRecommendsCount":0,"responsesCreatedCount":3},"coverless":true,"slug":"why-instagram-worked","translationSourcePostId":"","translationSourceCreatorId":"","isApprovedTranslation":false,"inResponseToPostId":"","inResponseToRemovedAt":0,"isTitleSynthesized":false,"allowResponses":true,"importedUrl":"","importedPublishedAt":0,"visibility":0,"isViewed":false,"uniqueSlug":"why-instagram-worked-45dbfeaa37c8","previewContent":{"bodyModel":{"paragraphs":[{"name":"previewImage","type":4,"text":"","layout":10,"metadata":{"id":"1*mrqD2QKUyD70IBlT-L3O3g.png","originalWidth":607,"originalHeight":605,"isFeatured":true}},{"name":"4741","type":2,"text":"Why Instagram Worked","markups":[],"alignment":1},{"name":"7642","type":13,"text":"A co-founder looks back at how a stalled project turned into a historic success","markups":[],"alignment":1}],"sections":[{"startIndex":0}]},"isFullContent":false},"license":0,"inResponseToMediaResourceId":"","approvedHomeCollectionId":"d16afa0ae7c","newsletterId":"","isGeneratedSurrogate":false,"canonicalMediaResourceId":"","type":"Post"},{"id":"5bdce3bf56d","versionId":"4267a9d9859b","creatorId":"649a600711ea","homeCollectionId":"","title":"You Can Quit Tomorrow","detectedLanguage":"en","latestVersion":"4267a9d9859b","latestPublishedVersion":"4267a9d9859b","hasUnpublishedEdits":false,"latestRev":456,"createdAt":1403615955320,"updatedAt":1404912146494,"acceptedAt":0,"firstPublishedAt":1404499421079,"latestPublishedAt":1404912146494,"isRead":false,"vote":true,"experimentalCss":"","displayAuthor":"","virtuals":{"createdAtRelative":"a year ago","updatedAtRelative":"a year ago","acceptedAtRelative":"","createdAtEnglish":"June 24, 2014","updatedAtEnglish":"July 9, 2014","acceptedAtEnglish":"","firstPublishedAtEnglish":"July 4, 2014","latestPublishedAtEnglish":"July 9, 2014","allowNotes":true,"snippet":"The Art of Not Giving Up","previewImage":{"imageId":"1*0QjXXIAV9hU5KdDa2vDYUg.jpeg","filter":"","backgroundSize":"","originalWidth":1600,"originalHeight":1200,"strategy":"resample","height":0,"width":0},"wordCount":564,"imageCount":1,"readingTime":2.328301886792453,"subtitle":"The Art of Not Giving Up","userPostRelation":{"userId":"9c91192bec64","postId":"5bdce3bf56d","readAt":1404914603330,"readLaterAddedAt":1445551163531,"votedAt":1404913260216,"collaboratorAddedAt":0,"notesAddedAt":0,"subscribedAt":0,"lastReadSectionName":"5364","lastReadVersionId":"4267a9d9859b","lastReadAt":1404914599153,"lastReadParagraphName":"3157","lastReadPercentage":0,"viewedAt":1404914534396},"usersBySocialRecommends":[],"latestPublishedAtAbbreviated":"Jul 9, 2014","firstPublishedAtAbbreviated":"Jul 4, 2014","emailSnippet":"There’s a reason why rowing is not the most popular sport. ¶\n\nTruth is, it’s a gruelling sport. I’ve been rowing for 5 years and it has never, not for one day, gotten any easier. Some days feel like my last in this sport. I feel defeated by it sometimes, unable to drill down the barrier between blissful gliding and exhausted scraping down the river. ¶\n\nShowing up at the dock before the sun comes out is a whole different challenge.","recommends":78,"isBookmarked":true,"tags":[],"socialRecommendsCount":0,"responsesCreatedCount":0},"coverless":true,"slug":"you-can-quit-tomorrow","translationSourcePostId":"","translationSourceCreatorId":"","isApprovedTranslation":false,"inResponseToPostId":"","inResponseToRemovedAt":0,"isTitleSynthesized":false,"allowResponses":true,"importedUrl":"","importedPublishedAt":0,"visibility":0,"isViewed":false,"uniqueSlug":"you-can-quit-tomorrow-5bdce3bf56d","previewContent":{"bodyModel":{"paragraphs":[{"name":"1*0QjXXIAV9hU5KdDa2vDYUg.jpeg","type":4,"text":"","layout":10,"metadata":{"id":"1*0QjXXIAV9hU5KdDa2vDYUg.jpeg","originalWidth":1600,"originalHeight":1200}},{"name":"title","type":2,"text":"You Can Quit Tomorrow","alignment":1},{"name":"subtitle","type":13,"text":"The Art of Not Giving Up","alignment":1}],"sections":[{"startIndex":0}]},"isFullContent":false},"license":0,"inResponseToMediaResourceId":"","approvedHomeCollectionId":"","newsletterId":"","isGeneratedSurrogate":false,"canonicalMediaResourceId":"","type":"Post"},{"id":"799d16952a56","versionId":"9ab2df24aa1a","creatorId":"bbd0bfc27bc1","homeCollectionId":"","title":"Resources","detectedLanguage":"en","latestVersion":"9ab2df24aa1a","latestPublishedVersion":"9ab2df24aa1a","hasUnpublishedEdits":false,"latestRev":758,"createdAt":1385042901444,"updatedAt":1439276980455,"acceptedAt":0,"firstPublishedAt":1385408215571,"latestPublishedAt":1406299337202,"isRead":false,"vote":true,"experimentalCss":"","displayAuthor":"","virtuals":{"createdAtRelative":"2 years ago","updatedAtRelative":"3 months ago","acceptedAtRelative":"","createdAtEnglish":"November 21, 2013","updatedAtEnglish":"August 11, 2015","acceptedAtEnglish":"","firstPublishedAtEnglish":"November 25, 2013","latestPublishedAtEnglish":"July 25, 2014","allowNotes":true,"snippet":"200+ sites, apps & books that I recommend any designer should check out.","previewImage":{"imageId":"1*v73r3CaXzZu0XyfR_7s2bQ.jpeg","filter":"grey","backgroundSize":"","originalWidth":4845,"originalHeight":3230,"strategy":"resample","height":0,"width":0},"wordCount":1158,"imageCount":1,"readingTime":4.5698113207547175,"subtitle":"200+ sites, apps & books that I recommend any designer should check out.","userPostRelation":{"userId":"9c91192bec64","postId":"799d16952a56","readAt":1404744938988,"readLaterAddedAt":0,"votedAt":1404744942680,"collaboratorAddedAt":0,"notesAddedAt":0,"subscribedAt":0,"lastReadSectionName":"47a0","lastReadVersionId":"3736490a4c5","lastReadAt":1404744953245,"lastReadParagraphName":"8cf5","lastReadPercentage":0,"viewedAt":1404744892273},"usersBySocialRecommends":[],"latestPublishedAtAbbreviated":"Jul 25, 2014","firstPublishedAtAbbreviated":"Nov 25, 2013","emailSnippet":"Exciting news! — This list has been turned into a web app — http://oozled.com ¶\n\nI’ve written this as a reference guide for any designer looking for resources for their web projects. If you’ve got something you want to add please now submit it to http://oozled.com ¶\n\nCurrently 200+ Resources added. (Updated 15th May 2014) ¶\n\nPhotography ¶\n\nFree ¶\n\nUnsplash — www.unsplash.com ¶\n\nPicjumbo — www.picjumbo.com","recommends":1738,"isBookmarked":false,"tags":[],"socialRecommendsCount":0,"responsesCreatedCount":2},"coverless":true,"slug":"resources","translationSourcePostId":"","translationSourceCreatorId":"","isApprovedTranslation":false,"inResponseToPostId":"","inResponseToRemovedAt":0,"isTitleSynthesized":false,"allowResponses":true,"importedUrl":"","importedPublishedAt":0,"visibility":0,"isViewed":false,"uniqueSlug":"resources-799d16952a56","previewContent":{"bodyModel":{"paragraphs":[{"name":"2d23","type":4,"text":"","layout":10,"metadata":{"id":"1*v73r3CaXzZu0XyfR_7s2bQ.jpeg","originalWidth":4845,"originalHeight":3230,"filter":"grey"}},{"name":"title","type":2,"text":"Resources","markups":[],"alignment":1},{"name":"subtitle","type":13,"text":"200+ sites, apps & books that I recommend any designer should check out.","markups":[],"alignment":1}],"sections":[{"startIndex":0}]},"isFullContent":false},"license":0,"inResponseToMediaResourceId":"","approvedHomeCollectionId":"","newsletterId":"","isGeneratedSurrogate":false,"canonicalMediaResourceId":"","type":"Post"}],"recommendedPosts":[{"id":"a39fd52586eb","versionId":"7095e540deb5","creatorId":"9c91192bec64","homeCollectionId":"","title":"Working for free","detectedLanguage":"en","latestVersion":"7095e540deb5","latestPublishedVersion":"7095e540deb5","hasUnpublishedEdits":false,"latestRev":-1,"createdAt":1381074037627,"updatedAt":1381158444397,"acceptedAt":0,"firstPublishedAt":1381085704905,"latestPublishedAt":1381158444397,"isRead":false,"vote":false,"experimentalCss":"","displayAuthor":"","virtuals":{"createdAtRelative":"2 years ago","updatedAtRelative":"2 years ago","acceptedAtRelative":"","createdAtEnglish":"October 6, 2013","updatedAtEnglish":"October 7, 2013","acceptedAtEnglish":"","firstPublishedAtEnglish":"October 6, 2013","latestPublishedAtEnglish":"October 7, 2013","allowNotes":true,"snippet":"Why is there such a stigma against pro bono work? ","previewImage":{"imageId":"0*b2UsA1baVPHvAWv4.jpeg","filter":"","backgroundSize":"","originalWidth":699,"originalHeight":466,"strategy":"resample","height":0,"width":0},"wordCount":640,"imageCount":1,"readingTime":2.6150943396226416,"subtitle":"Why is there such a stigma against pro bono work? ","userPostRelation":{"userId":"9c91192bec64","postId":"a39fd52586eb","readAt":1404826171920,"readLaterAddedAt":0,"votedAt":0,"collaboratorAddedAt":0,"notesAddedAt":0,"subscribedAt":0,"lastReadSectionName":"","lastReadVersionId":"","lastReadAt":0,"lastReadParagraphName":"","lastReadPercentage":0,"viewedAt":0},"usersBySocialRecommends":[],"latestPublishedAtAbbreviated":"Oct 7, 2013","firstPublishedAtAbbreviated":"Oct 6, 2013","emailSnippet":"I commented on a posting a few weeks ago by Dan Petty, where he tells how he started doing work for acclaimed watch maker Nixon. The story is fairly common in the web services industry: company needs work done, freelancer admires company and offers to do work for free, company appreciates work and (fingers crossed) a new relationship is formed. My comment mentioned it was great to see free work being appreciated by Nixon, and having it turn into a meaningful client relationship.","recommends":5,"isBookmarked":false,"tags":[],"socialRecommendsCount":0,"responsesCreatedCount":0},"coverless":true,"slug":"working-for-free","translationSourcePostId":"","translationSourceCreatorId":"","isApprovedTranslation":false,"inResponseToPostId":"","inResponseToRemovedAt":0,"isTitleSynthesized":false,"allowResponses":true,"importedUrl":"","importedPublishedAt":0,"visibility":0,"isViewed":false,"uniqueSlug":"working-for-free-a39fd52586eb","previewContent":{"bodyModel":{"paragraphs":[{"type":4,"text":"","layout":9,"metadata":{"id":"0*b2UsA1baVPHvAWv4.jpeg","originalWidth":699,"originalHeight":466}},{"name":"title","type":2,"text":"Working for free","alignment":1},{"name":"subtitle","type":13,"text":"Why is there such a stigma against pro bono work? ","alignment":1}],"sections":[{"startIndex":0}]},"isFullContent":false},"license":0,"inResponseToMediaResourceId":"","approvedHomeCollectionId":"","newsletterId":"","isGeneratedSurrogate":false,"canonicalMediaResourceId":"","type":"Post"}],"featuredPost":null,"quotedPosts":[],"references":{"Social":{"9c91192bec64":{"userId":"9c91192bec64","targetUserId":"9c91192bec64","type":"Social"}},"SocialStats":{"9c91192bec64":{"userId":"9c91192bec64","usersFollowedCount":61,"usersFollowedByCount":134,"type":"SocialStats"}},"User":{"9c91192bec64":{"userId":"9c91192bec64","name":"Bryant Hughes","username":"bryantaxs","createdAt":1366033582061,"lastPostCreatedAt":1444792284443,"imageId":"1*ZB608XuWmWIlXwM76JDIoA.png","backgroundImageId":"","bio":"Web developer, designer, and partner at @authenticff","twitterScreenName":"BryantAXS","facebookAccountId":"","type":"User"},"7aa8a43f8aa1":{"userId":"7aa8a43f8aa1","name":"Mike Krieger","username":"mikekrieger","createdAt":1413305960569,"lastPostCreatedAt":1445306431210,"imageId":"0*nqpiPFdEnxXOJzvE.jpg","backgroundImageId":"","bio":"","twitterScreenName":"mikeyk","facebookAccountId":"10101323476214853","type":"User"},"649a600711ea":{"userId":"649a600711ea","name":"Ricardo Vazquez","username":"iamrvazquez","createdAt":1367192147401,"lastPostCreatedAt":1444699516663,"imageId":"0*-iW-EVRV4WhT2a_d.png","backgroundImageId":"1*kAjbSEbYR70k8lAnZkrWLw.jpeg","bio":"UI/UX Designer at Mozilla. Teacher. Rower. Interested in culture, design, aesthetic, wit, reality, thought, and the pursuit of happiness.","twitterScreenName":"iamrvazquez","facebookAccountId":"","type":"User"},"bbd0bfc27bc1":{"userId":"bbd0bfc27bc1","name":"Dan Edwards","username":"de","createdAt":1368376591638,"lastPostCreatedAt":1444075689940,"imageId":"1*Sed7ECYnkXfaoLFcvxRGRA.jpeg","backgroundImageId":"1*d4q_56xEp-R24lYxpr_jRA.jpeg","bio":"Creative Director / Co-Founder @NoDivide, Surfer, Occasional Doodler and co-founder of oozled.com","twitterScreenName":"de","facebookAccountId":"","type":"User"}},"Collection":{"d16afa0ae7c":{"id":"d16afa0ae7c","name":"Backchannel","slug":"backchannel","tags":[],"creatorId":"efbf32ca8675","description":"Mining the tech world for lively and meaningful tales and analysis.","shortDescription":"Mining the tech world for lively and meaningful tales and…","image":{"imageId":"1*VN9AINEbi2CS8bHWeu80GQ.png","filter":"","backgroundSize":"","originalWidth":0,"originalHeight":0,"strategy":"resample","height":0,"width":0},"metadata":{"followerCount":71463,"postCount":291,"activeAt":1447096177255},"virtuals":{"permissions":{"canPublish":false,"canPublishAll":false,"canRepublish":true,"canRemove":true,"canManageAll":false,"canSubmit":false,"canEditPosts":false,"canAddWriters":false,"canViewStats":false,"canSendNewsletter":false},"isSubscribed":false,"isNewsletterSubscribed":false},"logo":{"imageId":"1*CBYh7ADvcY9Z-WYUrJN2Gw.png","filter":"","backgroundSize":"","originalWidth":771,"originalHeight":99,"strategy":"resample","height":0,"width":0},"twitterUsername":"backchnnl","facebookPageName":"backchnnl","publicEmail":"backchannel@medium.com","collectionMastheadId":"6837e8bdabbb","domain":"","sections":[{"type":2,"collectionHeaderMetadata":{"title":"","description":"","backgroundImage":{"id":"","originalWidth":0,"originalHeight":0,"backgroundSize":"","filter":"","isFeatured":false,"externalSrc":""},"logoImage":{"id":"1*CBYh7ADvcY9Z-WYUrJN2Gw.png","originalWidth":771,"originalHeight":99,"backgroundSize":"","filter":"","isFeatured":false,"externalSrc":""},"alignment":1,"layout":1}},{"type":1,"postListMetadata":{"source":3,"layout":4,"number":1,"postIds":["27c03098a657"],"tagSlug":"","posts":[]}},{"type":1,"postListMetadata":{"source":3,"layout":4,"number":3,"postIds":["3da03338cf35","ea016107cace","531a95e50c91"],"tagSlug":"","posts":[]}},{"type":1,"postListMetadata":{"source":3,"layout":4,"number":4,"postIds":["11a847cb37b7","f127a6646de8","7accd8c6a796","3a064595d48a"],"tagSlug":"","posts":[]}},{"type":1,"postListMetadata":{"source":4,"layout":4,"number":3,"postIds":[],"tagSlug":"Opinion","posts":[]}},{"type":1,"postListMetadata":{"source":4,"layout":5,"number":3,"postIds":[],"tagSlug":"War Stories","posts":[]}},{"type":1,"postListMetadata":{"source":1,"layout":4,"number":8,"postIds":[],"tagSlug":"","posts":[]}}],"type":"Collection"}}}},"v":3,"b":"18451-d8809de"}';
    }

    else
    {
      // Create a client with a base URI
      $client = new $this->client(['base_url' => 'https://medium.com']);
      $body = $client->get("https://medium.com/@bryantaxs?format=json")->getBody();
    }

    $json = $this->_removeGarbage($body);

    return json_decode($json);

  }

  /**
   * Removing some BS string from the beginning of our response
   * @param  [type] $string [description]
   * @return [type]         [description]
   */
  public function _removeGarbage($string)
  {
    return str_replace("])}while(1);</x>","", $string);
  }

  /**
   * [_getFullArticle description]
   * @return [type] [description]
   */
  public function _getArticleJSON($username, $slug)
  {

    $url = "https://medium.com/" . $username . "/" . $slug . "?format=json";

    if($this->isTesting)
    {
      $body = '])}while(1);</x>{"success":true,"payload":{"value":{"id":"4b68d2c27eca","versionId":"32be5f6e8155","creatorId":"9c91192bec64","homeCollectionId":"","title":"How you run is how you do everything","detectedLanguage":"en","latestVersion":"32be5f6e8155","latestPublishedVersion":"32be5f6e8155","hasUnpublishedEdits":false,"latestRev":447,"createdAt":1444792284443,"updatedAt":1445529215725,"acceptedAt":0,"firstPublishedAt":1445525752347,"latestPublishedAt":1445529215725,"isRead":false,"vote":false,"experimentalCss":"","displayAuthor":"","content":{"subtitle":"A few thoughts I had, coincidentally enough, while running.","bodyModel":{"paragraphs":[{"name":"e45c","type":3,"text":"How you run is how you do everything","markups":[]},{"name":"53ee","type":1,"text":"A few thoughts I had, coincidentally enough, while running.","markups":[]},{"name":"5735","type":1,"text":"70% of the time I’m focused a few steps ahead. Conscious enough to dodge obstacles a strides length away; more importantly, working through larger — more grandiose — challenges, beyond the immediacy of the path.","markups":[]},{"name":"44d2","type":1,"text":"20% of the time my glance moves upward, surveying the environment and being appreciative of the beauty within the run. During this time, the infuriating nuances of the daily grind seem so small and petty. Cares fade away and a smile emerges, finding solitude surveying the world I’m passing.","markups":[]},{"name":"3cfe","type":1,"text":"10% of the time I’m looking backward, a quick check if the guy I passed is sneaking back up. At times brining my pace to a halt, deciding on a new course in search of something better.","markups":[]},{"name":"d5ad","type":1,"text":"Unlike some, I find pleasure running in the heat. Humid and upper 90s is preferred. It’s challenging, both physically and mentally, giving me the impression of building strength on both fronts.","markups":[]},{"name":"b1be","type":1,"text":"I occasionally question the reason I run, feeling slighted because it’s never for a race or attainable goal. For me, it’s part exercise and part meditation, meaningless outside of self-interest. It makes me wonder if the effort is exerted in vain, potentially having another outlet it could be used more purposefully.","markups":[]},{"name":"d1f9","type":1,"text":"Then it ends. Usually in a sprint to empty the tanks, quickly unlacing my shoes and hoping into the shower. Back to reality.","markups":[]}],"sections":[{"name":"38fa","startIndex":0}]},"postDisplay":{"coverless":true}},"virtuals":{"createdAtRelative":"a month ago","updatedAtRelative":"20 days ago","acceptedAtRelative":"","createdAtEnglish":"October 13, 2015","updatedAtEnglish":"October 22, 2015","acceptedAtEnglish":"","firstPublishedAtEnglish":"October 22, 2015","latestPublishedAtEnglish":"October 22, 2015","allowNotes":true,"snippet":"A few thoughts I had, coincidentally enough, while running.","previewImage":{"imageId":"","filter":"","backgroundSize":"","originalWidth":0,"originalHeight":0,"strategy":"resample","height":0,"width":0},"wordCount":244,"imageCount":0,"readingTime":0.9207547169811321,"subtitle":"A few thoughts I had, coincidentally enough, while running.","userPostRelation":{"userId":"9c91192bec64","postId":"4b68d2c27eca","readAt":1445791974703,"readLaterAddedAt":0,"votedAt":0,"collaboratorAddedAt":0,"notesAddedAt":0,"subscribedAt":0,"lastReadSectionName":"38fa","lastReadVersionId":"32be5f6e8155","lastReadAt":1445529310679,"lastReadParagraphName":"5735","lastReadPercentage":0.07,"viewedAt":1445791974620},"usersBySocialRecommends":[],"latestPublishedAtAbbreviated":"Oct 22","firstPublishedAtAbbreviated":"Oct 22","emailSnippet":"70% of the time I’m focused a few steps ahead. Conscious enough to dodge obstacles a strides length away; more importantly, working through larger — more grandiose — challenges, beyond the immediacy of the path. ¶\n\n20% of the time my glance moves upward, surveying the environment and being appreciative of the beauty within the run. During this time, the infuriating nuances of the daily grind seem so small and petty.","recommends":0,"isBookmarked":false,"tags":[{"slug":"running","name":"Running","postCount":1244,"virtuals":{"isFollowing":false,"newTopStoriesCount":0},"metadata":{"followerCount":404,"postCount":1244,"coverImage":{"id":"1*XgSiEKDNLw8t1OvtviY6xw.jpeg","originalWidth":1754,"originalHeight":1754}},"type":"Tag"},{"slug":"meditation","name":"Meditation","postCount":734,"virtuals":{"isFollowing":false,"newTopStoriesCount":0},"metadata":{"followerCount":216,"postCount":734,"coverImage":{"id":"1*EZl-yMKkU89uKo9wej9P7Q.jpeg","originalWidth":4896,"originalHeight":6528,"backgroundSize":"","filter":"","isFeatured":false,"externalSrc":""}},"type":"Tag"},{"slug":"life","name":"Life","postCount":16240,"virtuals":{"isFollowing":false,"newTopStoriesCount":0},"metadata":{"followerCount":68540,"postCount":16240,"coverImage":{"id":"1*1GCFaiYT8nLHQ6kmu284SA.png","originalWidth":1024,"originalHeight":512}},"type":"Tag"}],"socialRecommendsCount":0,"responsesCreatedCount":0},"coverless":true,"slug":"how-you-run-is-how-you-do-everything","translationSourcePostId":"","translationSourceCreatorId":"","isApprovedTranslation":false,"inResponseToPostId":"","inResponseToRemovedAt":0,"isTitleSynthesized":true,"allowResponses":true,"importedUrl":"","importedPublishedAt":0,"visibility":0,"isViewed":false,"uniqueSlug":"how-you-run-is-how-you-do-everything-4b68d2c27eca","previewContent":{"bodyModel":{"paragraphs":[{"name":"e45c","type":3,"text":"How you run is how you do everything","markups":[],"alignment":1},{"name":"53ee","type":1,"text":"A few thoughts I had, coincidentally enough, while running.","markups":[],"alignment":1},{"name":"5735","type":1,"text":"70% of the time I’m focused a few steps ahead. Conscious enough to dodge obstacles a strides length away; more importantly, working through larger — more grandiose — challenges…","markups":[],"alignment":1}],"sections":[{"startIndex":0}]},"isFullContent":false},"license":0,"inResponseToMediaResourceId":"","canonicalUrl":"https://medium.com/@bryantaxs/how-you-run-is-how-you-do-everything-4b68d2c27eca","approvedHomeCollectionId":"","newsletterId":"","isGeneratedSurrogate":false,"canonicalMediaResourceId":"","type":"Post"},"collaborators":[],"collectionUserRelations":[],"mode":"canEdit","references":{"User":{"9c91192bec64":{"userId":"9c91192bec64","name":"Bryant Hughes","username":"bryantaxs","createdAt":1366033582061,"lastPostCreatedAt":1444792284443,"imageId":"1*ZB608XuWmWIlXwM76JDIoA.png","backgroundImageId":"","bio":"Web developer, designer, and partner at @authenticff","twitterScreenName":"BryantAXS","socialStats":{"userId":"9c91192bec64","usersFollowedCount":61,"usersFollowedByCount":134,"type":"SocialStats"},"social":{"userId":"9c91192bec64","targetUserId":"9c91192bec64","type":"Social"},"facebookAccountId":"","type":"User"}},"Social":{"9c91192bec64":{"userId":"9c91192bec64","targetUserId":"9c91192bec64","type":"Social"}},"SocialStats":{"9c91192bec64":{"userId":"9c91192bec64","usersFollowedCount":61,"usersFollowedByCount":134,"type":"SocialStats"}}}},"v":3,"b":"18451-d8809de"}';
    }

    else
    {
      // Create a client with a base URI
      $client = new $this->client(['base_url' => 'https://medium.com']);
      $body = $client->get($url)->getBody();
    }

    $json = $this->_removeGarbage($body);

    return json_decode($json);

  }





}