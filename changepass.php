<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("functions/process.php");

$action = isset($_GET['link']) ? $_GET['link'] : '';
if ($action == '') {
  header("location: ../error");
} else {
  $check_link = mysqli_fetch_assoc($web_con->query("SELECT * FROM request_log WHERE request_link = '$action' AND request_expiration > NOW()"));
  if (!$check_link) {
    header("location: ../error");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CCS Faculty Loading System</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../dist/css/website.min.css">
  <link rel="stylesheet" href="../dist/css/doenotme.css">
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <style>
    .button {
      position: relative;
      padding: 8px 16px;
      background: #009579;
      border: none;
      outline: none;
      border-radius: 2px;
      cursor: pointer;
    }

    .button:active {
      background: #007a63;
    }

    /*.button__text {
      font: bold 20px "Quicksand", san-serif;
      color: #ffffff;
      transition: all 0.2s;
    }*/

    .button--loading .button__text {
      visibility: hidden;
      opacity: 0;
    }

    .button--loading::after {
      content: "";
      position: absolute;
      width: 16px;
      height: 16px;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      margin: auto;
      border: 4px solid transparent;
      border-top-color: #ffffff;
      border-radius: 50%;
      animation: button-loading-spinner 1s ease infinite;
    }

    @keyframes button-loading-spinner {
      from {
        transform: rotate(0turn);
      }

      to {
        transform: rotate(1turn);
      }
    }
  </style>
</head>

<body class="hold-transition login-page">
  <!--div id="link_display" style="display:none;" class="alert success">
    <span class="closebtn">&times;</span>
    <strong>Click the link -</strong> <a id="link_here" href="www.google.com" target="_blank"><?php echo $_SERVER['HTTP_HOST'] ?><?php echo $_SERVER['REQUEST_URI'] ?>www.google.com</a>
  </div-->
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>Request</b> Link</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg"><b id="message" style="color:#FA462D;"></b><b id="success" style="color:green;"></b><b id="clear">Input New Password</b></p>

        <!--form method="POST"-->
        <div class="input-group mb-3">
          <input id="pass1" type="password" class="form-control" placeholder="New Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input id="pass2" type="password" class="form-control" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="social-auth-links text-center mt-2 mb-3">
          <button id="request_button" type="button" class="request button btn btn-block btn-primary">
            <span class="button__text"><i class="fas fa-check-circle" aria-hidden="true"></i> Change Password</span>
          </button>
        </div>
        <!--/form-->
      </div>
    </div>
  </div>
  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../dist/js/website.min.js"></script>
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
      close[i].onclick = function() {
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function() {
          div.style.display = "none";
        }, 600);
      }
    }
  </script>
  <script>
    $(document).on("click", ".request", function() {
      //alert("Hello! I am an alert box!!");
      document.getElementById("request_button").classList.add("button--loading");
      var pass1 = document.getElementById("pass1").value;
      var pass2 = document.getElementById("pass2").value;
      //if (result.isConfirmed) {
      $.ajax({
        type: "POST", //type of method
        url: "../functions/process.php", //your page
        data: {
          pass1: pass1,
          pass2: pass2,
          link: '<?php echo $action ?>'

        }, // passing the values
        success: function(res) {
          if (res == 1) {
            setTimeout(function() {
              document.getElementById("pass1").innerHTML = "";
              document.getElementById("pass2").innerHTML = "";
              document.getElementById("clear").innerHTML = "";
              document.getElementById("message").innerHTML = "";
              document.getElementById("pass1").style.borderColor = "";
              document.getElementById("pass2").style.borderColor = "";
              document.getElementById("request_button").classList.remove("button--loading");
              document.getElementById("success").innerHTML = "Password changed successfully!";
              setTimeout(function() {
                window.location.href = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>/login/';
              }, 3000);
            }, 1000);
          } else if (res == 2) {
            setTimeout(function() {
              document.getElementById("clear").innerHTML = "";
              document.getElementById("pass1").style.borderColor = "red";
              document.getElementById("pass2").style.borderColor = "red";
              document.getElementById("request_button").classList.remove("button--loading");
              document.getElementById("message").innerHTML = "New password and confirm password is required!";
            }, 1000);
          } else if (res == 3) {
            setTimeout(function() {
              document.getElementById("clear").innerHTML = "";
              document.getElementById("pass1").style.borderColor = "red";
              document.getElementById("pass2").style.borderColor = "red";
              document.getElementById("request_button").classList.remove("button--loading");
              document.getElementById("message").innerHTML = "New password and confirm password doesn't match";
            }, 1000);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error ' + res,
              text: 'Please contact the admin!'
            })
          }
        }
      });
    });
  </script>
  <script>
    $("#pass2").keypress(function(event) {
      if (event.keyCode === 13) {
        $("#request_button").click();
      }
    });
  </script>
</body>

</html>