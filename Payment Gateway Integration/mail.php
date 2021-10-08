<?php
  $transactionID = $_POST["transactionID"];
  $donorName = $_POST["donorName"];
  $donorMail = $_POST["donorMail"];
  $donationAmount = $_POST["donationAmount"];

  $mailBody = "Thanks " . $donorName . ", for your donation of $" . $donationAmount . " for reforming a better world. Your transaction ID for future reference is " . $transactionID . ".";
  $subject = "Donation received through PayPal";

  if(mail($donorMail, $subject, $mailBody, "From: donations4betterment@gmail.com")) {
      echo 200;
  } else {
      echo 500;
  }
?>