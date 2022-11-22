<?php
include('functions/process.php');

$action = isset($_GET['page']) ? $_GET['page'] : '';

switch ($action) {
  case 'faculty':
    $pages = 'faculty.php';
    $faculty = 'active';
    $subjects = '';
    $room = '';
    $lab = '';
    $sem = '';
    $class = '';
    break;
  case 'subjects':
    $pages = 'subjects.php';
    $subjects = 'active';
    break;
  case 'room':
    $pages = 'room.php';
    $room = 'active';
    break;
    /*case 'lab':
    $pages = 'lab.php';
    $lab = 'active';
    break;*/
  case 'sem':
    $pages = 'sem.php';
    $sem = 'active';
    break;
  case 'class':
    $pages = 'class.php';
    $class = 'active';
    break;
  case 'load_class':
    $pages = 'class_load.php';
    $class = 'active';
    break;
  default:
    $pages = 'faculty.php';
    $faculty = 'active';
    $subjects = '';
    $room = '';
    $lab = '';
    $sem = '';
    $class = '';
}

if (!isLoggedIn()) {
  $_SESSION['check'] = 0;
  header("location: login");
}

$user_id = $_SESSION['id'];
$get_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM user WHERE id = '$user_id'"));

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CCS Faculty Loading System</title>


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="dist/css/website.min.css">
  <link rel="stylesheet" href="dist/css/doenotme.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!--link rel="stylesheet" href="sweetalert2/sweetalert2.css" type="text/css">
  <link rel="stylesheet" href="sweetalert2/sweetalert2.min.css" type="text/css"-->
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <?php echo display_error(); ?>
  <div class="wrapper">

    <div class="preloader flex-column justify-content-center align-items-center">
      <!--img class="animation__wobble" src="dist/img/websiteLogo.png" alt="websiteLogo" height="60" width="60"-->
      <i class="fa-4x fas fa-spinner fa-spin"></i>
    </div>

    <nav class="main-header navbar navbar-expand navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="../" class="nav-link">Home</a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <!--li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li-->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?logout=true" role="button">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="brand-link">
        <img src="dist/img/avatar.png" alt="web_logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="info brand-text"><?php echo $get_data['name'] ?></span>
      </div>
      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-bars"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="?page=faculty" class="nav-link <?php echo $faculty ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Faculty</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?page=subjects" class="nav-link <?php echo $subjects ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Subjects</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="?page=room" class="nav-link <?php echo $room ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rooms</p>
                  </a>
                </li>
                <!--li class="nav-item">
                  <a href="?page=lab" class="nav-link <?php echo $lab ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lab</p>
                  </a>
                </li-->
                <li class="nav-item">
                  <a href="?page=sem" class="nav-link <?php echo $sem ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Semester</p>
                  </a>
                </li>
                <!--li class="nav-item">
                  <a href="?page=class" class="nav-link <?php echo $class ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Class</p>
                  </a>
                </li-->
              </ul>
            </li>
            <!--li class="nav-item">
              <a href="pages/widgets.html" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Sub Menu 2
                  <span class="right badge badge-danger">New</span>
                </p>
              </a>
            </li-->
            <li class="nav-header">Sched Loading</li>
            <li class="nav-item">
              <a href="?page=class" class="nav-link <?php echo $class ?>">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>
                  Class
                  <!--span class="badge badge-info right">2</span-->
                </p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!--section page start----------------------------------------------------------------------->

    <?php include($pages) ?>

    <!--section page end----------------------------------------------------------------------->

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <footer class="main-footer">
      <strong>Copyright &copy; 2022 <a href="https://www.devsvr.tk/">website</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>
  </div>

  <!--script src="sweetalert2/sweetalert2.all.js"></script>
  <script src="sweetalert2/sweetalert2.all.min.js"></script>
  <script src="sweetalert2/sweetalert2.js"></script>
  <script src="sweetalert2/sweetalert2.min.js"></script-->
  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/website.js"></script>
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

  <!--script>
    $(document).on("click", ".edit_lab", function() {
      var lab_data = $(this).data('id');
      const data_array = lab_data.split(",");
      $(".modal-body #lab_no").val(data_array[0]);
      $(".modal-body #lab_building").val(data_array[1]);
      $(".modal-body #lab_id").val(data_array[2]);
    });
  </script-->

  <script>
    $(document).on("click", ".btn_update", function() {
      Swal.fire({
        title: 'Update Record?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update'
      }).then((result) => {
        //var btn_update_id = document.getElementById("btn_update_id").value;
        var fid = document.getElementById("id").value;
        var fname = document.getElementById("fname").value;
        var mname = document.getElementById("mname").value;
        var lname = document.getElementById("lname").value;
        var contact = document.getElementById("contact").value;
        var address = document.getElementById("address").value;
        //var data_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              fid: fid,
              fname: fname,
              mname: mname,
              lname: lname,
              contact: contact,
              address: address

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Record has been updated.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '300'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Update fail!'
                })
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error ' + res,
                  text: 'Please contact the admin.'
                })
              }
            }
          });
        }
      })
    });
  </script>

  <!--script>
    $(document).on("click", ".lab_update", function() {
      Swal.fire({
        title: 'Update Lab?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update'
      }).then((result) => {
        //var btn_update_id = document.getElementById("btn_update_id").value;
        var lab_no = document.getElementById("lab_no").value;
        var lab_building = document.getElementById("lab_building").value;
        var lab_id = document.getElementById("lab_id").value;
        //var data_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              lab_no:lab_no,
              lab_building: lab_building,
              lab_id:lab_id

            }, // passing the values
            success: function(res) {
              if(res == 1){
                Swal.fire({position: 'center',icon: 'success',text: 'Lab has been updated.',showConfirmButton: false,timer: 1000,width: '300'})
                setTimeout(function() {
                  location.reload();
                }, 1000);
              }else if(res == 2){
                Swal.fire({icon: 'error',title: 'Oops...',text: 'Empty Fields!'})
              }else{
                Swal.fire({icon: 'error',title: 'Error '+ res,text: 'Please contact the admin!'})
              }
            }
          });
        }
      })
    });
  </script-->
  <!--script>
    $(document).on("click", ".lab_add", function() {
      Swal.fire({
        title: 'Add Lab?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Add'
      }).then((result) => {
        //var btn_update_id = document.getElementById("btn_update_id").value;
        var lab_no_add = document.getElementById("lab_no_add").value;
        var lab_building_add = document.getElementById("lab_building_add").value;
        //var data_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              lab_no_add: lab_no_add,
              lab_building_add: lab_building_add

            }, // passing the values
            success: function(res) {
              if(res == 1){
                Swal.fire({position: 'center',icon: 'success',text: 'Lab has been added.',showConfirmButton: false,timer: 1000,width: '250'})
                setTimeout(function() {
                  location.reload();
                }, 1000);
              }else if(res == 2){
                Swal.fire({icon: 'error',title: 'Oops...',text: 'Lab No. already exist!'})
              }
              else if(res == 3){
                Swal.fire({icon: 'error',title: 'Oops...',text: 'Lab No. & Building is required!'})
              }else{
                Swal.fire({icon: 'error',title: 'Error '+ res,text: 'Please contact the admin!'})
              }
            }
          });
        }
      })
    });
  </script-->
  <!--script>
    $(document).on("click", ".lab_remove", function() {
      Swal.fire({
        title: 'Remove Lab?',
        text: "You won't be able to revert this!",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      }).then((result) => {
        //var data_id = document.getElementById("remove_id").value;
        var lab_remove = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              lab_remove: lab_remove
            }, // passing the values
            success: function(res) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                text: 'Lab has been deleted.',
                showConfirmButton: false,
                timer: 1000,
                width: '250'
              })
              setTimeout(function() {
                location.reload();
              }, 1000);
            }
          });
        }
      })
    });
  </script-->

  <!--This is for Faculty Javascript-----------------------------------------------------------------------START-->
  <script>
    $(document).on("click", ".edit_btn", function() {
      var faculty_data = $(this).data('id');
      const data_array = faculty_data.split(<?php echo $splittercode ?>);
      $(".modal-body #id").val(data_array[0]);
      $(".modal-body #fname").val(data_array[1]);
      $(".modal-body #mname").val(data_array[2]);
      $(".modal-body #lname").val(data_array[3]);
      $(".modal-body #contact").val(data_array[4]);
      $(".modal-body #address").val(data_array[5]);
      document.getElementById("id").style.borderColor = "#e83e8c";
      /*document.getElementById("edit_button").innerHTML = 'Update';
      document.getElementById("modal_title").innerHTML = 'Update Record';
      document.getElementById("id_add").style.borderColor = "#e83e8c";
      document.getElementById("faculty_label_id").style.color = "#e83e8c";
      document.getElementById("faculty_id_error").innerHTML = "";
      document.getElementById("fname_add").style.borderColor = "";
      document.getElementById("faculty_fname_error").innerHTML = "";
      document.getElementById("mname_add").style.borderColor = "";
      document.getElementById("faculty_mname_error").innerHTML = "";
      document.getElementById("lname_add").style.borderColor = "";
      document.getElementById("faculty_lname_error").innerHTML = "";*/
    });
  </script>
  <script>
    function faculty_sem_function() {
      var selected_faculty_sem = document.getElementById("selected_faculty_sem").value;
      //if (result.isConfirmed) {
      $.ajax({
        type: "POST", //type of method
        url: "functions/process.php", //your page
        data: {
          selected_faculty_sem: selected_faculty_sem

        }, // passing the values
        success: function(res) {
          if (res == 1) {
            location.reload();
          } else if (res == 2) {
            document.getElementById("selected_faculty_sem").style.borderColor = "red";
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
    $(document).on("click", ".btn_faculty_add", function() {
      Swal.fire({
        title: 'Add Record?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Add'
      }).then((result) => {
        //var btn_update_id = document.getElementById("btn_update_id").value;
        var fid_add = document.getElementById("id_add").value;
        var fname_add = document.getElementById("fname_add").value;
        var mname_add = document.getElementById("mname_add").value;
        var lname_add = document.getElementById("lname_add").value;
        var contact_add = document.getElementById("contact_add").value;
        var address_add = document.getElementById("address_add").value;
        //var data_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              fid_add: fid_add,
              fname_add: fname_add,
              mname_add: mname_add,
              lname_add: lname_add,
              contact_add: contact_add,
              address_add: address_add

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Record has been added.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '300'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                document.getElementById("id_add").style.borderColor = "#FA462D";
                document.getElementById("faculty_id_error").innerHTML = "This ID is already taken.";
              } else if (res == 3) {
                document.getElementById("id_add").style.borderColor = "#FA462D";
                document.getElementById("faculty_id_error").innerHTML = "ID is required!";
              } else if (res == 4) {
                document.getElementById("fname_add").style.borderColor = "#FA462D";
                document.getElementById("faculty_fname_error").innerHTML = "First name is required!";
              } else if (res == 5) {
                document.getElementById("mname_add").style.borderColor = "#FA462D";
                document.getElementById("faculty_mname_error").innerHTML = "Middle name is required!";
              } else if (res == 6) {
                document.getElementById("lname_add").style.borderColor = "#FA462D";
                document.getElementById("faculty_lname_error").innerHTML = "Last name is required!";
              } else if (res == 7) {
                document.getElementById("id_add").style.borderColor = "#FA462D";
                document.getElementById("faculty_id_error").innerHTML = "Only 5 Digits ID is allowed";
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
      })
    });
  </script>
  <script>
    $(document).on("click", ".btn_remove", function() {
      Swal.fire({
        title: 'Disable Faculty?',
        text: "You can Undo this on 'Disabled' tab",
        width: '350',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Disable'
      }).then((result) => {
        //var data_id = document.getElementById("remove_id").value;
        var data_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              data_id: data_id
            }, // passing the values
            success: function(res) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                text: 'Record has been disabled.',
                showConfirmButton: false,
                timer: 1000,
                width: '300'
              })
              setTimeout(function() {
                location.reload();
              }, 1000);
            }
          });
        }
      })
    });
  </script>
  <script>
    $(document).on("click", ".faculty_restore", function() {
      Swal.fire({
        title: 'Restore faculty?',
        text: "This will restore all faculty's data.",
        width: '350',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Restore'
      }).then((result) => {
        //var data_id = document.getElementById("remove_id").value;
        var restore_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              restore_id: restore_id
            }, // passing the values
            success: function(res) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                text: 'Record has been restored.',
                showConfirmButton: false,
                timer: 1000,
                width: '300'
              })
              setTimeout(function() {
                location.reload();
              }, 1000);
            }
          });
        }
      })
    });
  </script>
  <script>
    $(document).ready(function() {
      $(".form-group #selected_faculty_sem").val(<?php echo $faculty_selected_sem ?>);
    });
  </script>
  <!--This is for Faculty Javascript-----------------------------------------------------------------------END-->

  <!--This is for Subject Javascript-----------------------------------------------------------------------START-->
  <script>
    $(document).on("click", ".subject_add", function() {
      Swal.fire({
        title: 'Add Subject?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Add'
      }).then((result) => {
        //var btn_update_id = document.getElementById("btn_update_id").value;
        var cc_add = document.getElementById("cc_add").value;
        var desc_add = document.getElementById("desc_add").value;
        var units_add = document.getElementById("units_add").value;
        var offer_no_add = document.getElementById("offer_no_add").value;
        //var data_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              cc_add: cc_add,
              desc_add: desc_add,
              units_add: units_add,
              offer_no_add: offer_no_add

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Subject has been added.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '300'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                document.getElementById("cc_add").style.borderColor = "#FA462D";
                document.getElementById("subject_cc_error").innerHTML = "Course code already exist!";
              } else if (res == 3) {
                document.getElementById("offer_no_add").style.borderColor = "#FA462D";
                document.getElementById("subject_on_error").innerHTML = "Offer no. already exist!";
              } else if (res == 4) {
                document.getElementById("cc_add").style.borderColor = "#FA462D";
                document.getElementById("subject_cc_error").innerHTML = "Course code is empty";
              } else if (res == 5) {
                document.getElementById("offer_no_add").style.borderColor = "#FA462D";
                document.getElementById("subject_on_error").innerHTML = "Offer no. is empty";
              } else if (res == 6) {
                document.getElementById("desc_add").style.borderColor = "#FA462D";
                document.getElementById("subject_desc_error").innerHTML = "Description is empty";
              } else if (res == 7) {
                document.getElementById("units_add").style.borderColor = "#FA462D";
                document.getElementById("subject_units_error").innerHTML = "Unit should not be empty";
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
      })
    });
  </script>
  <script>
    $(document).on("click", ".subject_remove", function() {
      Swal.fire({
        title: 'Remove Subject?',
        text: "You won't be able to revert this!",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      }).then((result) => {
        //var data_id = document.getElementById("remove_id").value;
        var subject_remove = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              subject_remove: subject_remove
            }, // passing the values
            success: function(res) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                text: 'Subject has been deleted.',
                showConfirmButton: false,
                timer: 1000,
                width: '300'
              })
              setTimeout(function() {
                location.reload();
              }, 1000);
            }
          });
        }
      })
    });
  </script>
  <script>
    $(document).on("click", ".edit_btn_subject", function() {
      var faculty_data = $(this).data('id');
      const data_array = faculty_data.split(<?php echo $splittercode ?>);
      $(".modal-body #subject_id").val(data_array[0]);
      $(".modal-body #cc").val(data_array[1]);
      $(".modal-body #desc").val(data_array[2]);
      $(".modal-body #units").val(data_array[3]);
      $(".modal-body #offer_no").val(data_array[4]);
      //document.getElementById("offer_no").style.borderColor = "#e83e8c";
    });
  </script>
  <script>
    $(document).on("click", ".subject_update", function() {
      Swal.fire({
        title: 'Update Subject?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update'
      }).then((result) => {
        var subject_id = document.getElementById("subject_id").value;
        var cc = document.getElementById("cc").value;
        var offer_no = document.getElementById("offer_no").value;
        var desc = document.getElementById("desc").value;
        var units = document.getElementById("units").value;
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              subject_id: subject_id,
              cc: cc,
              desc: desc,
              units: units,
              offer_no: offer_no

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Subject has been updated.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '300'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                document.getElementById("cc").style.borderColor = "#FA462D";
                document.getElementById("subject_cc_edit_error").innerHTML = "Course code is empty";
              } else if (res == 3) {
                document.getElementById("desc").style.borderColor = "#FA462D";
                document.getElementById("subject_desc_edit_error").innerHTML = "Description is empty";
              } else if (res == 4) {
                document.getElementById("units").style.borderColor = "#FA462D";
                document.getElementById("subject_units_edit_error").innerHTML = "Unit should not be empty";
              } else if (res == 5) {
                document.getElementById("offer_no").style.borderColor = "#FA462D";
                document.getElementById("subject_on_edit_error").innerHTML = "Offer no. already exist!";
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
      })
    });
  </script>
  <!--This is for Subject Javascript-----------------------------------------------------------------------END-->

  <!--This is for Rooms Javascript-----------------------------------------------------------------------START-->
  <script>
    $(document).on("click", ".edit_room", function() {
      var room_data = $(this).data('id');
      const data_array = room_data.split(<?php echo $splittercode ?>);
      $(".modal-body #room_id").val(data_array[0]);
      $(".modal-body #room_no").val(data_array[1]);
      $(".modal-body #building").val(data_array[2]);
    });
  </script>
  <script>
    $(document).on("click", ".room_add", function() {
      Swal.fire({
        title: 'Add Room?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Add'
      }).then((result) => {
        //var btn_update_id = document.getElementById("btn_update_id").value;
        var room_no_add = document.getElementById("room_no_add").value;
        var building_add = document.getElementById("building_add").value;
        //var data_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              room_no_add: room_no_add,
              building_add: building_add

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Room has been added.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '300'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                document.getElementById("room_no_add").style.borderColor = "#FA462D";
                document.getElementById("room_no_error").innerHTML = "Room No. already exist!";
              } else if (res == 3) {
                document.getElementById("room_no_add").style.borderColor = "#FA462D";
                document.getElementById("room_no_error").innerHTML = "Room No. is empty!";
              } else if (res == 4) {
                document.getElementById("building_add").style.borderColor = "#FA462D";
                document.getElementById("room_building_error").innerHTML = "Description should not be empty!";
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
      })
    });
  </script>
  <script>
    $(document).on("click", ".room_update", function() {
      Swal.fire({
        title: 'Update Room?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update'
      }).then((result) => {
        var room_id = document.getElementById("room_id").value;
        var room_no = document.getElementById("room_no").value;
        var building = document.getElementById("building").value;
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              room_id: room_id,
              room_no: room_no,
              building: building

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Room has been updated.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '300'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                document.getElementById("room_no").style.borderColor = "#FA462D";
                document.getElementById("room_no_edit_error").innerHTML = "Room No. already exist!";
              } else if (res == 3) {
                document.getElementById("room_no").style.borderColor = "#FA462D";
                document.getElementById("room_no_edit_error").innerHTML = "Room No. is empty!";
              } else if (res == 4) {
                document.getElementById("building").style.borderColor = "#FA462D";
                document.getElementById("room_building_edit_error").innerHTML = "Description should not be empty!";
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
      })
    });
  </script>
  <script>
    $(document).on("click", ".room_remove", function() {
      Swal.fire({
        title: 'Remove Room?',
        text: "You won't be able to revert this!",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      }).then((result) => {
        //var data_id = document.getElementById("remove_id").value;
        var room_remove = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              room_remove: room_remove
            }, // passing the values
            success: function(res) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                text: 'Room has been deleted.',
                showConfirmButton: false,
                timer: 1000,
                width: '250'
              })
              setTimeout(function() {
                location.reload();
              }, 1000);
            }
          });
        }
      })
    });
  </script>
  <!--This is for Rooms Javascript-----------------------------------------------------------------------END-->

  <!--This is for Semester Javascript-----------------------------------------------------------------------START-->
  <script>
    $(document).on("click", ".edit_sem", function() {
      var sem_data = $(this).data('id');
      const data_array = sem_data.split(<?php echo $splittercode ?>);
      var sy_date = data_array[3];
      const date_split = sy_date.split("-");
      $(".modal-body #sem_id").val(data_array[0]);
      $(".modal-body #sem_no").val(data_array[1]);
      $(".modal-body #sem_desc").val(data_array[2]);
      $(".modal-body #sem_sy_from_update").val(date_split[0]);
      $(".modal-body #sem_sy_to_update").val(date_split[1]);
    });
  </script>
  <script>
    $(document).on("click", ".sem_add", function() {
      Swal.fire({
        title: 'Add Semester?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Add'
      }).then((result) => {
        var sem_no_add = document.getElementById("sem_no_add").value;
        var sem_sy_from = document.getElementById("sem_sy_from").value;
        var sem_sy_to = document.getElementById("sem_sy_to").value;
        //var data_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              sem_no_add: sem_no_add,
              sem_sy_from: sem_sy_from,
              sem_sy_to: sem_sy_to

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Semester has been added.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '250'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                document.getElementById("sem_no_add").style.borderColor = "red";
              } else if (res == 3) {
                document.getElementById("sem_sy_from1").style.borderColor = "red";
                document.getElementById("sem_sy_from").style.borderColor = "red";
              } else if (res == 4) {
                document.getElementById("sem_sy_to2").style.borderColor = "red";
                document.getElementById("sem_sy_to").style.borderColor = "red";
              } else if (res == 5) {
                document.getElementById("sem_no_add").style.borderColor = "red";
                document.getElementById("sem_sy_from1").style.borderColor = "red";
                document.getElementById("sem_sy_from").style.borderColor = "red";
                document.getElementById("sem_sy_to2").style.borderColor = "red";
                document.getElementById("sem_sy_to").style.borderColor = "red";
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
      })
    });
  </script>
  <script>
    $(document).on("click", ".sem_remove", function() {
      Swal.fire({
        title: 'Remove Sem?',
        text: "You won't be able to revert this!",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      }).then((result) => {
        //var data_id = document.getElementById("remove_id").value;
        var sem_remove = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              sem_remove: sem_remove
            }, // passing the values
            success: function(res) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                text: 'Semester has been deleted.',
                showConfirmButton: false,
                timer: 1000,
                width: '250'
              })
              setTimeout(function() {
                location.reload();
              }, 1000);
            }
          });
        }
      })
    });
  </script>
  <script>
    $(document).on("click", ".sem_update", function() {
      Swal.fire({
        title: 'Update Sem?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update'
      }).then((result) => {
        var sem_id = document.getElementById("sem_id").value;
        var sem_no = document.getElementById("sem_no").value;
        var sem_sy_from_update = document.getElementById("sem_sy_from_update").value;
        var sem_sy_to_update = document.getElementById("sem_sy_to_update").value;
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              sem_id: sem_id,
              sem_no: sem_no,
              sem_sy_from_update: sem_sy_from_update,
              sem_sy_to_update: sem_sy_to_update

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Semester has been updated.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '300'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                document.getElementById("sem_no").style.borderColor = "red";
              } else if (res == 3) {
                document.getElementById("sem_sy_from_update1").style.borderColor = "red";
                document.getElementById("sem_sy_from_update").style.borderColor = "red";
              } else if (res == 4) {
                document.getElementById("sem_sy_to_update2").style.borderColor = "red";
                document.getElementById("sem_sy_to_update").style.borderColor = "red";
              } else if (res == 5) {
                document.getElementById("sem_no").style.borderColor = "red";
                document.getElementById("sem_sy_from_update1").style.borderColor = "red";
                document.getElementById("sem_sy_from_update").style.borderColor = "red";
                document.getElementById("sem_sy_to_update2").style.borderColor = "red";
                document.getElementById("sem_sy_to_update").style.borderColor = "red";
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
      })
    });
  </script>
  <script>
    function loadFunction() {
      var x = document.getElementById("students").value;
      var input = document.getElementById('students');
      if (x == 0) {
        document.getElementById("typeof").innerHTML = '';
      } else if (x <= 9 && x >= 0) {
        document.getElementById("typeof").innerHTML = '(Packaged)';
        document.getElementById("typeof").style.color = "skyblue";
      } else if (x >= 10) {
        document.getElementById("typeof").innerHTML = '(Regular)';
        document.getElementById("typeof").style.color = "gold";
      }
      //document.getElementById("typeof").innerHTML = "(Rgular)";
      /*if(x == 1){
        document.getElementById("typeof").innerHTML = "(Package)";
      }else{
        document.getElementById("typeof").innerHTML = "(Rgular)";
      }*/
    }
  </script>
  <!--This is for Semester Javascript-----------------------------------------------------------------------END-->

  <!--This is for Class Javascript-----------------------------------------------------------------------START-->
  <script>
    function myFunction() {
      var selected_sem = document.getElementById("selected_sem").value;
      //if (result.isConfirmed) {
      $.ajax({
        type: "POST", //type of method
        url: "functions/process.php", //your page
        data: {
          selected_sem: selected_sem

        }, // passing the values
        success: function(res) {
          if (res == 1) {
            location.reload();
          } else if (res == 2) {
            document.getElementById("selected_sem").style.borderColor = "red";
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
    $(document).on("click", ".select_sem", function() {
      /*Swal.fire({
        title: 'Load Class?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Load'
      }).then((result) => {*/
      var selected_sem = document.getElementById("selected_sem").value;
      //if (result.isConfirmed) {
      $.ajax({
        type: "POST", //type of method
        url: "functions/process.php", //your page
        data: {
          selected_sem: selected_sem

        }, // passing the values
        success: function(res) {
          if (res == 1) {
            window.location.href = '?page=load_class';
          } else if (res == 2) {
            document.getElementById("selected_sem").style.borderColor = "red";
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error ' + res,
              text: 'Please contact the admin!'
            })
          }
        }
      });
      //}
      //})
    });
  </script>
  <script>
    $(document).on("click", ".class_remove", function() {
      Swal.fire({
        title: 'Remove Class?',
        text: "You won't be able to revert this!",
        width: '350',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Remove'
      }).then((result) => {
        //var data_id = document.getElementById("remove_id").value;
        var class_id = $(this).data('id');
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              class_id: class_id
            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Record has been deleted.' /* + res*/ ,
                  showConfirmButton: false,
                  timer: 1000,
                  width: '250'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else {
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  text: 'Record code' + res,
                  showConfirmButton: false,
                  timer: 1000,
                  width: '250'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              }
            }
          });
        }
      })
    });
  </script>
  <script>
    $(document).ready(function() {
      $(".form-group #selected_sem").val(<?php echo $the_selected_sem ?>);
    });
  </script>
  <script>
    $(document).on('blur', '.gio_data', function() {
      var dataTask = $(this).attr('id');
      var value = $(this).text();
      //alert(dataTask + ' - ' + value);
      $.ajax({
        type: "POST", //type of method
        url: "functions/process.php", //your page
        data: {
          dataTask: dataTask,
          value: value

        }, // passing the values
        success: function(res) {
          if (res == 1) {
            //
          } else if (res == 2) {
            //document.getElementByClassName("gio_data").style.color = "red";
            document.getElementById(dataTask).style.color = "red";
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
  <!--This is for Class Javascript-----------------------------------------------------------------------END-->

  <!--This is for Class Load Javascript-----------------------------------------------------------------------START-->
  <script>
    $(document).on("click", ".load_btn", function() {
      var load_data = $(this).data('id');
      const data_array = load_data.split(<?php echo $splittercode ?>);
      $(".modal-body #data_faculty_id").val(data_array[0]);
      $(".modal-body #data_faculty_name").val(data_array[1]);
      $(".modal-body #data_weekdays").val(data_array[2]);
      $(".modal-body #data_time_from").val(data_array[3]);
      $(".modal-body #data_time_to").val(data_array[4]);
      $(".modal-body #data_type").val(data_array[5]);
      $(".modal-body #row_id").val(data_array[6]);
      /*if (data_array[7] == 0) {
        document.getElementById("typeof").innerHTML = "";
        document.getElementById("typeof").style.color = "";
      } else if (data_array[7] >= 0 && data_array[7] <= 9) {
        document.getElementById("typeof").innerHTML = "(Packaged)";
        document.getElementById("typeof").style.color = "skyblue";
      } else if (data_array[7] >= 10) {
        document.getElementById("typeof").innerHTML = "(Regular)";
        document.getElementById("typeof").style.color = "gold";
      } else {
        document.getElementById("typeof").innerHTML = "";
        document.getElementById("typeof").style.color = "";
      }*/
      /*if (data_array[7] != 0) {
        $(".modal-body #students").val(data_array[7]);
        document.getElementById("students_label").style.color = "#e83e8c";
        document.getElementById("students").readOnly = true;
        document.getElementById("students").style.cursor = "no-drop";
      } else {
        $(".modal-body #students").val('');
        document.getElementById("students_label").style.color = "lightgreen";
        document.getElementById("students").readOnly = false;
        document.getElementById("students").style.cursor = "";
      }*/
      if (data_array[5] == 'Lab') {
        var display_view = 'Load Record (Laboratory)';
      } else {
        var display_view = 'Load Record (Lecture)';
      }
      document.getElementById("load_title").innerHTML = display_view;
    });
  </script>
  <script>
    $(document).on("click", ".add_class", function() {
      Swal.fire({
        title: 'Load Class?',
        text: "",
        width: '300',
        //icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Load'
      }).then((result) => {
        var class_faculty = document.getElementById("data_faculty_id").value;
        var class_subject = document.getElementById("class_subject").value;
        var class_room = document.getElementById("class_room").value;
        var class_day = document.getElementById("data_weekdays").value;
        var time_from = document.getElementById("data_time_from").value;
        var time_to = document.getElementById("data_time_to").value;
        var data_type = document.getElementById("data_type").value;
        var row_id = document.getElementById("row_id").value;
        if (result.isConfirmed) {
          $.ajax({
            type: "POST", //type of method
            url: "functions/process.php", //your page
            data: {
              class_faculty: class_faculty,
              class_subject: class_subject,
              class_room: class_room,
              class_day: class_day,
              time_from: time_from,
              time_to: time_to,
              data_type: data_type,
              row_id: row_id

            }, // passing the values
            success: function(res) {
              if (res == 1) {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  text: 'Semester has been added.',
                  showConfirmButton: false,
                  timer: 1000,
                  width: '300'
                })
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else if (res == 2) {
                document.getElementById("class_subject").style.borderColor = "red";
                document.getElementById("class_load_subject_error").innerHTML = "Select Subject First!";
              } else if (res == 3) {
                document.getElementById("class_room").style.borderColor = "red";
                document.getElementById("class_load_room_error").innerHTML = "Select Room First!";
              } else if (res == 4) {
                document.getElementById("class_room").style.borderColor = "red";
                document.getElementById("class_load_room_error").innerHTML = "Room is conflict!";
              } else if (res == 5) {
                document.getElementById("class_room").style.borderColor = "red";
                document.getElementById("class_load_room_error").innerHTML = "Room is conflict!";
                document.getElementById("data_time_from").style.borderColor = "red";
                document.getElementById("data_time_to").style.borderColor = "red";
                document.getElementById("time_from").innerHTML = "Conflict!";
                document.getElementById("time_to").innerHTML = "Conflict!";
              } else if (res == 6) {
                document.getElementById("typeof").innerHTML = " (Empty or 0)";
                document.getElementById("typeof").style.color = "#FA462D";
                document.getElementById("students").style.borderColor = "red";
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
      })
    });
  </script>
  <!--This is for Class Load Javascript-----------------------------------------------------------------------END-->
</body>

</html>