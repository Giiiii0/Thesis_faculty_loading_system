<?php
include('functions.php');

//=====================================PHPMailer library  START
require_once "PHPMailer.php";
require_once "Exception.php";
require_once "SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
//=====================================PHPMailer library END

//=====================================VARIABLES START
$converted_start_time = 'Empty';
$converted_end_time =  'Empty';
$data_week_days = 'Empty';
$splittercode = '10192019';
//=====================================VARIABLES END

//=====================================Mysqli Query START
function web_query($query)
{
    global $web_con;
    mysqli_query($web_con, $query);
}
//=====================================Mysqli Query END

//-------------------------------------------------------------------Login POST START---
if (isset($_POST["username"])) {
    login();
}
//-------------------------------------------------------------------Login POST END---



if (isset($_POST["edit"])) {
    get_live_data();
}


//-------------------------------------------------------------------Request POST START---
if (isset($_POST["faculty_request_id"])) {
    request();
}
//-------------------------------------------------------------------Request POST END---

//-------------------------------------------------------------------ChangePass POST START---
if (isset($_POST["email"])) {
    requestchangePass();
}
if (isset($_POST["pass1"])) {
    changePass();
}
//-------------------------------------------------------------------ChangePass POST END---

//-------------------------------------------------------------------Faculty POST START---
if (isset($_POST["fid"])) {
    update_faculty();
}
if (isset($_POST["fid_add"])) {
    add_faculty();
}
if (isset($_POST["restore_id"])) {
    restore_id();
}
if (isset($_POST["selected_faculty_sem"])) {
    selected_faculty_sem();
}
if (isset($_POST["data_id"])) {
    $data_id = web($_POST["data_id"]);
    if (mysqli_query($web_con, "UPDATE faculty SET status=1 WHERE Faculty_id='$data_id'")) {
        mysqli_query($web_con, "UPDATE class SET status=1 WHERE Faculty_id='$data_id'");
        unset($_SESSION['check']);
    }
}
//-------------------------------------------------------------------Faculty POST END---

//-------------------------------------------------------------------Subject POST START---
if (isset($_POST["cc_add"])) {
    add_subject();
}
if (isset($_POST["subject_id"])) {
    update_subject();
}
if (isset($_POST["subject_remove"])) {
    $data_id = web($_POST["subject_remove"]);
    mysqli_query($web_con, "DELETE FROM subject WHERE id = '$data_id'");
}
//-------------------------------------------------------------------Faculty POST END---

//-------------------------------------------------------------------Rooms POST START---
if (isset($_POST["room_no_add"])) {
    add_room();
}
if (isset($_POST["room_id"])) {
    room_update();
}
if (isset($_POST["room_remove"])) {
    $data_id = web($_POST["room_remove"]);
    mysqli_query($web_con, "DELETE FROM room WHERE id = '$data_id'");
}
//-------------------------------------------------------------------Rooms POST END---

//-------------------------------------------------------------------Semester POST START---
if (isset($_POST["sem_no_add"])) {
    add_sem();
}
if (isset($_POST["sem_id"])) {
    sem_update();
}
if (isset($_POST["sem_remove"])) {
    $data_id = web($_POST["sem_remove"]);
    mysqli_query($web_con, "DELETE FROM semester WHERE Sem_id = '$data_id'");
}
//-------------------------------------------------------------------Semester POST END---

//-------------------------------------------------------------------Class POST START---
if (isset($_POST["selected_sem"])) {
    selected_sem();
}
if (isset($_POST["class_id"])) {
    remove_class();
}
if (isset($_POST["dataTask"])) {
    update_studentCount();
}
//-------------------------------------------------------------------Class POST END---

//-------------------------------------------------------------------Class Load POST START---
if (isset($_POST["class_faculty"])) {
    load_class();
}
if (isset($_POST["load_sched"])) {
    load_sched();
}
//-------------------------------------------------------------------Class Load POST END---

//-------------------------------------------------------------------View POST START---
if (isset($_POST["semester"])) {
    semester();
}
//-------------------------------------------------------------------View POST END---


//===================================================================Sessions START==
if ($_SESSION['faculty_sem'] ?? null) {
    $faculty_selected_sem = $_SESSION['faculty_sem'];
} else {
    $faculty_selected_sem = 'none';
}

if ($_SESSION['sem'] ?? null) {
    $the_selected_sem = $_SESSION['sem'];
} else {
    $the_selected_sem = 'none';
}

if ($_SESSION['check'] ?? null) {
    $data_session = $_SESSION['check'];
} else {
    $data_session = 0;
}

if ($_SESSION['view_sem'] ?? null) {
    $view_sem = $_SESSION['view_sem'];
} else {
    $view_sem = 'none';
}
//===================================================================Sessions END==

//===================================================================Queries START==
$get_faculty = mysqli_query($web_con, "SELECT * FROM faculty WHERE status = 0");
$get_removed_faculty = mysqli_query($web_con, "SELECT * FROM faculty WHERE status = 1");
$get_subjects = mysqli_query($web_con, "SELECT * FROM subject");
$get_room = mysqli_query($web_con, "SELECT * FROM room");
$get_room_lab = mysqli_query($web_con, "SELECT * FROM room");
//$get_lab = mysqli_query($web_con, "SELECT * FROM lab");
$get_sem = mysqli_query($web_con, "SELECT * FROM semester ORDER BY School_year DESC");
$get_class = mysqli_query($web_con, "SELECT * FROM class WHERE Subject_id != 0 AND sem_id ='$the_selected_sem' AND status = 0 ORDER BY id DESC");

$all_data = mysqli_query($web_con, "SELECT * FROM check_log WHERE status = 'okay' AND session = '$data_session'");
//===================================================================Queries END==

//-------------------------------------------------------------------ChangePass Function Start--->
function requestchangePass()
{
    global $web_con;
    $email = $_POST["email"];

    $checkIfExistEmail = mysqli_fetch_assoc($web_con->query("SELECT * FROM user WHERE email = '$email'"));
    if ($email == '') {
        echo 2;
        return;
    } else if ($checkIfExistEmail) {
        $userID = $checkIfExistEmail['id'];
        $checkExpirationLink = mysqli_fetch_assoc($web_con->query("SELECT * FROM request_log WHERE request_expiration > NOW() AND request_id = '$userID'"));
        if ($checkExpirationLink) {
            $not_expire_link = $checkExpirationLink['request_link'];
            echo '1,' . $not_expire_link;
            $fullName = $checkIfExistEmail['name'] . ' ' . $checkIfExistEmail['name'] . '. ' . $checkIfExistEmail['name'];
            $link = 'http://' . $_SERVER['HTTP_HOST'] . '/changepass/?link=' . $not_expire_link;
            sendMail($email, $fullName, $link);
            return;
        }
        $session = request_session_generator();
        $ran_string = generateRandomString();
        $shuffled_data = str_shuffle($ran_string . '' . $session);
        if (mysqli_query($web_con, "INSERT INTO request_log (request_id,request_link,request_session,request_expiration,request_datetime) VALUE ('$userID','$shuffled_data','$session',date_add(Now(),interval 1 day),Now())")) {
            echo '1,' . $shuffled_data;
            $fullName = $checkIfExistEmail['name'] . ' ' . $checkIfExistEmail['name'] . '. ' . $checkIfExistEmail['name'];
            $link = 'http://' . $_SERVER['HTTP_HOST'] . '/changepass/?link=' . $shuffled_data;
            sendMail($email, $fullName, $link);
            return;
        } else {
            echo 101919;
            return;
        }
    } else {
        echo 3;
    }
    //echo $email;
}

