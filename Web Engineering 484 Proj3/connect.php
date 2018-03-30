        <?php
            $user = "root";
            $pw = "";
            $table = "tsarbucks";

            $conn = new mysqli("localhost", $user, $pw, $table, 3306); // connection using TCP on port 3306

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

