@extends('layout')

@section('content')

  <!--
    **
    PAGE CONTENET
    **
  -->

  <div content>

    <div blue-header>
      <img src="/assets/images/logo.svg" class="logo"/>
      <img src="/assets/images/mountains-header.png" class="bg" />
    </div>

   <div featured-article>

    <div class="bg">
      <img class="mountain" src="/assets/images/mountains-grey.png" />
    </div>


    <div class="row">
      <div class="columns small-12 medium-offset-1 medium-10 large-9 large-centered">

        <div class="content">

          <h2 id='the-latest' class="title">
            <span>THE</span>
            <span>LATEST</span>
          </h2>

          <h1>
            {{ $featuredArticle->name }}
          </h1>

          <!--
          <h3>
            A look at what it means to run a remote-business, and why it's so much more than being labeled a Digital Nomad.
          </h3>
          -->

          <p class="intro-big">
            <span class="big-letter">{{ $featuredArticle->paragraph_1_first_letter }}</span>
            {{ $featuredArticle->paragraph_1_display_text }}
          </p>

          <p class="intro-small mt20">
            {{ $featuredArticle->paragraph_2 }}
          </p>

          <a class="continue-reading" href="{{ $featuredArticle->medium_url }}" target="_blank">
            <span>CONTINUE READING</span>
          </a>

        </div><!-- content -->

      </div><!-- columns -->
    </div><!-- row -->

    <div class="past-thoughts-container">
      <div class="row">
        <div class="columns small-3 medium-offset-1 title-container">
          <h2 id="past-thoughts" class="title">
            <span>PAST</span>
            <span>THOUGHTS</span>
          </h2>
        </div><!-- columns -->
      </div><!-- row -->
    </div>

  </div><!-- featured-article -->



    <!--
      **
      ARTICLES
      **
    -->

    <div articles-container>

      <div class="articles-row row">

        <?php $count = 0; ?>

        @foreach ($articles as $article)

          <?php $count += 1; ?>
          <?php $textCount = $count < 10 ? "0".$count : $count; ?>

          <div small-article class="columns small-12 medium-6 large-3">
            <span class="digit">{{ $textCount }}</span>
            <h2>{{ $article->name }}</h2>
            <a class="read-this" href="{{ $article->medium_url }}" target="_blank">
              <span>Read this</span>
            </a>
          </div>

        @endforeach

      </div><!-- row -->

    </div><!-- bg-white -->


    <!--
      **
      BIO
      **
    -->


    <div bio-container>

      <div class="white-bg-container">

        <div class="more-container row">
          <div class="small-12">
            <a button="diamond" href="https://medium.com/@bryantaxs" target="_blank">
              <span class="more">More</span>
              <span class="plus">+</span>
            </a>
          </div>
        </div><!-- more-container -->

        <img class="birds" src="/assets/images/birds-slow.gif" />
        <img class="mountains" src="/assets/images/mountains-white.png" />

      </div><!-- white-bg-container -->

      <div class="row">
        <div class="columns small-3 medium-offset-2 title-container">
          <h2 class="title">
            <span>AN</span>
            <span>OUTRO</span>
          </h2>
        </div>
      </div>

      <div class="bio-content-row">

        <div class="row">
          <div class="columns medium-offset-4 medium-8 large-offset-5 large-5">
            <h4>
              WORD
            </h4>
          </div>
        </div>

        <div class="row">

          <div class="columns show-for-medium-up medium-4 large-offset-2 large-3 title-container">
            <p class="subtitle">
              THE PERSONAL MUSING OF BRYANT HUGHES: WEB DEVELOPER,
              DESIGNER &amp; PARTNER AT <a href="http://authenticff.com">AUTHENTIC F&F</a>
            </p>
          </div><!-- columns -->

          <div class="columns small-12 medium-8 large-5">


            <p>
              I'll cut to the chase.
            </p>

            <p>
              I love <a href="https://player.spotify.com/user/bryantaxs" target="_blank">hip hop</a> music, waking up early, slow productive weekends,
              exploring cities with my wife, and spending time on the couch with our dog.
              I subscribe to the cliché notion of loving what you do, and doing what you love.
            </p>

            <p>
              I'm a hard worker. Goal oriented and focused on building a <a href="http://authenticff.com/journal/beyond-remote" target="_blank">unique style of remote business.</a>
              I struggle with the tendency to be lazy, and always wish I was able to produce more, consume less, and ship more often.
            </p>

            <p>
              I'm inspired by progressive design and those who are at the forefront of creating it.
              How aesthetics and style change with technology and culture. The ways people take
              principles of the past, viewing them through a modern lens to create something unique.
            </p>

            <p>
              I'm surprisingly athletic; Often times rush more than I should; And am a terrible cook.
            </p>

            <p>
              This site really isn't a blog so much as it is an experiment.
            </p>

            <p>
              If you want to chat, I'd love to hear from you! I'm pretty
              good at responding quickly. You can tweet at me <a href="http://twitter.com/bryantaxs" target="_blank">here</a>.
            </p>

            <p>
              Good things,
            </p>

            <span class="signature">
              Bryant
              <img class="birds" src="/assets/images/signature-birds.png" />
            </span>

          </div><!-- columns -->

        </div><!-- row -->

      </div><!-- bio-content -->

    </div><!-- bio-container -->

@endsection