
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><html class="no-js" lang="en"> <![endif]-->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0" />

  <title>Bryant Hughes | Web Developer, Designer, Partner at Authentic F&f | Chicago Minneapolis Denver</title>

  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0" />
  <meta name="description" content="The personal musings of Bryant Hughes: Web Developer, Designer, and Partnern at Authentic F&F" />
  <meta name="keywords" content="Web Design Development Technology Authentic From & Function Writing Chicago Denver Minneapolis Strategy Remote Business Entrepreneur" />
  <meta name="robots" content="index,follow,archive">

  <!-- Analytics -->
  @if(app("env") === "production")
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-2687424-3', { 'cookieDomain': 'none' });
    ga('require', 'linkid');
    ga('send', 'pageview');
  </script>
  @endif

  <!-- default page -->
  <meta property="og:description" content="The personal musings of Bryant Hughes: Web Developer, Designer, and Partnern at Authentic F&F"/>
  <meta property="og:image" content="http://bryanthughes.com/assets/images/icon.png">
  <meta property="og:title" content="Bryant Hughes">
  <meta property="og:url" content="http://bryanthughes.com">
  <meta property="og:site_name" content="BryantHughes.com">
  <meta property="og:type" content="website">

</head>

<body>


  <h1>
    {{ $article->name }}
  </h1>

  @foreach($paragraphs as $paragraph)

    <p>
      {{ $paragraph }}
    </p>

  @endforeach


</body>
</html>
