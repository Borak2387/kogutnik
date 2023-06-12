<?php
session_start();

is(isset($_SESSION['zalogowany']))
{
  require_once "connect.php";

  $conn = @new mysql1($host, $db_user, $db_password, $db_name);

  if ($conn->connect_errno) {
      die("Connection failed: " . $conn->connect_error);
  }

  $login = $_SESSION['user'];
  $sql = "SELECT user_id FROM user WHERE user_name = $login;"
  $result = @conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $user_id = $row["user_id"];
    }
  } else {
    echo "0 results";
  }

  $sql = "UPDATE guessnumber_rankings SET score = score + 2 WHERE user_id = $user_id;"
  $result = @conn->query($sql);

  header('Location: https://kogutnik.pl/zgadnijliczbe');

  $conn->close();
} else {
  echo "No SESSION, log-in again please";
  header('Location: https:://kogutnik.pl');
}

?>