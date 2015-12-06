<?php

namespace App\Lib\Services;

class MediumArticleParserService{

  public function __construct()
  {

  }

  public function parse($paragraphs)
  {

    $updatedParagraphs = [];

    foreach($paragraphs as $paragraph)
    {
      $updatedParagraph = $this->parseParagraph($paragraph);
      $updatedParagraphs[] = $updatedParagraph;
    }

    return $updatedParagraphs;

  }

  public function parseParagraph($paragraph)
  {

    if(! empty($paragraph->text))
    {
      return $paragraph->text;
    }

    else
    {
      return "";
    }

  }


}