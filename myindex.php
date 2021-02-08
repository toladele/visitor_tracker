<!DOCTYPE html>

<head>
  <title>Visitor Tracker</title>
</head>

<body>

  <h2>Welcome to my visitor tracker</h2>

  <?php

    function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
  $ip = getIP();

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "cp476";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

  $sql_freq = "SELECT ipaddr, visits FROM visitors where ipaddr='$ip'";
  $result_freq = $conn->query($sql_freq);

  # if the user already exists in the table, increment the visits
  if ($result_freq->num_rows > 0) {
    $row = $result_freq->fetch_assoc();
    $visits = $row['visits'];
    $visits = $visits + 1;
    $sql = "UPDATE visitors SET visits = '$visits' WHERE ipaddr='$ip'";
    if ($conn->query($sql) === TRUE) {
        //echo "Insert successfully\n";
        $sql = "SELECT ipaddr FROM visitors where ipaddr='$ip'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          echo "Hi " . $row['ipaddr'] . ", thank you for coming back\n";
        } else {
          echo "0 results";
        }
      } else {
        echo "\nError: " . $conn->error;
      }
  } else {
      # if user does not already exist in the table, add the user
    $visits = 1;
    $sql = "INSERT INTO visitors VALUES ('', '$ip', '$visits')";
    if ($conn->query($sql) === TRUE) {
      //echo "Insert successfully\n";
      $sql = "SELECT ipaddr FROM visitors where ipaddr='$ip'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Hi " . $row['ipaddr'] . ", thank you for visiting my visitor tracker for the first time\n";
      } else {
        echo "0 results";
      }
    } else {
      echo "\nError: " . $conn->error;
    }
  }

  $conn->close();

  ?>
<form action="tracker.php" method="POST">
    <input type="submit" name="submit" value="View All Visitors">
</form>
</body>

</html>