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
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"
            integrity = "sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin = "anonymous"></script>
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
        <p class = "text-decoration-underline fs-5 mx-5 mt-5 pt-5">Transact Funds</p>
        <div id = "alert"></div>
        <form class = "w-75 mx-5 mt-5" id = "lend-fund" onsubmit = "doTransfer(event);">
            <label class = "form-label mb-2 fs-5">Debtor</label>
            <select class = "form-select mb-4" onchange = "getDebtor(this.value);" required>
                <option value = "">Select from whoose account you want to send money!</option>
                <?php
                  $servername = "localhost";
                  $username = "root";
                  $password = "";
                  
                  $conn = mysqli_connect($servername, $username, $password, "basic_banking_system");
                  
                  if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                  } 
                  
                  $sql = "SELECT fname, lname, balance FROM users";
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_assoc($result)) {
                          echo "<option value = '" . $row["fname"] . "'>" . $row["fname"] . " " . $row["lname"] . " (Remaining balance is " . $row["balance"] . ")" . "</option>";
                      }
                  }

                  mysqli_close($conn);  
                ?>
            </select>
            <label class = "form-label mb-2 fs-5">Creditor</label>
            <select class = "form-select mb-4" onchange = "getCreditor(this.value);" required>
                <option value = "">Select to whom you want to give money!</option>
                <?php
                  $servername = "localhost";
                  $username = "root";
                  $password = "";
                  
                  $conn = mysqli_connect($servername, $username, $password, "basic_banking_system");
                  
                  if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                  } 
                  
                  $sql = "SELECT fname, lname, balance FROM users";
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_assoc($result)) {
                          echo "<option value = '" . $row["fname"] . "'>" . $row["fname"] . " " . $row["lname"] . " (Remaining balance is " . $row["balance"] . ")" . "</option>";
                      }
                  }

                  mysqli_close($conn);  
                ?>
            </select>
            <div class = "form-floating mb-3">
                <input type = "number" class = "form-control" id = "floatingInput" required>
                <label for = "floatingInput">Fund Amount</label>
            </div>
            <button type = "submit" class = "btn btn-dark float-end">Transfer Credit</button>
        </form>
    </main>
    
    <script>
        let debtor = "";
        let creditor = "";
        let error = "";

        var reference = document.getElementById("alert");
        var form = document.getElementById("lend-fund");

        function getDebtor(value) {
            debtor = value;
        }
        
        function getCreditor(value) {
            creditor = value;
        }

        function doTransfer(event) {
            event.preventDefault();

            if(debtor == creditor) {
                error = "<span class = 'alert alert-danger mx-5 mt-5'>Select two separate accounts for a valid transaction!</span>";
                reference.innerHTML = error;
            } else if(form["floatingInput"].value < 100) {
                error = "<span class = 'alert alert-danger mx-5 mt-5'>Select at least an amount of a hundred for a valid transaction!</span>";
                reference.innerHTML = error;
            } else {
                $.ajax({
                    type: "POST",
                    url: "fund.php",
                    data: "debtor=" + debtor + "&creditor=" + creditor + "&amount=" + form["floatingInput"].value,
                    success: function(status) {
                        if(status == "200") {
                            error = "<span class = 'alert alert-success mx-5 mt-5'>Your transaction is done!</span>";
                            reference.innerHTML = error;

                            window.location.href = "/";
                        } else if(status == "500") {
                            error = "<span class = 'alert alert-danger mx-5 mt-5'>Insufficient balance in debtor's account for a valid transaction!</span>";
                            reference.innerHTML = error;
                        } else {
                            error = "<span class = 'alert alert-danger mx-5 mt-5'>Some error while processing your transaction!</span>";
                            reference.innerHTML = error;
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>