<!DOCTYPE html>

<body>

  <h2>Site visitors:</h2>

  <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cp476";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $sql = "SELECT ipaddr, visits FROM visitors";
    $result = $conn->query($sql);

    # if the user already exists in the table, increment the visits
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $visits = $row['visits'];
            $addresses = $row['ipaddr'];
            echo "<b>IP Address:</b> " . $addresses . ", <b>Visits: </b>" . $visits . "<br>";
        }
    } else {
        echo "0 results";
    }

    $conn->close();

    ?>
    </body>

</html>