function changePass()
{
    global $web_con;
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];
    $link = $_POST["link"];

    $getID = mysqli_fetch_assoc($web_con->query("SELECT * FROM request_log WHERE request_link = '$link' AND request_expiration > NOW()"));

    if (!$pass1 || !$pass2) {
        echo 2;
        return;
    }
    if ($pass1 != $pass2) {
        echo 3;
        return;
    }

    if ($getID) {
        $userID = $getID['request_id'];
        if (mysqli_query($web_con, ("UPDATE user SET password = '$pass2' WHERE id ='$userID'"))) {
            if (mysqli_query($web_con, ("UPDATE request_log SET request_expiration = NOW() WHERE request_link = '$link'"))) {
                echo 1;
            }
        }
    } else {
        echo 101919;
    }
}

function sendMail($email, $name, $link)
{
    $mail = new PHPMailer(true);
    //$mail->SMTPDebug = 3;      
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp-relay.sendinblue.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tinggas.imccccs@gmail.com';
    $mail->Password = 'sAcgIk9EKTCMmNpt';
    $mail->SMTPSecure = 'tsl';
    $mail->Port = 587;
    $mail->From = 'IMCC_School@gmail.com';
    $mail->FromName = 'CCS Faculty Loading System';
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    $mail->Subject = 'Forgot/Change password';
    $mail->Body = 'Click the link to proceed -> ' . $link;
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    /*try {
        $mail->send();
        echo "Message has been sent successfully";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }*/
}
//-------------------------------------------------------------------ChangePass Function END--->

