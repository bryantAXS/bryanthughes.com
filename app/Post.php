<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $fillable = ["title", "intro", "intro2", "url", "published_at"];
}
