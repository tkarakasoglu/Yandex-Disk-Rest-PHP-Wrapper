<?php require "service/service.php";

$service = new Service;

///////////
// LOGIN //
///////////
session_start();
if (!isset($_SESSION["token"])) {
  if (isset($_REQUEST["code"])) {
    // LOGGED IN AT THE MOMENT
    $_SESSION['code'] = $_REQUEST["code"];
    $_SESSION["token"] = $service->getToken();
  } else {
    // IF NOT LOGGED IN
    echo '<a href="' . $service->authorize() . '">Login with Yandex</a>';
    return;
  }
} else {
  // ALREADY LOGGED IN
}

echo $service->getDiskInformation();
//echo $service->getMetaInformation("");




?>
