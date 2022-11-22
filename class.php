<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Class</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item active">Class</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Class</h3>
          <div style="float: right; padding-left: 5px;" class="form-group">
            <!--label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lecture Day</code></label-->
            <select id="selected_sem" class="custom-select" onchange="myFunction()">
              <option value="none">Select Semester</option>
              <?php
              while ($sem_class_row = mysqli_fetch_assoc($get_sem)) {
              ?>
                <option value="<?php echo $sem_class_row['Sem_id'] ?>"><?php echo $sem_class_row['Sem_description'] ?></option>
              <?php } ?>
            </select>
          </div>
          <!--a href="?page=load_class"--> <button style="float: right;" type="button" class="select_sem btn btn-success"><i class="fas fa-plus-circle"></i> Load Class</button>
          <!--/a-->
          <!--button style="float: right;" type="button" class="add_sched btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Load Class</button-->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Offer No</th>
                <th>Course Code</th>
                <th>Description</th>
                <th>Faculty Name</th>
                <th>Lecture</th>
                <th>Lec Time</th>
                <th>Lab</th>
                <th>Lab Time</th>
                <th>Students</th>
                <th>Semester</th>
                <th style="width:10%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($class_row = mysqli_fetch_assoc($get_class)) {
                $subject_id = $class_row['Subject_id'];
                $faculty_id = $class_row['Faculty_id'];
                $room_id = $class_row['Room_id'];
                $lab_id = $class_row['Lab_id'];
                $sem_id = $class_row['sem_id'];

                if ($class_row['Lec_start'] == '00:00:00') {
                  $lec_time_start = 'none';
                } else {
                  $lec_time_start = date('h:i A', strtotime($class_row['Lec_start']));
                }

                if ($lec_end = $class_row['Lec_end'] == '00:00:00') {
                  $lec_time_end = 'none';
                } else {
                  $lec_time_end = date('h:i A', strtotime($class_row['Lec_end']));
                }

                if ($lab_start =  $class_row['Lab_start'] == '00:00:00') {
                  $lab_time_start = 'none';
                } else {
                  $lab_time_start = date('h:i A', strtotime($class_row['Lab_start']));
                }

                if ($lab_end = $class_row['Lab_end'] == '00:00:00') {
                  $lab_time_end = 'none';
                } else {
                  $lab_time_end = date('h:i A', strtotime($class_row['Lab_end']));
                }

                if ($subject_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM subject WHERE id  = '$subject_id'"))) {
                  $offer_no = $subject_data['offer_no'];
                  $course_no = $subject_data['Course_code'];
                  $desc = $subject_data['Description'];
                } else {
                  $offer_no = 'none';
                  $course_no = 'none';
                  $desc = 'none';
                }

                if ($faculty_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM faculty WHERE Faculty_id  = '$faculty_id'"))) {
                  $faculty_fname = $faculty_data['FirstName'];
                  $faculty_mname = $faculty_data['MiddleInitial'];
                  $faculty_lname = $faculty_data['LastName'];
                  $MI = substr($faculty_mname, 0, 1);

                  $faculty_display_name = $faculty_lname . ', ' . $faculty_fname . ' ' . $MI . '.';
                } else {
                  $faculty_display_name = 'none';
                }

                if ($room_lec_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM room WHERE id  = '$room_id'"))) {
                  $room_lec_id = $room_lec_data['Room_no'];
                  $room_lec_display = $room_lec_id . ' / ' . $class_row['Lec_day'];
                } else {
                  $room_lec_display = 'none';
                }

                if ($room_lab_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM room WHERE id  = '$lab_id'"))) {
                  $room_lab_id = $room_lab_data['Room_no'];
                  $room_lab_display = $room_lab_id . ' / ' . $class_row['Lab_day'];
                } else {
                  $room_lab_display = 'none';
                }

                if ($sem_data = mysqli_fetch_assoc($web_con->query("SELECT * FROM semester WHERE Sem_id = '$sem_id'"))) {
                  $sem_no = $sem_data['Sem_no'];
                  $school_year = $sem_data['School_year'];

                  switch ($sem_no) {
                    case '1':
                      $sem_format = '1st Semester';
                      break;
                    case '2':
                      $sem_format = '2nd Semester';
                      break;
                    case '3':
                      $sem_format = 'SUMMER';
                      break;
                    default:
                      $sem_format = 'none';
                  }

                  $final_sem_display = $sem_format . ' - ' . $school_year;
                } else {
                  $final_sem_display = 'none';
                }

                /*if ($class_row['students_count'] >= 0 && $class_row['students_count'] <= 9) {
                  $students_type = 'Packaged';
                  $students_count = $class_row['students_count'];
                } else if ($class_row['students_count'] >= 10) {
                  $students_type = 'Regular';
                  $students_count = $class_row['students_count'];
                } else {
                  $students_type = 'none';
                  $students_count = 'none';
                }

                $type = $students_count . ' (' . $students_type . ')';*/

              ?>

                <tr>
                  <td><?php echo $offer_no ?></td>
                  <td><?php echo $course_no ?></td>
                  <td><?php echo $desc ?></td>
                  <td><?php echo $faculty_display_name ?></td>
                  <td><?php echo $room_lec_display ?></td>
                  <td><?php echo $lec_time_start ?> - <?php echo $lec_time_end ?></td>
                  <td><?php echo $room_lab_display ?></td>
                  <td><?php echo $lab_time_start ?> - <?php echo $lab_time_end ?></td>
                  <td id="<?php echo $class_row["id"]; ?>" style="text-align:center;" class="gio_data" contenteditable=true><?php echo $class_row['students_count'] ?></td>
                  <td><?php echo $final_sem_display ?></td>
                  <td>
                    <div class="btn-group">
                      <!--button type="button" data-id="" class="load_btn btn btn-success" disabled><i class="fas fa-pen" aria-hidden="true"></i></button-->
                      <button type="button" data-id="<?php echo $class_row['id'] ?>" class="class_remove btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      <a href="/print/?print=<?php echo $class_row['Faculty_id'] ?>&val=<?php echo $class_row['students_count'] ?>" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i></a>
                    </div>
                  </td>

                </tr>

              <?php } ?>
            </tbody>
            <!--tfoot>
                  <tr>
                    <th>ID NO.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>M.I</th>
                    <th>Phone</th>
                  </tr>
                </tfoot-->
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </section>
</div>

