<?php
  //delete all images not in POST vars
  $arr_images = array();
  foreach ($_POST['chk_files'] as $key => $value) {
      array_push($arr_images, "/home/e-feel/e-feel.club/uploaded_images/{$value}.jpg");
  }
  $arr_images = array_unique($arr_images);
  
  foreach (glob('/home/e-feel/e-feel.club/uploaded_images/*.jpg') as $str_file) {
      if(!in_array($str_file, $arr_images)) unlink($str_file);  
  }
  shell_exec('python /home/e-feel/create_video_collage.py');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>E-Feel</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap-3.3.4/bootstrap-3.3.4/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/cover.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/bootstrap-3.3.4/bootstrap-3.3.4/docs/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">E-Feel</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="#">Home</a></li>
                  <li><a href="#">Gallery</a></li>
				  <li><a href="http://e-feel.club/">Log-in</a></li>
                  <li><a href="#">Contact</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Thank You!</h1>
            <div class="row">
  
     
            <p class="lead">
              <a href="/uploaded_images/final.mpg" class="btn btn-lg btn-default">Watch Video!</a>
            </p>

            <div class="col-md-9 col-md-push-3">Dance Clubs</div>
              <div class="img_block">
                            <img src="/images/Club_Mansion.jpg" alt="" />
              <div class="col-md-3 col-md-pull-9">Rock Climbing</div>
            </div>



          </div>

          <div class="mastfoot">
            <div class="inner">
              
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/bootstrap-3.3.4/bootstrap-3.3.4/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="ie10-viewport-bug-workaround.js/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
