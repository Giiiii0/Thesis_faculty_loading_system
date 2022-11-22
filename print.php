<?php
include('functions/process.php');

$facultyID = isset($_GET['print']) ? $_GET['print'] : '';
$value = isset($_GET['val']) ? $_GET['val'] : '';
$selectedSem = $_SESSION['sem'];

if ($value <= 9) {
  $type = 'Package Load';
  $getClassData = mysqli_query($web_con, "SELECT * FROM class WHERE Faculty_id = '$facultyID' AND sem_id = '$selectedSem' AND students_count <= 9");
} else {
  $type = 'Regular Load';
  $getClassData = mysqli_query($web_con, "SELECT * FROM class WHERE Faculty_id = '$facultyID' AND sem_id = '$selectedSem' AND students_count > 9");
}

//$getClassData = mysqli_query($web_con, "SELECT * FROM class WHERE Faculty_id = '$facultyID' AND sem_id = '$selectedSem'");
$get_faculty = mysqli_fetch_assoc($web_con->query("SELECT * FROM faculty WHERE Faculty_id ='$facultyID'"));
$get_semSY = mysqli_fetch_assoc($web_con->query("SELECT * FROM semester WHERE Sem_id ='$selectedSem'"));

$sem = $get_semSY['Sem_no'];
$SY = $get_semSY['School_year'];

if ($sem == "1") {
  $semester = '1st Semester';
} else if ($sem == "2") {
  $semester = '2nd Semester';
} else {
  $semester = 'Summer';
}

$faculty_fname = $get_faculty['FirstName'];
$faculty_mname = $get_faculty['MiddleInitial'];
$faculty_lname = $get_faculty['LastName'];
$MI = substr($faculty_mname, 0, 1);

$faculty_display_name = $faculty_fname . ' ' . $MI . '. ' . $faculty_lname;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CCS Faculty Loading System</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/website.min.css">
</head>

