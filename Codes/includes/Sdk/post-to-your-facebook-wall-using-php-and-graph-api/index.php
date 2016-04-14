<?php
/*
 * @author Puneet Mehta
 * @website: http://www.PHPHive.info
 * @facebook: https://www.facebook.com/pages/PHPHive/1548210492057258
 */
require_once './config.php';
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != "") {
  // user already logged in the site
  header("location:".SITE_URL . "home.php");
}
include './header.php';
?>
<div class="container">
  <div class="margin10"></div>
  <div class="col-sm-3 col-sm-offset-4">
    <a class="btn btn-block btn-social btn-facebook" href="<?php echo $loginURL; ?>">
      <i class="fa fa-facebook"></i>           Login with Facebook
    </a>
  </div>
</div>
<?php
include './footer.php';
?>