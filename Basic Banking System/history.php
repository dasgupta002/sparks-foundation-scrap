<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
    <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
    <title></title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" 
          rel = "stylesheet" 
          integrity = "sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" 
          crossorigin = "anonymous" />
    <link rel = "stylesheet" 
          href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" 
          integrity = "sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" 
          crossorigin = "anonymous" 
          referrerpolicy = "no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lakki+Reddy&display=swap');

        body {
            font-family: 'Lakki Reddy', cursive;
            background-color: #eee;
        }

        a {
            text-decoration: none;
            color: initial;
        }
        a:hover{
            color: initial;
        }
    </style>
</head>
<body>
    <nav class = "container-fluid bg-dark text-center fs-1 p-5">
        <span class = "text-white">Basic Banking System</span>
    </nav>
    <main class = "container">
        <div class = "container border-bottom border-dark mt-4">
            <span><a href = "index.html"><i class = "fas fa-arrow-left"></i></a></span>
        </div>
        <p class = "text-decoration-underline fs-5 mx-5 mt-5 pt-5">All Transfers In Books</p>
        <table class = "bg-white table table-striped w-75 mx-5 mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Debited From</th>
                    <th>Credited To</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  $servername = "localhost";
                  $username = "root";
                  $password = "";
                  
                  $conn = mysqli_connect($servername, $username, $password, "basic_banking_system");
                  
                  if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                  } 
                  
                  $sql = "SELECT ID, debtor, creditor, amount FROM history";
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_assoc($result)) {
                          $debtor = explode(" ", $row["debtor"])[0];
                          $creditor = explode(" ", $row["creditor"])[0];

                          $sender = getBalance($conn, $debtor, $creditor)[0];
                          $receiver = getBalance($conn, $debtor, $creditor)[1];

                          echo "<tr>";
                          echo "<td>" . $row["ID"] . "</td>";
                          echo "<td>" . $row["debtor"] . " (Remaining balance is " . $sender . ")" . "</td>";
                          echo "<td>" . $row["creditor"] . " (Remaining balance is " . $receiver . ")" . "</td>";
                          echo "<td>" . $row["amount"] . "</td>";
                          echo "</tr>";
                      }
                  }

                  function getBalance($conn, $debtor, $creditor) {
                      $changes = array();
                      $sql = "SELECT balance FROM users WHERE fname = '$debtor'";
                      $result = mysqli_query($conn, $sql);

                      if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                              array_push($changes, $row["balance"]);
                        }
                      }

                      $sql = "SELECT balance FROM users WHERE fname = '$creditor'";
                      $result = mysqli_query($conn, $sql);

                      if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                              array_push($changes, $row["balance"]);
                         }
                      }

                      return $changes;
                  }

                  mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>