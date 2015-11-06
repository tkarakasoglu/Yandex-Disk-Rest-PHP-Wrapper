<?php
class Service {
  private $baseUrl = "https://cloud-api.yandex.net/v1/disk/";
  private $authorizationUrl = "https://oauth.yandex.com/authorize";

  function authorize($applicationId) {
    return $this->authorizationUrl . "?response_type=code&" . "client_id=" . $applicationId;
  }

  function getDiskInformation() {

  }
}


?>
