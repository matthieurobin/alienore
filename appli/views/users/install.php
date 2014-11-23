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
  <link href="<?php echo \Config\Path::CSS; ?>main.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?php echo \Config\Path::IMG; ?>favicon.png" />
</head>
<body ng-app="alienore" ng-controller="installCtrl" id="login">
  <div id="modal-helper"></div>  
  <div class="table table-center">
    <div class="cell">
      <div class="center-block">
        <div>
          <img class="logo img-center" src="<?php echo \Config\Path::IMG; ?>logo.png"></img>
        </div>
        <br>
        <div>
          <form class="form-signin" role="form" ng-submit="submitInstall()" method="post">
            <h2 class="form-signin-heading">
              <?php echo \MVC\Language::T('CreateAnAccount') ?>
            </h2><br>
            <div class="form-group">
              <input ng-model="formDataInstall.username" type="text" class="form-control" placeholder="<?php echo \MVC\Language::T('Username') ?>" required autofocus>
            </div>
            <div class="form-group">
              <input ng-model="formDataInstall.email" type="email" class="form-control" placeholder="<?php echo \MVC\Language::T('Email Address') ?>" required>
            </div>
            <div class="form-group">
              <input ng-model="formDataInstall.password" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Password') ?>" required>
            </div>
            <div class="form-group">
            <input ng-model="formDataInstall.repeatPassword" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Repeat password') ?>" required>
            </div>
            <div class="form-group">
              <label><?php echo \MVC\Language::T('Choose your language') ?> </label>
              <select class="form-control" ng-model="formDataInstall.language">
                <option value="en"><?php echo MVC\Language::T('English') ?></option>
                <option value="fr" selected><?php echo MVC\Language::T('French') ?></option>
              </select>
            </div>
            <button class="btn btn-lg btn-warning btn-block" type="submit"><?php echo \MVC\Language::T('Submit') ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo \Config\Path::JS; ?>jquery.js"></script>
<script src="<?php echo \Config\Path::JS; ?>perso.js"></script>
<script src="<?php echo \Config\Path::JS; ?>angular.min.js"></script>
<script src="<?php echo \Config\Path::JS; ?>app.angular.min.js"></script>
</body>
</html>