//-------------------------------------------------------------------Request Function Start--->
function request()
{
    global $web_con;

    $request_id = $_POST["faculty_request_id"];
    $check_expiration = mysqli_fetch_assoc($web_con->query("SELECT * FROM request_log WHERE request_expiration > NOW() AND request_id = '$request_id'"));
    $check_if_exist = mysqli_fetch_assoc($web_con->query("SELECT * FROM faculty WHERE Faculty_id = '$request_id' AND status = 0"));

    if ($request_id == '') {
        echo 2;
        return;
    } else {
        if ($check_if_exist) {
            if ($check_expiration) {
                $not_expire_link = $check_expiration['request_link'];
                echo '1,' . $not_expire_link;
                return;
            } else {
                $session = request_session_generator();
                $ran_string = generateRandomString();
                $shuffled_data = str_shuffle($ran_string . '' . $session);
                if (mysqli_query($web_con, "INSERT INTO request_log (request_id,request_link,request_session,request_expiration,request_datetime) VALUE ('$request_id','$shuffled_data','$session',date_add(Now(),interval 1 day),Now())")) {
                    echo '1,' . $shuffled_data;
                    return;
                } else {
                    echo 101919;
                    return;
                }
            }
        } else {
            echo 3;
            return;
        }
    }
}
function request_session_generator()
{
    global $web_con;

    $date_now = date("Ymd"); //20221001
    $get_latest_session = mysqli_fetch_assoc($web_con->query("SELECT * FROM request_log WHERE request_session LIKE '$date_now%' ORDER BY id DESC LIMIT 1"));
    if ($get_latest_session) {
        $current_session = $get_latest_session['request_session'];
        return intval($current_session) + 1;
    } else {
        return $date_now . '101';
    }
}
function generateRandomString($length = 10)
{
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//how to multi query https://www.w3schools.com/php/func_mysqli_multi_query.asp
//how to advance in days https://stackoverflow.com/questions/277247/increase-days-to-php-current-date
//how to get cureent link location https://ui.dev/get-current-url-javascript
//-------------------------------------------------------------------Request Function END--->

//-------------------------------------------------------------------Faculty Function Start--->
function selected_faculty_sem()
{
    $selected_faculty_sem = $_POST["selected_faculty_sem"];

    if ($selected_faculty_sem == 'none') {
        echo 2;
        return;
    } else {
        $_SESSION['faculty_sem'] =  $selected_faculty_sem;
        echo 1;
        return;
    }
}
function add_faculty()
{
    global $web_con;

    $id = web($_POST["fid_add"]);
    $fname = web($_POST["fname_add"]);
    $mname = web($_POST["mname_add"]);
    $lname = web($_POST["lname_add"]);
    //$contact = web($_POST["contact_add"]);
    //$address = web($_POST["address_add"]);

    if (web($_POST["contact_add"]) == '') {
        $contact = 0;
    } else {
        $contact = web($_POST["contact_add"]);
    }

    if (web($_POST["address_add"]) == '') {
        $address = 'none';
    } else {
        $address = web($_POST["address_add"]);
    }

    $check_id = mysqli_fetch_assoc($web_con->query("SELECT * FROM faculty WHERE Faculty_id = '$id'"));
    if ($check_id) {
        echo 2;
        return;
    } else if (strlen($id) > 5) {
        echo 7;
        return;
    } else if (empty($id)) {
        echo 3;
        return;
    } else if (empty($fname)) {
        echo 4;
        return;
    } else if (empty($mname)) {
        echo 5;
        return;
    } else if (empty($lname)) {
        echo 6;
        return;
    } else {
        if (mysqli_query($web_con, "INSERT INTO faculty (Faculty_id,FirstName,LastName,MiddleInitial,PhoneNum,address,date_time) VALUE ('$id','$fname','$lname','$mname','$contact','$address',Now())")) {
            $get_sem_id = mysqli_fetch_assoc($web_con->query("SELECT * FROM semester ORDER BY Sem_id DESC LIMIT 1"));
            if ($get_sem_id) {
                $sem_id = $get_sem_id['Sem_id'];
            } else {
                $sem_id = 1;
            }
            //$check_if_exist = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Subject_id = 0 AND Faculty_id = '$id' AND sem_id = '$sem_id'"));
            $check_if_not = mysqli_query($web_con, "SELECT * FROM semester");
            while ($check_not_row = mysqli_fetch_assoc($check_if_not)) {
                $sem_ids = $check_not_row['Sem_id'];
                $check_if_notExist = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Subject_id = 0 AND Faculty_id = '$id' AND sem_id = '$sem_ids'"));
                if (!$check_if_notExist) {
                    mysqli_query($web_con, "INSERT INTO class (Subject_id,Faculty_id,Room_id,Lab_id,sem_id,Lec_start,Lec_end,Lab_start,Lab_end,Lab_day,Lec_day,date_time) VALUE ('0','$id','0','0','$sem_ids','0','0','0','0','0','0',Now())");
                }
            }
            echo 1;
            return;
            /*if (!$check_if_exist) {
                if (mysqli_query($web_con, "INSERT INTO class (Subject_id,Faculty_id,Room_id,Lab_id,sem_id,Lec_start,Lec_end,Lab_start,Lab_end,Lab_day,Lec_day,date_time) VALUE ('0','$id','0','0','$sem_id','0','0','0','0','0','0',Now())")) {
                    echo 1;
                    return;
                }
            }*/
        }
    }
}

function update_faculty()
{
    global $web_con;

    $id = web($_POST["fid"]);
    $fname = web($_POST["fname"]);
    $mname = web($_POST["mname"]);
    $lname = web($_POST["lname"]);
    $contact = web($_POST["contact"]);
    $address = web($_POST["address"]);

    $update = mysqli_query($web_con, "UPDATE faculty SET FirstName ='$fname',LastName ='$lname',MiddleInitial ='$mname',PhoneNum ='$contact',address ='$address' WHERE Faculty_id = '$id'");
    if (!$update) {
        echo 2;
        return;
    } else {
        echo 1;
        return;
    }
}
function restore_id()
{
    global $web_con;

    $restore_id = $_POST["restore_id"];

    if ($restore_id != '') {
        if (mysqli_query($web_con, "UPDATE faculty SET status = 0 WHERE Faculty_id = '$restore_id'")) {
            if (mysqli_query($web_con, "UPDATE class SET status = 0 WHERE Faculty_id = '$restore_id'")) {
                echo 1;
                return;
            } else {
                echo 101919;
                return;
            }
        }
    } else {
        echo 101919;
        return;
    }
}
//-------------------------------------------------------------------Faculty Function END--->

//-------------------------------------------------------------------Subject Function START--->
function add_subject()
{
    global $web_con;

    $course_code = web($_POST["cc_add"]);
    $offer_no_add = web($_POST["offer_no_add"]);
    $description = web($_POST["desc_add"]);
    $units = web($_POST["units_add"]);

    //$check_course_code = mysqli_fetch_assoc($web_con->query("SELECT * FROM subject WHERE Course_code = '$course_code'"));
    $check_offer_no = mysqli_fetch_assoc($web_con->query("SELECT * FROM subject WHERE offer_no = '$offer_no_add'"));

    /*if ($check_course_code) {
        echo 2;
        return;
    } else*/
    if ($check_offer_no) {
        echo 3;
        return;
    } else if ($course_code == '') {
        echo 4;
        return;
    } else if ($offer_no_add == '') {
        echo 5;
        return;
    } else if ($description == '') {
        echo 6;
        return;
    } else if ($units == '') {
        echo 7;
        return;
    } else {
        if (mysqli_query($web_con, "INSERT INTO subject (Course_code,offer_no,Description,units,date_time) VALUE ('$course_code','$offer_no_add','$description','$units',Now())")) {
            echo 1;
            return;
        }
    }
}
function update_subject()
{
    global $web_con;

    $subject_id = web($_POST["subject_id"]);
    $course_code = web($_POST["cc"]);
    $offer_no = web($_POST["offer_no"]);
    $description = web($_POST["desc"]);
    $units = web($_POST["units"]);

    $get_on_id1 = mysqli_fetch_assoc($web_con->query("SELECT * FROM subject WHERE offer_no = '$offer_no'"));
    if ($get_on_id1) {
        $offer_no_id1 = $get_on_id1['id'];
    } else {
        $offer_no_id1 = $subject_id;
    }

    if ($subject_id != $offer_no_id1) {
        //echo 'DB:'.$offer_no_id1.' Input:'.$subject_id;
        echo 5;
        return;
    } else if ($course_code == '') {
        echo 2;
        return;
    } else if ($description == '') {
        echo 3;
        return;
    } else if ($units == '') {
        echo 4;
        return;
    } else {
        if (mysqli_query($web_con, "UPDATE subject SET Course_code = '$course_code', offer_no='$offer_no', Description = '$description', units = '$units' WHERE id = '$subject_id'")) {
            echo 1;
            return;
        }
    }
}
//-------------------------------------------------------------------Subject Function END--->

//-------------------------------------------------------------------Rooms Function START--->
function add_room()
{
    global $web_con;

    $room_no_add = web($_POST["room_no_add"]);
    $building_add = web($_POST["building_add"]);

    $check_room_no = mysqli_fetch_assoc($web_con->query("SELECT * FROM room WHERE Room_no = '$room_no_add'"));

    if ($room_no_add == '') {
        echo 3;
        return;
    } else if ($building_add == '') {
        echo 4;
        return;
    } else if ($check_room_no) {
        echo 2;
        return;
    } else {
        if (mysqli_query($web_con, "INSERT INTO room (Room_no,building,date_time) VALUE ('$room_no_add','$building_add',Now())")) {
            echo 1;
            return;
        }
    }
}

function room_update()
{
    global $web_con;

    $room_id = web($_POST["room_id"]);
    $room_no = web($_POST["room_no"]);
    $building = web($_POST["building"]);

    $get_room_id = mysqli_fetch_assoc($web_con->query("SELECT * FROM room WHERE Room_no = '$room_no'"));
    if ($get_room_id) {
        $room_no_id = $get_room_id['id'];
    } else {
        $room_no_id = $room_id;
    }

    if ($room_id != $room_no_id) {
        echo 2;
        return;
    } else if ($room_no == '') {
        echo 3;
        return;
    } else if ($building == '') {
        echo 4;
        return;
    } else {
        if (mysqli_query($web_con, "UPDATE room SET Room_no = '$room_no', building='$building' WHERE id = '$room_id'")) {
            echo 1;
            return;
        }
    }
}
//-------------------------------------------------------------------Rooms Function END--->

//-------------------------------------------------------------------Semester Function START--->
function add_sem()
{
    global $web_con;

    $sem_no_add = web($_POST["sem_no_add"]);
    $sem_sy_from = web($_POST["sem_sy_from"]);
    $sem_sy_to = web($_POST["sem_sy_to"]);

    switch ($sem_no_add) {
        case '1':
            $sem_desc = '1st Semester';
            break;
        case '2':
            $sem_desc = '2nd Semester';
            break;
        case '3':
            $sem_desc = 'Summer';
            break;
        default:
            $sem_desc = 'Error';
            break;
    }

    $create_description = $sem_sy_from . '-' . $sem_sy_to . ' ' . $sem_desc;
    $create_sy = $sem_sy_from . '-' . $sem_sy_to;
    $check_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM semester WHERE Sem_no='$sem_no_add' AND School_year='$create_sy'"));

    if ($sem_no_add == 'none') {
        echo 2;
        return;
    } else if ($sem_sy_from == '') {
        echo 3;
        return;
    } else if ($sem_sy_to == '') {
        echo 4;
        return;
    } else if ($check_data) {
        echo 5;
        return;
    } else {
        if (mysqli_query($web_con, "INSERT INTO semester (Sem_no,Sem_description,School_year,date_time) VALUE ('$sem_no_add','$create_description','$create_sy',Now())")) {
            if ($all_faculty = mysqli_query($web_con, ("SELECT * FROM faculty WHERE status = 0"))) {
                while ($all_faculty_row = mysqli_fetch_assoc($all_faculty)) {
                    $faculty_id = $all_faculty_row['Faculty_id'];
                    $get_sem_id = mysqli_fetch_assoc($web_con->query("SELECT * FROM semester ORDER BY Sem_id DESC LIMIT 1"));
                    if ($get_sem_id) {
                        $sem_id = $get_sem_id['Sem_id'];
                    } else {
                        $sem_id = 1;
                    }
                    $check_if_exist = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Subject_id = 0 AND Faculty_id = '$faculty_id' AND sem_id = '$sem_id'"));
                    if (!$check_if_exist) {
                        mysqli_query($web_con, "INSERT INTO class (Subject_id,Faculty_id,Room_id,Lab_id,sem_id,Lec_start,Lec_end,Lab_start,Lab_end,Lab_day,Lec_day,status,date_time) VALUE ('0','$faculty_id','0','0','$sem_id','0','0','0','0','0','0','0',Now())");
                    }
                }
            }
            echo 1;
            return;
        }
    }
}
function sem_update()
{
    global $web_con;

    $dem_id = web($_POST["sem_id"]);
    $sem_no = web($_POST["sem_no"]);
    $sem_sy_from_update = web($_POST["sem_sy_from_update"]);
    $sem_sy_to_update = web($_POST["sem_sy_to_update"]);

    switch ($sem_no) {
        case '1':
            $sem_desc = '1st Semester';
            break;
        case '2':
            $sem_desc = '2nd Semester';
            break;
        case '3':
            $sem_desc = 'Summer';
            break;
        default:
            $sem_desc = 'Error';
            break;
    }

    $create_description = $sem_sy_from_update . '-' . $sem_sy_to_update . ' ' . $sem_desc;
    $create_sy = $sem_sy_from_update . '-' . $sem_sy_to_update;
    $check_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM semester WHERE Sem_no='$sem_no' AND School_year='$create_sy'"));

    if ($sem_no == 'none') {
        echo 2;
        return;
    } else if ($sem_sy_from_update == '') {
        echo 3;
        return;
    } else if ($sem_sy_to_update == '') {
        echo 4;
        return;
    } else if ($check_data) {
        echo 5;
        return;
    } else {
        if (mysqli_query($web_con, "UPDATE semester SET Sem_no='$sem_no',Sem_description='$create_description',School_year='$create_sy' WHERE Sem_id = '$dem_id'")) {
            echo 1;
            return;
        }
    }
}
//-------------------------------------------------------------------Semester Function END--->

//-------------------------------------------------------------------Class Function START--->
function update_studentCount()
{
    global $web_con;

    $id = $_POST['dataTask'];
    $value = $_POST["value"];

    if (!is_numeric($value)) {
        echo 2;
        return;
    } else {
        mysqli_query($web_con, "UPDATE class SET students_count = '$value' WHERE id = '$id'");
        echo 1;
        return;
    }
}
function remove_class()
{
    global $web_con;

    $class_id = $_POST["class_id"];
    $getfaculty_id = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE id='$class_id'"));
    if ($getfaculty_id) {
        $faculty_id = $getfaculty_id['Faculty_id'];
        $semester = $getfaculty_id['sem_id'];
    } else {
        $faculty_id = 0;
    }

    $check_for_empties = mysqli_fetch_assoc($web_con->query("SELECT count(*) AS resCount FROM class WHERE Subject_id = 0 AND unit_lec = 0 AND unit_lab =0 AND Faculty_id = '$faculty_id' AND Room_id=0 AND Lab_id=0 AND sem_id=0 AND Lab_day=0 AND Lec_day=0 AND students_count=0 AND status = 0"));
    //echo $check_for_empties['resCount'];
    if ($check_for_empties['resCount'] >= 1) {
        mysqli_query($web_con, "DELETE FROM class WHERE Subject_id = 0 AND unit_lec = 0 AND unit_lab =0 AND Faculty_id = '$faculty_id' AND Room_id=0 AND Lab_id=0 AND sem_id='$semester' AND sem_id=0 AND Lab_day=0 AND Lec_day=0 AND students_count=0 AND status = 0");
        if (mysqli_query($web_con, ("UPDATE class SET Subject_id=0,unit_lec=0,unit_lab=0,Room_id=0,Lab_id=0,Lec_start=0,Lec_end=0,Lab_start=0,Lab_end=0,Lab_day=0,Lec_day=0,students_count=0 WHERE id='$class_id'"))) {
            echo 1;
            return;
        } else {
            echo 101919;
            return;
        }
    } else {
        if ($class_id != '') {
            if (mysqli_query($web_con, ("UPDATE class SET Subject_id=0,unit_lec=0,unit_lab=0,Room_id=0,Lab_id=0,Lec_start=0,Lec_end=0,Lab_start=0,Lab_end=0,Lab_day=0,Lec_day=0,students_count=0 WHERE id='$class_id'"))) {
                echo 1;
                return;
            } else {
                echo 101919;
                return;
            }
        } else {
            echo 101919;
            return;
        }
    }
}
function selected_sem()
{
    unset($_SESSION['check']);
    $selected_sem = $_POST["selected_sem"];

    if ($selected_sem == 'none') {
        echo 2;
        return;
    } else {
        $_SESSION['sem'] =  $selected_sem;
        echo 1;
        return;
    }
}
//-------------------------------------------------------------------Class Function END--->

//-------------------------------------------------------------------Class Load Function START--->
function load_class()
{
    global $web_con;

    $the_selected_sem = $_SESSION['sem'];
    $class_faculty = $_POST["class_faculty"];

    $class_subject = $_POST["class_subject"];
    //$students_count = $_POST["students_count"];
    $class_room = $_POST["class_room"];
    $class_day = $_POST["class_day"];
    $time_from =  date('H:i:s', strtotime($_POST["time_from"]));
    $time_to =  date('H:i:s', strtotime($_POST["time_to"]));
    //$sem_sy_add = $_POST["sem_sy_add"];
    $data_type = $_POST["data_type"];
    $row_id = $_POST["row_id"];

    $get_subject_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM subject WHERE id = '$class_subject'"));
    if ($get_subject_data) {
        $subject_unit = intval($get_subject_data['units']);
    } else {
        echo 2;
        return;
    }

    if ($class_subject == 'none') {
        echo 2;
        return;
    } else if ($class_room == 'none') {
        echo 3;
        return;
    } /*else if ($students_count == 0 || $students_count == '') {
        echo 6;
        return;
    }*/ else {
        if ($data_type == 'Lab') {
            $check_Lab_conflict = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lab_id = '$class_room' AND Lab_start = '$time_from' AND Lab_end = '$time_to' AND Lab_day = '$class_day' AND sem_id='$the_selected_sem' AND status = 0"));
            if ($check_Lab_conflict) {
                echo 4;
                return;
            } else {
                $recheck_Lec_conflict = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Room_id = '$class_room' AND Lec_start = '$time_from' AND Lec_end = '$time_to' AND Lec_day = '$class_day' AND sem_id='$the_selected_sem' AND status = 0"));
                if ($recheck_Lec_conflict) {
                    echo 4;
                    return;
                } else {
                    //$check_Lec_conflict2 = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lec_end > '$time_from' AND Lec_day = '$class_day' AND Room_id = '$class_room'"));
                    /*if ($check_Lec_conflict2) {
                        echo 5;
                        return;
                    } else {*/
                    $check_available = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Subject_id = '$class_subject' AND Faculty_id = '$class_faculty' AND Lab_id = '0' AND Lab_start = '0' AND Lab_end = '0' AND Lab_day = '0' AND sem_id='$the_selected_sem' AND status = 0"));
                    $check_blank = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Subject_id = '0' AND Faculty_id = '$class_faculty' AND Lab_id = '0' AND Lab_start = '0' AND Lab_end = '0' AND Lab_day = '0' AND sem_id='$the_selected_sem' AND status = 0"));
                    if ($check_available) {
                        $res_available_id = $check_available['id'];
                        if (mysqli_query($web_con, "UPDATE class SET unit_lab = '$subject_unit', Lab_id = '$class_room', sem_id = '$the_selected_sem', Lab_start = '$time_from', Lab_end = '$time_to',Lab_day = '$class_day', students_count = '0' WHERE id = '$res_available_id'")) {
                            if (mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE id = '$row_id'")) {
                                echo 1;
                                return;
                            } else {
                                echo 101919;
                                return;
                            }
                        } else {
                            echo 101919;
                            return;
                        }
                    } else if ($check_blank) {
                        $res_blank_id = $check_blank['id'];
                        if (mysqli_query($web_con, "UPDATE class SET Subject_id = '$class_subject', unit_lab = '$subject_unit', Lab_id = '$class_room',sem_id = '$the_selected_sem', Lab_start = '$time_from', Lab_end = '$time_to',Lab_day = '$class_day',students_count = '0' WHERE id = '$res_blank_id'")) {
                            if (mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE id = '$row_id'")) {
                                echo 1;
                                return;
                            } else {
                                echo 101919;
                                return;
                            }
                        } else {
                            echo 101919;
                            return;
                        }
                    } else { //
                        if (mysqli_query($web_con, "INSERT INTO class (Subject_id,unit_lec,unit_lab,Faculty_id,Room_id,Lab_id,sem_id,Lec_start,Lec_end,Lab_start,Lab_end,Lab_day,Lec_day,students_count,date_time) VALUE ('$class_subject',0,'$subject_unit','$class_faculty','0','$class_room','$the_selected_sem','0','0','$time_from','$time_to','$class_day','0','0',Now())")) {
                            if (mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE id = '$row_id'")) {
                                echo 1;
                                return;
                            } else {
                                echo 101919;
                                return;
                            }
                        }
                    }
                    //}
                }
            }
        } else {
            $check_Lec_conflict = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Room_id = '$class_room' AND Lec_start = '$time_from' AND Lec_end = '$time_to' AND sem_id = '$the_selected_sem' AND Lec_day = '$class_day' AND status = 0"));
            if ($check_Lec_conflict) {
                echo 4;
                return;
            } else {
                $recheck_Lab_conflict = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lab_id = '$class_room' AND Lab_start = '$time_from' AND Lab_end = '$time_to' AND sem_id = '$the_selected_sem' AND Lab_day = '$class_day' AND status = 0"));
                if ($recheck_Lab_conflict) {
                    echo 4;
                    return;
                } else {
                    /*$check_Lab_conflict2 = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lab_end > '$time_from' AND Lab_day = '$class_day' AND Lab_id = '$class_room'"));
                    if ($check_Lab_conflict2) {
                        echo 5;
                        return;
                    } else {*/
                    $check_available = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Subject_id = '$class_subject' AND Faculty_id = '$class_faculty' AND Room_id = '0' AND Lec_start = '0' AND Lec_end = '0' AND Lec_day = '0' AND sem_id='$the_selected_sem' AND status = 0"));
                    $check_blank = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Subject_id = '0' AND Faculty_id = '$class_faculty' AND Room_id = '0' AND Lec_start = '0' AND Lec_end = '0' AND Lec_day = '0' AND sem_id='$the_selected_sem' AND status = 0"));
                    if ($check_available) {
                        $res_available_id = $check_available['id'];
                        if (mysqli_query($web_con, "UPDATE class SET unit_lec = '$subject_unit',Room_id = '$class_room', sem_id = '$the_selected_sem', Lec_start = '$time_from', Lec_end = '$time_to',Lec_day = '$class_day',students_count = '0' WHERE id = '$res_available_id'")) {
                            if (mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE id = '$row_id'")) {
                                echo 1;
                                return;
                            } else {
                                echo 101919;
                                return;
                            }
                        } else {
                            echo 101919;
                            return;
                        }
                    } else if ($check_blank) {
                        $res_blank_id = $check_blank['id'];
                        if (mysqli_query($web_con, "UPDATE class SET Subject_id = '$class_subject',unit_lec = '$subject_unit', Room_id = '$class_room',sem_id = '$the_selected_sem', Lec_start = '$time_from', Lec_end = '$time_to',Lec_day = '$class_day',students_count = '0' WHERE id = '$res_blank_id'")) {
                            if (mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE id = '$row_id'")) {
                                echo 1;
                                return;
                            } else {
                                echo 101919;
                                return;
                            }
                        } else {
                            echo 101919;
                            return;
                        }
                    } else {
                        if (mysqli_query($web_con, "INSERT INTO class (Subject_id,unit_lec,unit_lab,Faculty_id,Room_id,Lab_id,sem_id,Lec_start,Lec_end,Lab_start,Lab_end,Lab_day,Lec_day,students_count,date_time) VALUE ('$class_subject','$subject_unit',0,'$class_faculty','$class_room','0','$the_selected_sem','$time_from','$time_to','0','0','0','$class_day',0,Now())")) {
                            if (mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE id = '$row_id'")) {
                                echo 1;
                                return;
                            } else {
                                echo 101919;
                                return;
                            }
                        }
                    }
                    //}
                }
            }
        }
    }
}
function load_sched()
{
    global $web_con, $converted_start_time, $converted_end_time, $data_week_days;

    $data_class_type = $_POST["class_type"];
    $the_selected_sem = $_SESSION['sem'];

    //$converted_start_time =  date('h:i:s a', strtotime($_POST["start_time"]));
    $converted_start_time =  date('H:i:s', strtotime($_POST["start_time"]));
    $converted_end_time =  date('H:i:s', strtotime($_POST["end_time"]));
    $data_week_days = $_POST["week_days"];
    //$data_start_time = $converted_start_time;
    //$data_end_time = $converted_end_time;

    if ($data_week_days == 'none' || $data_class_type == 'none' || $converted_start_time >= $converted_end_time) {
        //$test = $_POST["start_time"];
        //echo "<script>alert('Erro! This is not possible... $converted_start_time')</script>";
        unset($_SESSION['check']);
        return;
    }

    $date_now = date("Ymd");
    $get_latest_session = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE session LIKE '$date_now%' ORDER BY id DESC LIMIT 1"));
    if ($get_latest_session) {
        $current_session = $get_latest_session['session'];
        $the_session = intval($current_session) + 1;
    } else {
        $the_session = $date_now . '101';
    }
    //echo "<script>alert('top')</script>";
    if ($data_class_type == 'Lab') {
        //echo "<script>alert('Default Time $converted_start_time $converted_end_time')</script>";
        if (mysqli_num_rows(mysqli_query($web_con, "SELECT * FROM class WHERE Lab_day = '$data_week_days' AND status = 0 AND sem_id='$the_selected_sem'")) != 0) {
            //echo "<script>alert('if')</script>";

            $lab_data = mysqli_query($web_con, "SELECT * FROM class WHERE Lab_day = '$data_week_days' OR Lab_day != '$data_week_days' AND status = 0 AND sem_id='$the_selected_sem' OR sem_id=0 ORDER BY id DESC");

            while ($data_glab_row = mysqli_fetch_assoc($lab_data)) {
                $faculty_start_lab = $data_glab_row['Lab_start'];
                $faculty_end_lab = $data_glab_row['Lab_end'];
                $faculty_day_lab = $data_glab_row['Lab_day'];
                $_faculty_start_lec = $data_glab_row['Lec_start'];
                $_faculty_end_lec = $data_glab_row['Lec_end'];
                $faculty_day_lec = $data_glab_row['Lec_day'];
                $Faculty_id_lab = $data_glab_row['Faculty_id'];
                $class_id_lab = $data_glab_row['id'];

                $check_if_duplicate2 = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE faculty_id = '$Faculty_id_lab' AND status = 'okay' AND session = '$the_session'"));
                $check_if_duplicate = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE faculty_id = '$Faculty_id_lab' AND status = 'not okay' AND session = '$the_session'"));
                $double_check = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lec_day = '$data_week_days' AND Lec_start='$converted_start_time' AND Lec_end = '$converted_end_time' AND Faculty_id ='$Faculty_id_lab'"));

                if ($faculty_start_lab >= $converted_end_time && $faculty_end_lab > $converted_end_time && $converted_end_time > $converted_start_time || $faculty_start_lab < $converted_start_time && $faculty_end_lab <= $converted_start_time && $converted_end_time > $converted_start_time) {
                    if ($_faculty_start_lec >= $converted_end_time && $_faculty_end_lec > $converted_end_time && $converted_end_time > $converted_start_time || $_faculty_start_lec < $converted_start_time && $_faculty_end_lec <= $converted_start_time && $converted_end_time > $converted_start_time) {
                        if ($check_if_duplicate) {
                            //mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lab' AND session = '$the_session'");
                        } else {
                            if ($check_if_duplicate2) {
                                //return;
                            } else {
                                if ($double_check) {
                                    //
                                } else {
                                    if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lab','$Faculty_id_lab','okay','$data_week_days','$data_class_type','$faculty_start_lab','$faculty_end_lab','$faculty_day_lab','$converted_start_time','$converted_end_time','$the_session')")) {
                                        $_SESSION['check'] = $the_session;
                                        //echo "<script>alert('okay $Faculty_id_lab $faculty_end_lab $converted_start_time')</script>";
                                        //echo "<script>alert('okay 1')</script>";
                                    }
                                }
                            }
                        }
                    } else {
                        if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lab','$Faculty_id_lab','not okay','$data_week_days','$data_class_type','$faculty_start_lab','$faculty_end_lab','$faculty_day_lab','$converted_start_time','$converted_end_time','$the_session')")) {
                            $_SESSION['check'] = $the_session;
                            //echo "<script>alert('not okay $Faculty_id_lab $faculty_end_lab $converted_start_time')</script>";
                            //echo "<script>alert('okay 2')</script>";
                        }
                    }
                } else {
                    if ($check_if_duplicate2) {
                        mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lab' AND session = '$the_session'");
                    } else {
                        //$Faculty_id_lab = $data_glab_row['Faculty_id'];
                        if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lab','$Faculty_id_lab','not okay','$data_week_days','$data_class_type','$faculty_start_lab','$faculty_end_lab',$faculty_day_lab,'$converted_start_time','$converted_end_time','$the_session')")) {
                            $_SESSION['check'] = $the_session;
                            //echo "<script>alert('not okay $Faculty_id_lab $faculty_end_lab $converted_start_time')</script>";
                            //echo "<script>alert('okay 3')</script>";
                        }
                    }
                }
                //echo "<script>alert($Faculty_id_lab)</script>";
            }
        } else {
            //echo "<script>alert('else')</script>";
            $lab_data2 = mysqli_query($web_con, "SELECT * FROM class WHERE status = 0 AND sem_id='0' OR sem_id='$the_selected_sem' AND status = 0 ORDER BY id DESC");
            while ($data2_lab_row = mysqli_fetch_assoc($lab_data2)) {
                $Faculty_id_lab1 = $data2_lab_row['Faculty_id'];
                $faculty_start_lab2 = $data2_lab_row['Lab_start'];
                $faculty_end_lab2 = $data2_lab_row['Lab_end'];
                $faculty_day_lab2 = $data2_lab_row['Lab_day'];
                $_faculty_start_lec2 = $data2_lab_row['Lec_start'];
                $_faculty_end_lec2 = $data2_lab_row['Lec_end'];
                $faculty_day_lec2 = $data2_lab_row['Lec_day'];
                $faculty_lec_day = $data2_lab_row['Lec_day'];
                $class_id_lab2 = $data2_lab_row['id'];

                $check_if_duplicate = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE faculty_id = '$Faculty_id_lab1' AND status = 'not okay' AND session = '$the_session'"));
                $check_if_duplicate2 = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE faculty_id = '$Faculty_id_lab1' AND status = 'okay' AND session = '$the_session'"));
                $double_check = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lec_day = '$data_week_days' AND Lec_start='$converted_start_time' AND Lec_end = '$converted_end_time' AND Faculty_id ='$Faculty_id_lab1'"));

                if ($faculty_lec_day != $data_week_days) {
                    //echo "<script>alert('test 1')</script>";
                    //echo "<script>alert('Lab insert1 $faculty_lec_day $data_week_days')</script>";
                    if ($check_if_duplicate) {
                        //mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lab1' AND session = '$the_session'");
                    } else {
                        if ($check_if_duplicate2) {
                            //return;
                        } else {
                            if ($double_check) {
                                //
                            } else {
                                if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lab2','$Faculty_id_lab1','okay','$data_week_days','$data_class_type','$faculty_start_lab2','$faculty_end_lab2',$faculty_day_lab2,'$converted_start_time','$converted_end_time','$the_session')")) {
                                    $_SESSION['check'] = $the_session;
                                    //echo "<script>alert('okay $Faculty_id_lab $faculty_end_lab $converted_start_time')</script>";
                                    //echo "<script>alert('okay 4')</script>";
                                }
                            }
                        }
                    }
                } else {
                    //echo "<script>alert('test 2')</script>";
                    if ($_faculty_start_lec2 >= $converted_end_time && $_faculty_end_lec2 > $converted_end_time && $converted_end_time > $converted_start_time || $_faculty_start_lec2 < $converted_start_time && $_faculty_end_lec2 <= $converted_start_time && $converted_end_time > $converted_start_time) {
                        if ($check_if_duplicate) {
                            //mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lab1' AND session = '$the_session'");
                        } else {
                            if ($check_if_duplicate2) {
                                //return;
                            } else {
                                if ($double_check) {
                                    //
                                } else {
                                    if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lab2','$Faculty_id_lab1','okay','$data_week_days','$data_class_type','$faculty_start_lab2','$faculty_end_lab2','$faculty_day_lab2','$converted_start_time','$converted_end_time','$the_session')")) {
                                        $_SESSION['check'] = $the_session;
                                        //echo "<script>alert('Lab insert2')</script>";
                                        //echo "<script>alert('okay $Faculty_id_lab $faculty_end_lab $converted_start_time')</script>";
                                        //echo "<script>alert('okay 5')</script>";
                                    }
                                }
                            }
                        }
                    } else {
                        if ($check_if_duplicate) {
                            //mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lab1' AND session = '$the_session'");
                        } else {
                            if ($check_if_duplicate2) {
                                //return;
                            } else {
                                if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lab2','$Faculty_id_lab1','not okay','$data_week_days','$data_class_type','$faculty_start_lab2','$faculty_end_lab2','$faculty_day_lab2','$converted_start_time','$converted_end_time','$the_session')")) {
                                    $_SESSION['check'] = $the_session;
                                    //echo "<script>alert('Lab insert3')</script>";
                                    //echo "<script>alert('not okay $Faculty_id_lab $faculty_end_lab $converted_start_time')</script>";
                                    //echo "<script>alert('not okay 6')</script>";
                                }
                            }
                        }
                    }
                }
            }
        }
    } else if ($data_class_type == 'Lec') {
        if (mysqli_num_rows(mysqli_query($web_con, "SELECT * FROM class WHERE Lec_day = '$data_week_days' AND status = 0 AND sem_id='$the_selected_sem'")) != 0) {

            $lec_data = mysqli_query($web_con, "SELECT * FROM class WHERE Lab_day = '$data_week_days' OR Lab_day != '$data_week_days' AND status = 0 AND sem_id='$the_selected_sem' OR sem_id=0 ORDER BY id DESC");

            while ($data_lec_row = mysqli_fetch_assoc($lec_data)) {
                $faculty_start_lec = $data_lec_row['Lec_start'];
                $faculty_end_lec = $data_lec_row['Lec_end'];
                $faculty_day_lec = $data_lec_row['Lec_day'];
                $_faculty_start_lab = $data_lec_row['Lab_start'];
                $_faculty_end_lab = $data_lec_row['Lab_end'];
                $Faculty_id_lec = $data_lec_row['Faculty_id'];
                $class_id_lec = $data_lec_row['id'];

                /*$lab_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lab_day = '$data_week_days' OR Lab_day = '0' OR Lab_day != '$data_week_days'"));
                $faculty_start_lab = $lab_data['Lab_start'];
                $faculty_end_lab = $lab_data['Lab_end'];*/

                //echo "<script>alert('(if)okay $faculty_start_lab $faculty_end_lab')</script>";
                $check_if_duplicate = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE faculty_id = '$Faculty_id_lec' AND status = 'not okay' AND session = '$the_session'"));
                $check_if_duplicate2 = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE faculty_id = '$Faculty_id_lec' AND status = 'okay' AND session = '$the_session'"));
                $double_check = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lab_day = '$data_week_days' AND Lab_start='$converted_start_time' ANd Lab_end = '$converted_end_time' AND Faculty_id ='$Faculty_id_lec'"));

                if ($faculty_start_lec >= $converted_end_time && $faculty_end_lec > $converted_end_time && $converted_end_time > $converted_start_time || $faculty_start_lec < $converted_start_time && $faculty_end_lec <= $converted_start_time && $converted_end_time > $converted_start_time) {
                    if ($_faculty_start_lab >= $converted_end_time && $_faculty_end_lab > $converted_end_time && $converted_end_time > $converted_start_time || $_faculty_start_lab < $converted_start_time && $_faculty_end_lab <= $converted_start_time && $converted_end_time > $converted_start_time) {
                        if ($check_if_duplicate) {
                            //mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lec' AND session = '$the_session'");
                        } else {
                            if ($check_if_duplicate2) {
                                //return;
                            } else {
                                if ($double_check) {
                                    //
                                } else {
                                    if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lec','$Faculty_id_lec','okay','$data_week_days','$data_class_type','$faculty_start_lec','$faculty_end_lec','$faculty_day_lec','$converted_start_time','$converted_end_time','$the_session')")) {
                                        $_SESSION['check'] = $the_session;
                                        //echo "<script>alert('okay $Faculty_id_lec $faculty_end_lec $converted_start_time')</script>";
                                    }
                                }
                            }
                        }
                    } else {
                        if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lec','$Faculty_id_lec','not okay','$data_week_days','$data_class_type','$faculty_start_lec','$faculty_end_lec','$faculty_day_lec','$converted_start_time','$converted_end_time','$the_session')")) {
                            $_SESSION['check'] = $the_session;
                            //echo "<script>alert('not okay1 $Faculty_id_lec $faculty_end_lec $converted_start_time')</script>";
                        }
                    }
                } else {
                    //$Faculty_id_lec = $data_lec_row['Faculty_id'];
                    if ($check_if_duplicate2) {
                        mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lec' AND session = '$the_session'");
                    } else {
                        if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lec','$Faculty_id_lec','not okay','$data_week_days','$data_class_type','$faculty_start_lec','$faculty_end_lec','$faculty_day_lec','$converted_start_time','$converted_end_time','$the_session')")) {
                            $_SESSION['check'] = $the_session;
                            //echo "<script>alert('not okay2 $Faculty_id_lec $faculty_end_lec $converted_start_time')</script>";
                        }
                    }
                }
            }
        } else {
            $lec_data2 = mysqli_query($web_con, "SELECT * FROM class WHERE status = 0 AND sem_id='0' OR sem_id='$the_selected_sem' AND status = 0 ORDER BY id DESC");
            while ($data2_lec_row = mysqli_fetch_assoc($lec_data2)) {
                $Faculty_id_lec1 = $data2_lec_row['Faculty_id'];
                $faculty_start_lec2 = $data2_lec_row['Lec_start'];
                $faculty_end_lec2 = $data2_lec_row['Lec_end'];
                $faculty_day_lec2 = $data2_lec_row['Lec_day'];
                $faculty_start_lab2 = $data2_lec_row['Lab_start'];
                $faculty_end_lab2 = $data2_lec_row['Lab_end'];
                $faculty_lab_day = $data2_lec_row['Lab_day'];
                $class_id_lec2 = $data2_lec_row['id'];

                $check_if_duplicate = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE faculty_id = '$Faculty_id_lec1' AND status = 'not okay' AND session = '$the_session'"));
                $check_if_duplicate2 = mysqli_fetch_assoc($web_con->query("SELECT * FROM check_log WHERE faculty_id = '$Faculty_id_lec1' AND status = 'okay' AND session = '$the_session'"));
                $double_check = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Lab_day = '$data_week_days' AND Lab_start='$converted_start_time' ANd Lab_end = '$converted_end_time' AND Faculty_id ='$Faculty_id_lec1'"));

                if ($faculty_lab_day != $data_week_days) {
                    if ($check_if_duplicate) {
                        //mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lec1' AND session = '$the_session'");
                    } else {
                        if ($check_if_duplicate2) {
                            //return;
                        } else {
                            if ($double_check) {
                                //
                            } else {
                                if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lec2','$Faculty_id_lec1','okay','$data_week_days','$data_class_type','$faculty_start_lec2','$faculty_end_lec2','$faculty_day_lec2','$converted_start_time','$converted_end_time','$the_session')")) {
                                    $_SESSION['check'] = $the_session;
                                    //echo "<script>alert('Lec insert1')</script>";
                                    //echo "<script>alert('okay $Faculty_id_lec1 $faculty_start_lec2 $faculty_end_lec2')</script>";
                                }
                            }
                        }
                    }
                } else {
                    if ($faculty_start_lab2 >= $converted_end_time && $faculty_end_lab2 > $converted_end_time && $converted_end_time > $converted_start_time || $faculty_start_lab2 < $converted_start_time && $faculty_end_lab2 <= $converted_start_time && $converted_end_time > $converted_start_time) {
                        if ($check_if_duplicate) {
                            //mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lec1' AND session = '$the_session'");
                        } else {
                            if ($check_if_duplicate2) {
                                //return;
                            } else {
                                if ($double_check) {
                                    //
                                } else {
                                    if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lec2','$Faculty_id_lec1','okay','$data_week_days','$data_class_type','$faculty_start_lec2','$faculty_end_lec2','$faculty_day_lec2','$converted_start_time','$converted_end_time','$the_session')")) {
                                        $_SESSION['check'] = $the_session;
                                        //echo "<script>alert('Lec insert2')</script>";
                                        //echo "<script>alert('okay $Faculty_id_lec1 $faculty_start_lec2 $faculty_end_lec2')</script>";
                                    }
                                }
                            }
                        }
                    } else {
                        if ($check_if_duplicate) {
                            //mysqli_query($web_con, "UPDATE check_log SET status = 'not okay' WHERE faculty_id = '$Faculty_id_lec1' AND session = '$the_session'");
                        } else {
                            if ($check_if_duplicate2) {
                                //return;
                            } else {
                                if (mysqli_query($web_con, "INSERT INTO check_log (class_id,faculty_id,status,days,type,record_start,record_end,record_days,input_start,input_end,session) VALUE ('$class_id_lec2','$Faculty_id_lec1','not okay','$data_week_days','$data_class_type','$faculty_start_lec2','$faculty_end_lec2','$faculty_day_lec2','$converted_start_time','$converted_end_time','$the_session')")) {
                                    $_SESSION['check'] = $the_session;
                                    //echo "<script>alert('Lec insert3')</script>";
                                    //echo "<script>alert('not okay3 $Faculty_id_lec1 $faculty_start_lec2 $faculty_end_lec2')</script>";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
//-------------------------------------------------------------------Class Load Function END--->

//-------------------------------------------------------------------Semester Function START--->
function semester()
{

    $semester = $_POST["semester"];

    if ($semester == 'none') {
        echo 2;
        return;
    } else {
        $_SESSION['view_sem'] = $semester;
        echo 1;
        return;
    }
}
//-------------------------------------------------------------------Semester Function END--->

function call_session($data, $id)
{
    $_SESSION['user'] = $data;
    $_SESSION['id'] = $id;
    echo 1;
    return;
    //header('location: ../');
}

function login()
{
    global $web_con;

    $username = web($_POST["username"]);
    $password = web($_POST["password"]);
    $recaptcha = web($_POST["recaptcha"]);

    $check_account = mysqli_fetch_assoc($web_con->query("SELECT * FROM user WHERE username = '$username' AND password = '$password'"));
    $check_username = mysqli_fetch_assoc($web_con->query("SELECT * FROM user WHERE username = '$username'"));
    $checkLastAtempt = mysqli_fetch_assoc($web_con->query("SELECT * FROM login_atempts WHERE username ='$username' ORDER BY id DESC LIMIT 1"));

    $secretKey = "6LddVlgjAAAAAEgnLHmXAfTHk3G5_YNv3nm1PqmO";
    $ip = $_SERVER['REMOTE_ADDR'];
    // post request to server
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($recaptcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    // should return JSON with success as true
    if ($responseKeys["success"]) {

        if ($check_account) {
            $_SESSION['check'] = 0;
            call_session($check_account['user_type'], $check_account['id']);
        } else {
            if ($check_username) {
                if ($checkLastAtempt) {
                    $last_atempt_count = $checkLastAtempt['atempts'];
                    if (!is_null($checkLastAtempt['atempt_rest'])) {
                        $datetimeNow = strtotime(date("Y-m-d H:i:s"));
                        $last_atempt_rest = strtotime($checkLastAtempt['atempt_rest']);
                        if ($datetimeNow >= $last_atempt_rest) {
                            mysqli_query($web_con, "INSERT INTO login_atempts (username,atempts,atempt_created) VALUES ('$username','1',NOW())");
                        } else {
                            //echo 'now:' . date("Y-m-d H:i:s") . ' DB: ' . $checkLastAtempt['atempt_rest'];
                            if ($last_atempt_count != 5) {
                                mysqli_query($web_con, "UPDATE login_atempts SET atempts = atempts +1 WHERE username ='$username' AND isNull(atempt_rest)");
                            } else {
                                if (mysqli_query($web_con, "UPDATE login_atempts SET atempt_rest = DATE_ADD(NOW(), INTERVAL 5 MINUTE)  WHERE username ='$username' AND isNull(atempt_rest)")) {
                                    echo 3;
                                    return;
                                }
                            }
                        }
                    } else {
                        if ($last_atempt_count != 5) {
                            mysqli_query($web_con, "UPDATE login_atempts SET atempts = atempts +1 WHERE username ='$username' AND isNull(atempt_rest)");
                        } else {
                            if (mysqli_query($web_con, "UPDATE login_atempts SET atempt_rest = DATE_ADD(NOW(), INTERVAL 5 MINUTE)  WHERE username ='$username' AND isNull(atempt_rest)")) {
                                echo 3;
                                return;
                            }
                        }
                    }
                } else {
                    mysqli_query($web_con, "INSERT INTO login_atempts (username,atempts,atempt_created) VALUES ('$username','1',NOW())");
                }
            }
            echo 2;
            return;
        }
    } else {
        echo 4;
        return;
    }
}

function get_live_data()
{
    global $web_con;
    $faculty_id = web($_POST["faculty_id"]);
    $get_record = mysqli_query($web_con, "SELECT * FROM faculty WHERE Faculty_id = '$faculty_id'");
}
