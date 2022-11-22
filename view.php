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
  if ($check_link) {
    $faculty_id = $check_link['request_id'];
    //$sem_id = $_SESSION['view_sem'];
    if ($view_sem != 'none') {
      $get_data1 = mysqli_query($web_con, "SELECT * FROM class WHERE Faculty_id = '$faculty_id' AND status = '0' AND Subject_id != '0' AND sem_id='$view_sem'");
      $sum_unit_lec = mysqli_fetch_assoc($web_con->query("SELECT sum(unit_lec) as sum_unit_lec FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0'AND sem_id = '$view_sem'"));
      $sum_unit_lab = mysqli_fetch_assoc($web_con->query("SELECT sum(unit_lab) as sum_unit_lab FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0'AND sem_id = '$view_sem'"));
      $unit_lab = $sum_unit_lab['sum_unit_lab'];
      $unit_lec = $sum_unit_lec['sum_unit_lec'];
      $unit_sum = $unit_lab + $unit_lec;
    } else {
      $get_data1 = mysqli_query($web_con, "SELECT * FROM class WHERE Faculty_id = '$faculty_id' AND status = '0' AND Subject_id != '0'");
      $sum_unit_lec = mysqli_fetch_assoc($web_con->query("SELECT sum(unit_lec) as sum_unit_lec FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0'"));
      $sum_unit_lab = mysqli_fetch_assoc($web_con->query("SELECT sum(unit_lab) as sum_unit_lab FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0'"));
      $unit_lab = $sum_unit_lab['sum_unit_lab'];
      $unit_lec = $sum_unit_lec['sum_unit_lec'];
      $unit_sum = $unit_lab + $unit_lec;
    }
    $get_data2 = mysqli_fetch_assoc($web_con->query("SELECT * FROM class WHERE Faculty_id = '$faculty_id' AND status = '0'"));
    if ($get_data2) {
      $the_id = $get_data2['Faculty_id'];
      $get_data3 = mysqli_fetch_assoc($web_con->query("SELECT * FROM faculty WHERE Faculty_id = '$the_id'"));
      $MI = substr($get_data3['MiddleInitial'], 0, 1);
      $facuty_full_name = $get_data3['LastName'] . ', ' . $get_data3['FirstName'] . ' ' . $MI . '.';
    } else {
      header("location: ../error");
    }
  } else {
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
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../dist/css/website.min.css">
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini sidebar-collapse dark-mode">
  <div class="wrapper">

    <div class="preloader flex-column justify-content-center align-items-center">
      <!--img class="animation__wobble" src="dist/img/websiteLogo.png" alt="websiteLogo" height="60" width="60"-->
      <i class="fa-4x fas fa-spinner fa-spin"></i>
    </div>

    <div class="col-sm-12">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?php echo $facuty_full_name ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">This is the view of your current records</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!--div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>20<sup style="font-size: 20px"><code style="color:white;">(Total)</code></sup></h3>
                  <p>Subjects</p>
                </div>
                <div class="icon">
                  <i class="ion ion-folder"></i>
                </div>
                <a href="#" class="small-box-footer">Soon <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>53<sup style="font-size: 20px"><code style="color:white;">(Semester)</code></sup></h3>
                  <p>Subjects</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Soon <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>40<sup style="font-size: 20px"><code style="color:black;">(Total)</code></sup></h3>
                  <p>Students</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Soon <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>13<sup style="font-size: 20px"><code style="color:white;">(Semester)</code></sup></h3>
                  <p>Students</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Soon <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div-->
          </div>

          <div class="row">
            <section class="col-12">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <!--h3 class="card-title">DataTable with minimal features & hover style</h3-->
                        <div style="float: right; padding-left: 20px;" class="sem_view">
                          <!--label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lecture Day</code></label-->
                          <select id="semester" class="custom-select" onchange="semester()">
                            <option value="none">Select Semester</option>
                            <?php
                            while ($sem_class_row = mysqli_fetch_assoc($get_sem)) {
                            ?>
                              <option value="<?php echo $sem_class_row['Sem_id'] ?>"><?php echo $sem_class_row['Sem_description'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Offer No.</th>
                              <th>Course Code</th>
                              <th>Description</th>
                              <th>Lecture</th>
                              <th>Lec. Time</th>
                              <th>Laboratory</th>
                              <th>Lab. Time</th>
                              <th>Unit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            while ($get_data1_row = mysqli_fetch_assoc($get_data1)) {
                              $subject_id = $get_data1_row['Subject_id'];
                              $lec_room_id = $get_data1_row['Room_id'];
                              $lab_room_id = $get_data1_row['Lab_id'];

                              if ($get_subject_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM subject WHERE id = '$subject_id'"))) {
                                $CC = $get_subject_data['Course_code'];
                                $ON = $get_subject_data['offer_no'];
                                $Desc = $get_subject_data['Description'];
                                $Units = $get_subject_data['units'];
                              } else {
                                $CC = 'none';
                                $ON = 'none';
                                $Desc = 'none';
                                $Units = 'none';
                              }
                              if ($lec_room = mysqli_fetch_assoc($web_con->query("SELECT * FROM room WHERE id = '$lec_room_id'"))) {
                                $Room_no = $lec_room['Room_no'];
                                $Building = $lec_room['building'];
                                $Lec_day = $get_data1_row['Lec_day'];
                                $Lec_start = date('h:i a', strtotime($get_data1_row['Lec_start']));
                                $Lec_end = date('h:i a', strtotime($get_data1_row['Lec_end']));
                              } else {
                                $Room_no = 'none';
                                $Building = 'none';
                                $Lec_day = 'none';
                                $Lec_start = 'none';
                                $Lec_end = 'none';
                              }
                              if ($lab_room = mysqli_fetch_assoc($web_con->query("SELECT * FROM room WHERE id = '$lab_room_id'"))) {
                                $Lab_no = $lab_room['Room_no'];
                                $Building = $lab_room['building'];
                                $Lab_day = $get_data1_row['Lab_day'];
                                $Lab_start = date('h:i a', strtotime($get_data1_row['Lab_start']));
                                $Lab_end = date('h:i a', strtotime($get_data1_row['Lab_end']));
                              } else {
                                $Lab_no = 'none';
                                $Building = 'none';
                                $Lab_day = 'none';
                                $Lab_start = 'none';
                                $Lab_end = 'none';
                              }
                              $lecture = $Lec_day . ' / ' . $Room_no;
                              $lec_time = $Lec_start . ' / ' . $Lec_end;
                              $laboratory = $Lab_day . ' / ' . $Lab_no;
                              $lab_time = $Lab_start . ' / ' . $Lab_end;
                            ?>
                              <tr>
                                <td><?php echo $ON ?></td>
                                <td><?php echo $CC ?></td>
                                <td><?php echo $Desc ?></td>
                                <td><?php echo $lecture ?></td>
                                <td><?php echo $lec_time ?></td>
                                <td><?php echo $laboratory ?></td>
                                <td><?php echo $lab_time ?></td>
                                <td style="text-align:center;"><?php echo $Units ?></td>
                              </tr>

                            <?php } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th>Total Units</th>
                              <th id="unitstotal" style="text-align:center;">0</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <footer class="">
                <strong>Copyright &copy; 2022 <a href="https://www.website.com.ph" target="_blank">Website</a>. </strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                  <b>Version</b> 1.0.1
                </div>
              </footer>

            </section>
          </div>
        </div>
      </section>
    </div>

    <!-- /.content-wrapper -->
    <!--footer class="main-footer">
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer-->

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>


  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../plugins/jszip/jszip.min.js"></script>
  <script src="../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="../dist/js/website.min.js"></script>
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  <!--This is for View Javascript-----------------------------------------------------------------------START-->
  <script>
    function semester() {
      var semester = document.getElementById("semester").value;
      $.ajax({
        type: "POST", //type of method
        url: "../functions/process.php", //your page
        data: {
          semester: semester

        }, // passing the values
        success: function(res) {
          if (res == 1) {
            location.reload();
          } else if (res == 2) {
            document.getElementById("semester").style.borderColor = "red";
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error ' + res,
              text: 'Please contact the admin!'
            })
          }
        }
      });
    }
  </script>
  <script>
    $(document).ready(function() {
      $(".sem_view #semester").val(<?php echo $view_sem ?>);
    });
  </script>
  <script>
    updateSubTotal(); // Initial call
    function updateSubTotal() {
      var table = document.getElementById("example1");
      let subTotal = Array.from(table.rows).slice(1).reduce((total, row) => {
        return total + parseFloat(row.cells[7].innerHTML);
      }, 0);
      document.getElementById("unitstotal").innerHTML = subTotal;
    }
  </script>
  <!--This is for View Javascript-----------------------------------------------------------------------END-->
</body>

</html>