<?php
class Service {
  private $baseUrl = "https://cloud-api.yandex.net/v1/disk/";
  private $authorizationUrl = "https://oauth.yandex.com/authorize";
  private $tokenUrl = "https://oauth.yandex.ru/token";

  // USE YOUR OWN APP ID GENERATED FROM : https://oauth.yandex.com/client/new
  private $applicationId = "";
  private $applicationSecretId = "";

  // SOURCE: https://tech.yandex.com/oauth/doc/dg/reference/auto-code-client-docpage/
  function authorize() {
    return $this->authorizationUrl . "?response_type=code&" . "client_id=" . $this->applicationId;
  }

  // SOURCE: https://tech.yandex.com/oauth/doc/dg/reference/console-client-docpage/
  function getToken() {
    $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8;';
    $params = 'grant_type=authorization_code&code=' . $_SESSION['code'] . '&client_id=' . $this->applicationId . '&client_secret=' . $this->applicationSecretId;
    $ch = curl_init($this->tokenUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec ($ch);
    curl_close ($ch);
    return json_decode($response, true)["access_token"];
  }

  // SOURCE: https://tech.yandex.com/disk/api/reference/capacity-docpage/
  function getDiskInformation() {
    return $this->request($this->baseUrl, "");
  }

  // SOURCE: https://tech.yandex.com/disk/api/reference/meta-docpage/
  function getMetaInformation($path, $sort = null, $limit = null, $offset = null, $fields = null, $preview_size = null, $preview_crop = null) {
    $params = array("path" => $path,
                    "sort" => $sort,
                    "limit" => $limit,
                    "offset" => $offset,
                    "fields" => $fields,
                    "preview_size" => $preview_size,
                    "preview_crop" => $preview_crop);
    return $this->request($this->baseUrl, "resources", $params);
  }

  // SOURCE: https://tech.yandex.com/disk/api/reference/public-docpage/
  function downloadFileOrFolder($public_key, $path = null) {
    $params = array("public_key" => $public_key,
                    "path" => $path);
    return $this->request($this->baseUrl, "resources/download", $params);
  }

  function request($host, $path, $params = array()) {
    // Params are a map from names to values
    $paramStr = "?";
    foreach ($params as $key=>$val) {
      if ($val) {
        $paramStr .= $key . "=" . urlencode($val) . "&";
      }
    }
		$opts = array(
			'http' => array(
				'method' => 'GET',
				'header' => 'Authorization: OAuth ' . $_SESSION['token']
			)
		);
		$_default_opts = stream_context_get_params(stream_context_get_default());
		$opts = array_merge_recursive($_default_opts['options'], $opts);
		$context = stream_context_create($opts);
    $response = file_get_contents($host . $path . $paramStr, false, $context);
    return $response;
  }
}


?>
