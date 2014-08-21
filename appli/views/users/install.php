<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo Config\App::NAME; ?> - <?php echo \MVC\Language::T('CreateAnAccount'); ?></title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo \Config\Path::CSS; ?>bootstrap.min.css" rel="stylesheet">
  <!-- Application CSS -->
  <link href="<?php echo \Config\Path::CSS; ?>main.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?php echo \Config\Path::IMG; ?>favicon.png" />
</head>
<body ng-app="alienore" ng-controller="installCtrl">
  <div id="modal-helper"></div>
  <div id="header">
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="."><img class="logo" src="<?php echo \Config\Path::IMG; ?>logo.png"></img></a>
        </div>
      </div>
    </div>    

  </div>
  <div class="container">
    <form class="form-signin" role="form" ng-submit="submitInstall()" method="post">
      <h2 class="form-signin-heading">
        <?php echo \MVC\Language::T('CreateAnAccount') ?>
      </h2><br>
      <input name="username" ng-model="formDataInstall.username" type="text" class="form-control" placeholder="<?php echo \MVC\Language::T('Username') ?>" required autofocus><br>
      <input name="password" ng-model="formDataInstall.password" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Password') ?>" required><br>
      <input name="repeatPassword" ng-model="formDataInstall.repeatPassword" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Repeat password') ?>" required><br>

      <?php echo \MVC\Language::T('Language') ?> <select name="language" class="form-control" ng-model="formDataInstall.language">
      <option selected value="en"><?php echo MVC\Language::T('English') ?></option>
      <option  value="fr"><?php echo MVC\Language::T('French') ?></option>
    </select><br>
    <input name="email" ng-model="formDataInstall.email" type="email" class="form-control" placeholder="<?php echo \MVC\Language::T('Email Address') ?>" required><br>
    <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo \MVC\Language::T('Submit') ?></button>
  </form>

</div> <!-- /container -->

<div id="footer">
  <?php echo \MVC\Language::T('By') ?> <?php echo \Config\App::COPYRIGHT ?> - <?php echo \Config\App::VERSION ?>
</div>
<script src="<?php echo \Config\Path::JS; ?>jquery.js"></script>
<script src="<?php echo \Config\Path::JS; ?>perso.js"></script>
<script src="<?php echo \Config\Path::JS; ?>angular.min.js"></script>
<script src="<?php echo \Config\Path::JS; ?>app.angular.js"></script>
</body>
</html>