<!--div class="modal fade" id="modal-add">
  <div class="modal-dialog modal-edit">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Record</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Faculty</code></label>
          <select id="class_faculty" class="custom-select">
            <?php
            while ($faculty_class_row = mysqli_fetch_assoc($get_faculty)) {

              $faculty_name = $faculty_class_row['FirstName'] . ' ' . $faculty_class_row['MiddleInitial'] . ' ' . $faculty_class_row['LastName'];

            ?>
              <option value="<?php echo $faculty_class_row['Faculty_id'] ?>"><?php echo $faculty_name ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Subject</code></label>
          <select id="class_subject" class="custom-select">
            <?php
            while ($subjects_class_row = mysqli_fetch_assoc($get_subjects)) {

              $subject_name = '(' . $subjects_class_row['Course_code'] . ') ' . $subjects_class_row['Description'];

            ?>
              <option value="<?php echo $subjects_class_row['id'] ?>"><?php echo $subject_name ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Room</code></label>
          <select id="class_room" class="custom-select">
            <option value="none">None</option>
            <?php
            while ($room_class_row = mysqli_fetch_assoc($get_room_lab)) {

              $room_data = '(' . $room_class_row['Room_no'] . ') ' . $room_class_row['building'];

            ?>
              <option value="<?php echo $room_class_row['id'] ?>"><?php echo $room_data ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lecture Day</code></label>
          <select id="class_lec_day" class="custom-select">
            <option value="none">None</option>
            <option value="MTH">MTH</option>
            <option value="WED">WED</option>
            <option value="TF">TF</option>
            <option value="SAT">SAT</option>
            <option value="SUN">SUN</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lecture Time</code></label>
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button id="lec_time_from1" type="button" class="btn btn-info">From</button>
                </div>
                <input id="lec_time_from" type="time" class="form-control">
              </div>
            </div>
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button id="lec_time_to1" type="button" class="btn btn-info">To</button>
                </div>
                <input id="lec_time_to" type="time" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lab</code></label>
          <select id="class_lab" class="custom-select">
            <option value="none">None</option>
            <?php
            while ($lab_class_row = mysqli_fetch_assoc($get_room)) {

              $lab_data = '(' . $lab_class_row['Room_no'] . ') ' . $lab_class_row['building'];

            ?>
              <option value="<?php echo $lab_class_row['id'] ?>"><?php echo $lab_data ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lab Day</code></label>
          
            <select id="class_lab_day" class="custom-select">
              <option value="none">None</option>
              <option value="MTH">MTH</option>
              <option value="WED">WED</option>
              <option value="TF">TF</option>
              <option value="SAT">SAT</option>
              <option value="SUN">SUN</option>
            </select>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lab Time</code></label>
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button type="button" class="btn btn-info">From</button>
                </div>
                <input id="lab_time_from" type="time" class="form-control">
              </div>
            </div>
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button type="button" class="btn btn-info">To</button>
                </div>
                <input id="lab_time_to" type="time" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">School Year</code></label>
          <select id="sem_sy_add" class="custom-select">
            <?php
            while ($sem_class_row = mysqli_fetch_assoc($get_sem)) {

              switch ($sem_class_row['Sem_no']) {
                case '1':
                  $value = '1st SEM';
                  break;
                case '2':
                  $value = '2st SEM';
                  break;
                case '3':
                  $value = 'SUMMER';
                  break;
              }

              $final_value = 'SY ' . $sem_class_row['School_year'] . ' ' . $value;

            ?>
              <option value="<?php echo $sem_class_row['Sem_id'] ?>"><?php echo $final_value ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="add_class" class="add_class btn btn-primary">Load Class</button>
      </div>
    </div>
  </div>
</div-->