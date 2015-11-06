<?php require "service/service.php";

$applicationId = "";

$service = new Service;

///////////
// LOGIN //
///////////
session_start();
if (!isset($_SESSION["code"])) {
  if (isset($_REQUEST["code"])) {
    // LOGGED IN AT THE MOMENT
    $_SESSION['code'] = $_REQUEST["code"];
  } else {
    // IF NOT LOGGED IN
    echo '<a href="' . $service->authorize($applicationId) . '">Login with Yandex</a>';
  }
} else {
  // ALREADY LOGGED IN
}





?>
