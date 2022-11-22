<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// datebase
include('db_con.php');


// variables Declaration  -- not functioning
$errors   = array();



// Tream value for every data
function web($val)
{
	global $web_con;
	return mysqli_real_escape_string($web_con, trim($val));
}

// Error Thrower -- not functioning
function display_error()
{
	global $errors;

	if (count($errors) > 0) {
		echo '<div class="error">';
		foreach ($errors as $error) {
			echo $error . '';
		}
		echo '</div>';
	}
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	unset($_SESSION['sem']);
	unset($_SESSION['view_sem']);
	unset($_SESSION['faculty_sem']);
	unset($_SESSION['check']);
	header("location: ../login.php");
}

// Check if user is logged in
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	} else {
		return false;
	}
}
