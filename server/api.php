<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cmd'])) {
  $cmd = $_POST['cmd'];
  $cmd();
}

function add() {
  require_once('db.php');
  $newUrl = $_POST['url'];
  $sql = "INSERT INTO urls (url) VALUES ('$newUrl')";
  $conn->query($sql);
}

function delete() {
  require_once('db.php');
  $id = $_POST['id'];
  $sql = "DELETE FROM urls WHERE id = $id";
  $conn->query($sql);
}

function checkWebsiteStatus() {
  require_once('db.php');

  $sql = "SELECT * FROM urls";
  $result = $conn->query($sql);
  $urls = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $urls[$row['id']] = $row;
    }
  }

  // Create multi-cURL handle
  $multiCurl = curl_multi_init();

  // Create an array to store individual cURL handles
  $curlHandles = array();

  // Create an array to store the cURL responses
  $responses = array();

  foreach ($urls as $urlId => $url) {
    $curl = curl_init($url['url']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Add the cURL handle to the multi-cURL handle
    curl_multi_add_handle($multiCurl, $curl);

    // Store the cURL handle and ID in the array
    $curlHandles[] = array(
      'handle' => $curl,
      'id' => $urlId
    );
  }

  // Execute the multi-cURL requests
  $running = null;
  do {
    curl_multi_exec($multiCurl, $running);
  } while ($running > 0);

  // Get the responses and close the cURL handles
  foreach ($curlHandles as $curlData) {
    $curl = $curlData['handle'];
    $response = curl_multi_getcontent($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_multi_remove_handle($multiCurl, $curl);
    curl_close($curl);

    $urlId = $curlData['id'];
    $url = $urls[$urlId]['url'];
    $responses[] = array(
      'url' => $url,
      'status' => $status,
      'id' => $urlId
    );
  }

  // Close the multi-cURL handle
  curl_multi_close($multiCurl);

  // Generate the HTML table
  $html = '';
  foreach ($responses as $response) {
    $html .= '<tr>';
    $html .= "<td>{$response['url']}</td>";
    $html .= "<td>".($response['status'] == 200 ? '<span class="badge bg-success">UP</span>' : '<span class="badge bg-secondary">Down</span>')."</td>";
    $html .= "<td><button class='btn btn-danger' id='{$response['id']}'>Delete</button></td>";
    $html .= '</tr>';
  }

  echo $html;
}


?>