<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

  public $fillable = [
    "name",
    "subtitle",
    "paragraph_1",
    "paragraph_2",
    "slug",
    "latest_published_version",
    "post_date",
    "medium_url",
    "article_id",
    "json"
  ];

}
