<!DOCTYPE html>
<html lang="en">

    <head>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="/Public/css/materialize.min.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Typography - Materialize</title>
  </head>
  <body>

  <nav>
    <div class="nav-wrapper white">
      <a href="#!" class="brand-logo teal-text">Logo</a>
      <a href="#" data-activates="mobile-demo" class="button-collapse teal-text"><i class="material-icons">menu</i></a>

      <ul class="right hide-on-med-and-down">
        <li><a class="teal-text" href="#sass.html">Sass</a></li>
        <li><a class="teal-text" href="#badges.html">Components</a></li>
        <li><a class="teal-text" href="#collapsible.html">Javascript</a></li>
        <li><a class="teal-text" href="#mobile.html">Mobile</a></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li><a class="teal-text" href="#sass.html">Sass</a></li>
        <li><a class="teal-text" href="#badges.html">Components</a></li>
        <li><a class="teal-text" href="#collapsible.html">Javascript</a></li>
        <li><a class="teal-text" href="#mobile.html">Mobile</a></li>
      </ul>
    </div>
  </nav>
    <main>
	<div class="container">
	    <div class="row">
		<div class="col s12">
        	    <h4 class="header">{{BEGIN DATA}} DNS:{{DNS}}{{END DATA}}</h4>
		    <h4 class="header">{{BEGIN DATA}} URL: {{URL}}{{END DATA}}</h4>
		    <h4>{{BEGIN DATA}}{{TITLE}}{{END DATA}}</h4>
		    <p class="flow-text">{{BEGIN CONTENT}}{{HTML}}{{END CONTENT}}</p>
		</div>
	    </div>
	</div> <!-- End Container -->
    </main>
    <br>
    <footer class="page-footer  white">
      <div class="footer-copyright white">
        <div class="container  blue-grey-text text-darken-4">
        © 2016-2018 The Rabbit Hole, All rights reserved.
        <a class="right" href="https://github.com/vorlon001/TheRabbitHole-v3/blob/master/LICENSE">Apache License 2.0</a>
        </div>
      </div>
    </footer>

     <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="/Public/js/materialize.min.js"></script>
      <script>
	$( document ).ready(function(){ $(".button-collapse").sideNav(); })
      </script>
  </body>
</html>
