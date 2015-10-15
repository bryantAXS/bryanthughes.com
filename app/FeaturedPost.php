<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedPost extends Model
{

    public function parse()
    {

      foreach($this->paragraphs as $index => $paragraph)
      {

        if(isset($paragraph->name) && $paragraph->name == "title")
        {
          $this->title = $paragraph->text;
        }

        if(isset($paragraph->name) && $paragraph->name == "subtitle")
        {
          $this->subtitle = $paragraph->text;
        }

        if($index == 3)
        {
          $this->intro = $paragraph->text;
        }

        if($index == 4)
        {
          $this->intro2 = $paragraph->text;
        }

      }

    }

}
