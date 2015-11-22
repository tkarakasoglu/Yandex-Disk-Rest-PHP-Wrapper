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

//echo $service->getDiskInformation();
//print_r(json_decode($service->getMetaInformation("EBOOKS"), true)["_embedded"]["items"]);
$metaInformation = json_decode($service->getMetaInformation("EBOOKS"), true);
$public_key = $metaInformation["public_key"];
$items = $metaInformation["_embedded"]["items"];
foreach ($items as $item) {
  //$downloadUrl = json_decode($service->downloadFileOrFolder($public_key, $item["path"]), true)["href"];
  //$imageUrl = $item["preview"];
  echo "<a href='" . $downloadUrl .  "' target='_blank'>" . $item["name"] . "</a><br>";
}




?>
