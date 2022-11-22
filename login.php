<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("functions/process.php");
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

    .p-viewer {
      z-index: 9999;
      position: absolute;
      top: 30%;
      right: 50px;
      margin-top: -4px;
    }

    .fa-eye {
      color: #000;
      cursor: pointer;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>Web</b>site</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg"><b id="message" style="color:#FA462D;"></b><b id="clear">Sign in to start your session</b></p>

        <!--form method="POST"-->
        <div class="input-group mb-3">
          <input id="username" name="username" type="text" class="form-control" placeholder="Email or Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input id="password" name="password" type="password" class="form-control" placeholder="Password">
          <span class="p-viewer" onclick="changeIcon(this)">
            <i id="togglePassword" class="fa fa-eye-slash" aria-hidden="true"></i>
          </span>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="">
          <div class="col-12">
            <button type="submit" id="login" name="login" class="login btn btn-primary btn-block">
              <span class="button__text"><i id="loading" class="fa fa-street-view" aria-hidden="true"></i> Sign In</span>
            </button>
          </div>
          <div class="col-12">
            <div class="icheck-primary">
              <p class="mb-1">
                <a title="Faculty only" href="/request">View your Schedules?</a><br>
                <a title="Faculty only" href="/password">Forgot/Change password?</a>
              </p>
            </div>
          </div>
        </div>
        <!--/form-->
        <!--div class="social-auth-links text-center mt-2 mb-3">
          <a href="../request" class="btn btn-block btn-primary">
          <i class="fa fa-user-plus" aria-hidden="true"></i> Request Account
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div-->

        <!--p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p>
        <p class="mb-0">
          <a href="register.html" class="text-center">Register a new membership</a>
        </p-->
      </div>
    </div>
  </div>
  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../dist/js/website.min.js"></script>
  <script>
    $(document).on("click", ".login", function() {
      document.getElementById("login").classList.add("button--loading");
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;
      $.ajax({
        type: "POST", //type of method
        url: "../functions/process.php", //your page
        data: {
          username: username,
          password: password
        }, // passing the values
        success: function(res) {
          if (res == 1) {
            setTimeout(function() {
              window.location.href = '../';
            }, 1000);
          } else if (res == 2) {
            //document.getElementById("selected_sem").style.borderColor = "red";
            setTimeout(function() {
              document.getElementById("clear").innerHTML = "";
              document.getElementById("message").innerHTML = "Invalid username or password!";
              document.getElementById("login").classList.remove("button--loading");
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
    $("#username").keypress(function(event) {
      if (event.keyCode === 13) {
        $("#login").click();
      }
    });
    $("#password").keypress(function(event) {
      if (event.keyCode === 13) {
        $("#login").click();
      }
    });
  </script>
  <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function() {
      // toggle the type attribute
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);

      // toggle the icon
      $(this).toggleClass('fa-eye');
      $(this).toggleClass('fa-eye-slash');
    });

    // prevent form submit
    /*const form = document.querySelector("form");
    form.addEventListener('submit', function(e) {
      e.preventDefault();
    });*/
  </script>
</body>

</html>