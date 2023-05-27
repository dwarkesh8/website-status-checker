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
      $urls[] = $row;
    }
  }
  $html = '';
  foreach ($urls as $url) {
    $ch = curl_init($url['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $html .= '<tr>';
    $html .= "<td>{$url['url']}</td>";
    $html .= "<td class='" . ($status == 200 ? 'up' : 'down') . "'>$status</td>";
    $html .= "<td><button class='btn btn-danger' id='{$url['id']}'>Delete</button></td>";
    $html .= '</tr>';
  }
  echo $html;
}
?>