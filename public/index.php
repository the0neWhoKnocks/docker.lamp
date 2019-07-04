<html>
  <head>
    <title>Docker LAMP example</title>
    <style>
      body {
        font-family: Helvetica, Arial, sans-serif;
      }
      table {
        border-collapse: collapse;
      }
      th, td {
        padding: 0.5em;
        border: solid 1px;
      }
      .msg {
        font-weight: bold;
        padding: 0.25em 0.5em;
        border: solid 3px;
        border-radius: 0.5em;
      }
      .error.msg {
        color: maroon;
        background: #ffc8c8;
      }
      .success.msg {
        color: green;
        background: #d0eab1;
      }
    </style>
  </head>
  <body>
    <?
      $host = getenv('DB_HOST');
      $user = getenv('DB_USERNAME');
      $pass = getenv('DB_PASSWORD');
      $dbName = getenv('DB_NAME');
      $devMode = getenv('DEV');

      if($devMode) mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      
      try {
        $db = new mysqli($host, $user, $pass, $dbName);
        $tableName = "Users";
        
        echo "<div class='success msg'>Connected to '$dbName' with credentials '$user:$pass'.</div>";
        
        try { $db->query("DESCRIBE `$tableName`"); }
        catch(Exception $e){
          $createTable = implode(" ", [
            "CREATE TABLE `$tableName` (",
              "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,",
              "firstname VARCHAR(30) NOT NULL,",
              "lastname VARCHAR(30) NOT NULL,",
              "email VARCHAR(50),",
              "reg_date TIMESTAMP",
            ")",
          ]);
          $addUser = implode(" ", [
            "INSERT INTO `$tableName`",
              "(firstname, lastname, email)",
            "VALUES",
              "('John', 'Doe', 'john@example.com'),",
              "('Jane', 'Doe', 'jane@example.com')",
          ]);
          
          if( $db->query("$createTable") ) echo "<br/>  Created '$tableName' table.";
          if( $db->query("$addUser") )  echo "<br/>  Added data to '$tableName'.";
        }
        
        $tableData = $db->query("SELECT * FROM `$tableName`");
        $db->close();
      }
      catch(Exception $connectError){
        $errMsg = implode("", [
          "<div class='error msg'>",
            "Couldn't Connect to '$dbName': " . $connectError->getMessage(),
            "<br /><br />Settings:<ul>",
              "<li>Host: '$host'</li>",
              "<li>User: '$user'</li>",
              "<li>Password: '$pass'</li>",
              "<li>DB Name: '$dbName'</li>",
            "</ul>",
          "</div>",
        ]);
        die("$errMsg");
      }
    ?>
    
    <h4><?= "Data for '$tableName'"?></h4>
    <table>
      <tr>
        <?
          foreach ( $tableData->fetch_array(MYSQLI_ASSOC) as $key => $rowItem ) {
            echo "<th>$key</th>";
          }
        ?>
      </tr>
      <?
        foreach ( $tableData as $row ) {
          $rowData = "";
          foreach ( $row as $rowItem ) {
            $rowData .= "<td>$rowItem</td>";
          }
          echo "<tr>$rowData</tr>";
        }
      ?>
    </table>
    <br />
    <div>
      Go to: <a href="http://localhost:8080/db_structure.php?server=1&db=<?= "$dbName"?>" target="_blank">phpMyAdmin</a>
    </div>
  </body>
</html>
