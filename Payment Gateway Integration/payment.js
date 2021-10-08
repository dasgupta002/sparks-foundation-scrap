sdk.Buttons({
    createOrder: function(data, actions) {
        let error = "";
        var alert = document.getElementById("alert");

        if(document.getElementById("donation").value < 20) {
            error = "<span class = 'alert alert-danger mx-5 my-2'>Your donation should not be less than twenty dollars!</span>";
            alert.innerHTML = error; 
        } else if(document.getElementById("contact").value.length == 0) {
            error = "<span class = 'alert alert-danger mx-5 my-2'>Your mailing address could not be empty!</span>";
            alert.innerHTML = error;
        } else {
            return actions.order.create({
                purchase_units: [{
                  amount: {
                    value: document.getElementById('donation').value
                  }
                }]
            });
        }
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          let mail = document.getElementById("contact").value;
          let error = "";
          var alert = document.getElementById("alert");

          if(details.status == "COMPLETED") {
              $.ajax({
                  type: "POST",
                  url: "mail.php",
                  data: "transactionID=" + details.id + "&donorName=" + details.payer.name.given_name + "&donorMail=" + mail + "&donationAmount=" + details.purchase_units[0].amount.value,
                  success: function(status) {
                      if(status == 200) {
                          error = "<span class = 'alert alert-success mx-5 my-2'>Payment summary sent to your mail, thanks for your step for a brighter dream!</span>";
                          alert.innerHTML = error;

                          window.location.href = "/";
                      } else {
                          error = "<span class = 'alert alert-danger mx-5 my-2'>Payment summary mail could not be sent, try later!</span>";
                          alert.innerHTML = error;     
                          
                          window.location.href = "/";
                      }
                  }
              });
          } else {
              error = "<span class = 'alert alert-danger mx-5 my-2'>Your donation could not be processed, try later!</span>";
              alert.innerHTML = error; 
          }
        });
    }
}).render('#paypal');