<body>
  <div class="wrapper">
    <section class="invoice">
      <div class="row">
        <div class="col-12">
          <h2 class="page-header">
            <div class="row">
              <div class="col-4">
                <img width="100px" height="100px" src="../dist/img/IMCC.png" alt="Visa">
              </div>
              <div style="margin-top: 20px;" class="col-5">
                <b>Iligan Medical Center College</b>
              </div>
              <div class="col-3">
                <small class="float-right"><img width="100px" height="100px" src="../dist/img/CCS.png" alt="Visa"></small>
              </div>
            </div>
          </h2>
        </div>
      </div>
      <div style="padding-top: -50px; text-align: center;" class="invoice-info">
        Isabel Village, Pala-o, Iligan City<br>
        Member: Philippines Association of college & Universities (PACUCUA)<br>
        Member: Philippines Society of Information Technology Educators (PSITE) & CODE-IT R10 & Computing Socienty Philippines (CSP)
      </div>
      <div style="padding-top: 10px" class="row">
        <div class="col-12 table-responsive">
          <table id="MyTable" class="table table-striped">
            <thead>
              <th style="text-align: center;" colspan="9">College of Computer Studies (CCS)</th>
            </thead>
            <thead>
              <th style="text-align: center; font-size:20px;" colspan="9">
                <b>Faculty Teaching Load (<?php echo $type ?>)
                  <!--input style="border: 0; border-bottom: 0px;" type="text" class="signature" placeholder="Click Me To Edit" /-->
                </b><br>
                <?php echo $semester ?> SY <?php echo $SY ?>
              </th>
            </thead>
            <thead>
              <th style="text-align: center;" colspan="9"><?php echo $faculty_display_name ?></th>
            </thead>
            <thead>
              <th style="text-align: center;" colspan="2">Employment Status:</th>
              <th style="align-items: centers;" colspan="7">
                <div class="float-right">
                  <div class="col-lg-6">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <div class="custom-control custom-radio">
                            <!--input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" onclick="document.getElementById('load_type').innerHTML='Regular'"-->
                            <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio">
                            <label for="customRadio1" id="customRadio1" class="custom-control-label">Full Time</label>
                          </div>
                        </span>
                        <span class="input-group-text">
                          <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio">
                            <label for="customRadio2" id="customRadio2" class="custom-control-label">Part Time</label>
                          </div>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </th>
            </thead>
            <thead>
              <tr>
                <th>Offer Number</th>
                <th>Subject Code</th>
                <th>Description</th>
                <th>Day(s)</th>
                <th style="text-align: center;">Units</th>
                <th>Time</th>
                <th>Room</th>
                <th style="text-align: center;">Section</th>
                <th style="text-align: center;">Credit Hours</th>
                <th style="text-align: center;">Students</th>
              </tr>
            </thead>
            <!--tbody>
              <td colspan="9" style="text-align: center;">MONDAY - THURSDAY</td>
            </tbody-->
            <tbody>
              <?php
              while ($rowData = mysqli_fetch_assoc($getClassData)) {
                $subjectID = $rowData['Subject_id'];
                $lecRoomID = $rowData['Room_id'];
                $labRoomID = $rowData['Lab_id'];

                $fetchSubjects = mysqli_fetch_assoc($web_con->query("SELECT * FROM subject WHERE id ='$subjectID'"));
                $fetchLecRoom = mysqli_fetch_assoc($web_con->query("SELECT * FROM room WHERE id ='$lecRoomID'"));
                $fetchLabRoom = mysqli_fetch_assoc($web_con->query("SELECT * FROM room WHERE id ='$labRoomID'"));

                if ($rowData['Lab_start'] == '00:00:00') {
                  $lab_time_start = '';
                  $lab_time_end = '';
                } else {
                  $lab_time_start = date('h:i A', strtotime($rowData['Lab_start']));
                  $lab_time_end = '-' . date('h:i A', strtotime($rowData['Lab_end']));
                }
                if ($rowData['Lec_start'] == '00:00:00') {
                  $lec_time_start = '';
                  $lec_time_end = '';
                } else {
                  $lec_time_start = date('h:i A', strtotime($rowData['Lec_start']));
                  $lec_time_end = '-' . date('h:i A', strtotime($rowData['Lec_end']));
                }
                if ($rowData['Lec_day'] == 0) {
                  $lec_day = '';
                } else {
                  $lec_day = $rowData['Lec_day'];
                }
                if ($rowData['Lab_day'] == 0) {
                  $lab_day = '';
                } else {
                  $lab_day = $rowData['Lab_day'];
                }
                if ($rowData['Room_id'] == 0) {
                  $room_lec = '';
                } else {
                  $room_lec = $fetchLecRoom['Room_no'];
                }
                if ($rowData['Lab_id'] == 0) {
                  $room_lab = '';
                } else {
                  $room_lab = $fetchLabRoom['Room_no'];
                }


              ?>
                <tr>
                  <td style="padding-top:25px;"><?php echo $fetchSubjects['offer_no'] ?></td>
                  <td style="padding-top:25px;"><?php echo $fetchSubjects['Course_code'] ?></td>
                  <!--td style="width: 200px; font-size: 11px;"><b><?php echo $fetchSubjects['Description'] ?></b></td-->
                  <td style="width: 200px;"><?php echo $fetchSubjects['Description'] ?></td>
                  <td>
                    <?php echo $lec_day ?><br><?php echo $lab_day ?>
                  </td>
                  <td style="padding-top:25px; text-align: center;"><?php echo $fetchSubjects['units']; ?></td>
                  <td style="width: 160px;">
                    <?php echo $lec_time_start ?><?php echo $lec_time_end ?><br>
                    <?php echo $lab_time_start ?><?php echo $lab_time_end ?>
                  </td>
                  <td>
                    <?php echo $room_lec ?><br>
                    <?php echo $room_lab ?>
                  </td>
                  <td style="padding-top:25px; text-align: center;">BSIT</td>
                  <td style="padding-top:25px; text-align: center;" oninput="updateSubTotal()" contenteditable=true>0</td>
                  <td style="padding-top:25px; text-align: center;"><?php echo $rowData['students_count'] ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <p class="lead">Prepared by:</p>
          <p class="lead"><input style="border: 0; border-bottom: 0px; width: 300px;" type="text" class="signature" placeholder="Click Me To Edit" /></p>
          <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
          <p class="lead"><small>Confirm:</small></p>
          <input style="border: 0; border-bottom: 1px solid #000; width: 300px; text-align: center;" type="text" class="signature" placeholder="Click Me To Edit" />
          <p style="padding-left: 50px;" class="lead"><small>Signature Over Printed Name</small></p>
          </p>
        </div>
        <div class="col-6">
          <p class="lead">Final Total</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total Number of Units:</th>
                <td id="unitstotal">0</td>
              </tr>
              <tr>
                <th>Total Number of Hours per week</th>
                <td id="hrstotal">0</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!--script>
    window.addEventListener("load", window.print());
  </script-->
  <script>
    updateSubTotal(); // Initial call
    function updateSubTotal() {
      var table = document.getElementById("MyTable");
      let unitTotal = Array.from(table.rows).slice(5).reduce((total, row) => {
        return total + parseFloat(row.cells[4].innerHTML);
      }, 0);
      let hrsTotal = Array.from(table.rows).slice(5).reduce((total, row) => {
        return total + parseFloat(row.cells[8].innerHTML);
      }, 0);
      document.getElementById("unitstotal").innerHTML = unitTotal;
      document.getElementById("hrstotal").innerHTML = hrsTotal;
    }
  </script>
</body>

</html>