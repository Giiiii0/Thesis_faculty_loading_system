<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Class Loading</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item active">Class</li>
            <li class="breadcrumb-item active">Load</li>
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
          <!--button style="float: right;" type="button" class="add_sched btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Load Class</button-->
          <button style="float: right;" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fa fa-check" aria-hidden="true"></i> Check</button>
        </div>
        <!-- /.card-header -->
        <div id="reloadable" class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Faculty ID</th>
                <th>Faculty Name</th>
                <th>Week Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Clas Type</th>
                <th style="width:10%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($get_the_data_row = mysqli_fetch_assoc($all_data)) {
                $the_faculty_id = $get_the_data_row['faculty_id'];
                $class_id = $get_the_data_row['class_id'];
                $day = $get_the_data_row['days'];
                $get_faculty_name = mysqli_fetch_assoc($web_con->query("SELECT * FROM faculty WHERE Faculty_id = '$the_faculty_id'"));
                $faculty_full_name = $get_faculty_name['FirstName'] . ' ' . $get_faculty_name['MiddleInitial'] . ' ' . $get_faculty_name['LastName'];

                if ($get_the_data_row['type'] == 'Lec') {
                  $class_type = 'Lecture';
                } else {
                  $class_type = 'Laboratory';
                }
              ?>
                <tr>

                  <td><?php echo $get_the_data_row['faculty_id'] ?></td>
                  <td><?php echo $faculty_full_name ?></td>
                  <td><?php echo $get_the_data_row['days'] ?></td>
                  <td><?php echo date('h:i a', strtotime($get_the_data_row['input_start'])) ?></td>
                  <td><?php echo date('h:i a', strtotime($get_the_data_row['input_end'])) ?></td>
                  <td><?php echo $class_type ?></td>
                  <td>
                    <div class="btn-group">
                      <button type="button" data-id="<?php echo $get_the_data_row['faculty_id'] ?><?php echo $splittercode ?><?php echo $faculty_full_name ?><?php echo $splittercode ?><?php echo $get_the_data_row['days'] ?><?php echo $splittercode ?><?php echo $get_the_data_row['input_start'] ?><?php echo $splittercode ?><?php echo $get_the_data_row['input_end'] ?><?php echo $splittercode ?><?php echo $get_the_data_row['type'] ?><?php echo $splittercode ?><?php echo $get_the_data_row['id'] ?>" class="load_btn btn btn-success" data-toggle="modal" data-target="#modal-load"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                      <!--button type="button" id="remove" data-id="" class="btn_remove btn btn-danger" disabled><i class="fa fa-trash" aria-hidden="true"></i></button-->
                    </div>
                  </td>
                <?php } ?>
                </tr>

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

<div class="modal fade" id="modal-add">
  <div class="modal-dialog modal-edit">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Check Record</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-6">
                <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Week Days</code></label>
                <select name="week_days" id="week_days" class="custom-select">
                  <option value="none">None</option>
                  <option value="MTH">MTH</option>
                  <option value="WED">WED</option>
                  <option value="TF">TF</option>
                  <option value="SAT">SAT</option>
                  <option value="SUN">SUN</option>
                </select>
              </div>
              <div class="col-6">
                <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Class Type</code></label>
                <select name="class_type" id="class_type" class="custom-select">
                  <option value="none">None</option>
                  <option value="Lec">Lecture</option>
                  <option value="Lab">Laboratory</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Schedule Time</code></label>
            <div class="row">
              <div class="col-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <button style="cursor: context-menu;" id="lec_time_from1" type="button" class="btn btn-info" disabled>From</button>
                  </div>
                  <input name="start_time" id="start_time" type="time" class="form-control">
                </div>
              </div>
              <div class="col-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <button style="cursor: context-menu;" id="lec_time_to1" type="button" class="btn btn-info" disabled>To</button>
                  </div>
                  <input name="end_time" id="end_time" type="time" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button name="load_sched" type="submit" id="load_sched" class="load_sched btn btn-primary">Load</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-load">
  <div class="modal-dialog modal-edit">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="load_title" class="modal-title">Load Record</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputBorder"><code style="font-size: 20px;">Faculty Name</code></label>
          <input name="data_faculty_id" id="data_faculty_id" type="hidden" class="form-control form-control-border border-width-2" placeholder="Faculty ID" style="cursor: no-drop;" readonly>
          <input name="data_type" id="data_type" type="hidden" class="form-control form-control-border border-width-2" placeholder="Data Type" style="cursor: no-drop;" readonly>
          <input name="row_id" id="row_id" type="hidden" class="form-control form-control-border border-width-2" placeholder="Row ID" style="cursor: no-drop;" readonly>
          <input name="data_faculty_name" id="data_faculty_name" type="text" class="form-control form-control-border border-width-2" placeholder="Faculty Name" style="cursor: no-drop;" readonly>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Subject</code></label><b id="class_load_subject_error" style="float: right;color: #FA462D;"></b>
          <select id="class_subject" class="custom-select">
            <option value="none">Select Subject</option>
            <?php
            while ($subjects_class_row = mysqli_fetch_assoc($get_subjects)) {

              $subject_name = '(' . $subjects_class_row['Course_code'] . ') ' . $subjects_class_row['Description'];

            ?>
              <option value="<?php echo $subjects_class_row['id'] ?>"><?php echo $subject_name ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <!--label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lecture Time</code></label-->
          <div class="row">
            <!--div class="col-6">
              <label for="exampleInputBorder"><code id="students_label" style="color:lightgreen; font-size: 20px;">Students<span id="typeof" style="font-size: 15px;"></span></code></label>
              <input id="students" onkeyup="loadFunction()" name="students" type="number" class="form-control form-control-border border-width-2" placeholder="Student Count">
            </div-->
            <div class="col-3">
              <label for="exampleInputBorder"><code style="font-size: 20px;">Week </code></label>
              <input name="data_weekdays" id="data_weekdays" type="text" class="form-control form-control-border border-width-2" placeholder="Faculty Name" style="cursor: no-drop;" readonly>
            </div>
            <div class="col-9">
              <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Room</code></label><b id="class_load_room_error" style="float: right;color: #FA462D;"></b>
              <select id="class_room" class="custom-select">
                <option value="none">Select Room</option>
                <?php
                while ($room_class_row = mysqli_fetch_assoc($get_room_lab)) {

                  $room_data = '(' . $room_class_row['Room_no'] . ') ' . $room_class_row['building'];

                ?>
                  <option value="<?php echo $room_class_row['id'] ?>"><?php echo $room_data ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-6">
              <label for="exampleInputBorder"><code style="font-size: 20px;">Start Time</code></label><b id="time_from" style="float: right;color: #FA462D;"></b>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button id="lec_time_from1" type="button" class="btn btn-info" disabled>From</button>
                </div>
                <input id="data_time_from" type="time" class="form-control" style="cursor: no-drop;" readonly>
              </div>
            </div>
            <div class="col-6">
              <label for="exampleInputBorder"><code style="font-size: 20px;">End Time</code></label><b id="time_to" style="float: right;color: #FA462D;"></b>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button id="lec_time_to1" type="button" class="btn btn-info" disabled>To</button>
                </div>
                <input id="data_time_to" type="time" class="form-control" style="cursor: no-drop;" readonly>
              </div>
            </div>
          </div>
        </div>
        <!--div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">School Year</code></label>
          <select id="sem_sy_add" class="custom-select">
          <option value="none">Select Semester</option>
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
        </div-->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="add_class" class="add_class btn btn-primary">Load Class</button>
      </div>
    </div>
  </div>
</div>