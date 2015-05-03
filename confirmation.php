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
    <?php
      session_start();
    ?>
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
            <h1 class="cover-heading">Welcome to E-Feel</h1>

            <h3><a href="/index2.php">Add More?</a></h3>
            <div class="row">
      <form action="/success.php" method="post">
        <div class="col-xs-8 col-sm-6">
  	       <h1 class="cover-heading">Familiar Faces? Check any of these similar images...</h1>
          
          

          <?php foreach($_SESSION['arr_found'] as $str_subject_id): 
              if(!is_null($str_subject_id)):
          ?>
                <input type="checkbox" name="chk_files[]" value="<?php echo $str_subject_id; ?>" /> <img src="/uploaded_images/<?php echo $str_subject_id; ?>.jpg" class="img-thumbnail">
        <?php 
              endif;
        endforeach; ?>
        </div>
        <div class="col-xs-4 col-sm-6">
    	     <h1 class="cover-heading">Pics for Video</h1>
              <?php foreach($_SESSION['arr_enrolled'] as $str_subject_id): 
                  if(!is_null($str_subject_id)):
              ?>
                    <input type="checkbox" name="chk_files[]" value="<?php echo $str_subject_id; ?>" /> <img src="/uploaded_images/<?php echo $str_subject_id; ?>.jpg" class="img-thumbnail">
            <?php 
                  endif;
            endforeach; ?>
        </div>

        <h3>Audio file: <?php echo $_SESSION['str_mp3_file']; ?></h3>
        <input type="hidden" value="<?php echo $_SESSION['str_mp3_file']; ?>" />
        <p class="lead">
          <input type="Submit" class="btn btn-lg btn-default" value="Create Video!" />
        </p>

      </form>



    </div>
  </div>
</div>
            
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
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
    <script src="/bootstrap-3.3.4/bootstrap-3.3.4/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
