<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="">
    <link rel="stylesheet" href="/css/app.css">
    <title>donau</title>
  </head>
  <body id="home" data-spy="scroll" data-target="#main-nav">
    <noscript>
      <strong>We're sorry but donau doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>

    <div id="app">
        <router-view></router-view>
    </div>
    <!-- built files will be auto injected -->

    <script src="/js/app.js"></script>

  </body>

  <script>

    $('ul.navbar-nav li.dropdown').hover(function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(200).slideDown(300);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(200).slideUp(300);
    });

  </script>
</html>