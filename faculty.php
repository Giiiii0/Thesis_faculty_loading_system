<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Faculty</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item active">Faculty</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!--section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Faculty</span>
              <span class="info-box-number">1,000</span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Subjects</span>
              <span class="info-box-number">1,000</span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-map-marker-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Rooms</span>
              <span class="info-box-number">1,000</span>
            </div>
          </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tasks"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Loaded</span>
              <span class="info-box-number">1,000</span>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Faculty List</h3>
          <button style="float: right;" type="button" class="btn_add btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Add Record</button>
        </div>
        <div class="card-body">
          //Table tag
        </div>
      </div>
    </div>
  </section-->

  <section class="content">
    <div class="container-fluid">
      <div class="">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Faculty</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Disabled</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="card">
                  <div class="card-header">
                    <div style="float: right; padding-left: 20px;" class="form-group">
                      <!--label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lecture Day</code></label-->
                      <select id="selected_faculty_sem" class="custom-select" onchange="faculty_sem_function()">
                        <option value="none">Select Semester</option>
                        <?php
                        while ($sem_class_row = mysqli_fetch_assoc($get_sem)) {
                        ?>
                          <option value="<?php echo $sem_class_row['Sem_id'] ?>"><?php echo $sem_class_row['Sem_description'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <button style="float: right;" type="button" class="btn_add btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Add Record</button>
                  </div>
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th style="width:10%">ID NO.</th>
                          <th>First Name</th>
                          <th>Middle Name</th>
                          <th>Last Name</th>
                          <th>Phone</th>
                          <th>Address</th>
                          <th>Units</th>
                          <th style="width:10%;">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        while ($faculty_row = mysqli_fetch_assoc($get_faculty)) {
                          $faculty_id = $faculty_row['Faculty_id'];

                          $fetchTotalUnits = mysqli_fetch_assoc($web_con->query("SELECT SUM(unit_lec) as totalUnits FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0'"));

                          /*if ($faculty_selected_sem == 'none') {
                            $sum_unit_lec = mysqli_fetch_assoc($web_con->query("SELECT sum(unit_lec) as sum_unit_lec FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0'"));
                            $sum_unit_lab = mysqli_fetch_assoc($web_con->query("SELECT sum(unit_lab) as sum_unit_lab FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0'"));
                            //$subject_id_count = $get_subject_ID['counted_data'];
                            $unit_lab = $sum_unit_lab['sum_unit_lab'];
                            $unit_lec = $sum_unit_lec['sum_unit_lec'];

                            $unit_sum = $unit_lab + $unit_lec;
                          } else {
                            $sum_unit_lec = mysqli_fetch_assoc($web_con->query("SELECT sum(unit_lec) as sum_unit_lec FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0' AND sem_id = '$faculty_selected_sem'"));
                            $sum_unit_lab = mysqli_fetch_assoc($web_con->query("SELECT sum(unit_lab) as sum_unit_lab FROM class WHERE Faculty_id = '$faculty_id' AND Subject_id != '0' AND sem_id = '$faculty_selected_sem'"));
                            //$subject_id_count = $get_subject_ID['counted_data'];
                            $unit_lab = $sum_unit_lab['sum_unit_lab'];
                            $unit_lec = $sum_unit_lec['sum_unit_lec'];

                            $unit_sum = $unit_lab + $unit_lec;
                          }*/
                        ?>

                          <tr>
                            <td class="row-data"><?php echo $faculty_row['Faculty_id'] ?></td>
                            <td><?php echo $faculty_row['FirstName'] ?></td>
                            <td><?php echo $faculty_row['MiddleInitial'] ?></td>
                            <td><?php echo $faculty_row['LastName'] ?></td>
                            <td><?php echo $faculty_row['PhoneNum'] ?></td>
                            <td><?php echo $faculty_row['address'] ?></td>
                            <td style="text-align:center;"><?php echo $fetchTotalUnits['totalUnits'] ?></td>
                            <td>
                              <div class="btn-group">
                                <button type="button" data-id="<?php echo $faculty_row['Faculty_id'] ?><?php echo $splittercode ?><?php echo $faculty_row['FirstName'] ?><?php echo $splittercode ?><?php echo $faculty_row['MiddleInitial'] ?><?php echo $splittercode ?><?php echo $faculty_row['LastName'] ?><?php echo $splittercode ?><?php echo $faculty_row['PhoneNum'] ?><?php echo $splittercode ?><?php echo $faculty_row['address'] ?>" class="edit_btn btn btn-success" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pen" aria-hidden="true"></i></button>
                                <button type="button" id="remove" data-id="<?php echo $faculty_row['Faculty_id'] ?>" class="btn_remove btn btn-danger"><i class="fas fa-user-alt-slash"></i></button>
                              </div>
                            </td>

                          </tr>

                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <div class="card">
                  <div class="card-header">
                    <!--button style="float: right;" type="button" class="btn_add btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Add Record</button-->
                  </div>
                  <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th style="width:10%">ID NO.</th>
                          <th>First Name</th>
                          <th>Middle Name</th>
                          <th>Last Name</th>
                          <th>Phone</th>
                          <th>Address</th>
                          <th style="width:10%;">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        while ($faculty_removed_row = mysqli_fetch_assoc($get_removed_faculty)) {

                        ?>

                          <tr>
                            <td class="row-data"><?php echo $faculty_removed_row['Faculty_id'] ?></td>
                            <td><?php echo $faculty_removed_row['FirstName'] ?></td>
                            <td><?php echo $faculty_removed_row['MiddleInitial'] ?></td>
                            <td><?php echo $faculty_removed_row['LastName'] ?></td>
                            <td><?php echo $faculty_removed_row['PhoneNum'] ?></td>
                            <td><?php echo $faculty_removed_row['address'] ?></td>
                            <td>
                              <div class="btn-group">
                                <button type="button" data-id="<?php echo $faculty_removed_row['Faculty_id'] ?>" class="faculty_restore btn btn-success"><i class="fa fa-undo" aria-hidden="true"></i></button>
                                <!--button type="button" data-id="" class="btn_remove btn btn-default" disabled><i class="fa fa-trash" aria-hidden="true"></i></button-->
                              </div>
                            </td>

                          </tr>

                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="modal-add">
  <div class="modal-dialog modal-edit">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modal_title" class="modal-title">Add Record</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputBorder"><code id="faculty_label_id" style="color:lightgreen; font-size: 20px;">Faculty ID</code></label><b id="faculty_id_error" style="float: right;color: #FA462D;"></b>
          <input id="id_add" type="number" class="form-control form-control-border border-width-2" placeholder="Faculty ID">
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">First Name</code></label><b id="faculty_fname_error" style="float: right;color: #FA462D;"></b>
          <input id="fname_add" type="text" class="form-control form-control-border border-width-2" placeholder="First Name">
        </div>
        <div class="form-group">
          <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Middle Name</code></label><b id="faculty_mname_error" style="float: right;color: #FA462D;"></b>
          <input id="mname_add" type="text" class="form-control form-control-border border-width-2" placeholder="Middle Name">
        </div>
        <div class="form-group">
          <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Last Name</code></label><b id="faculty_lname_error" style="float: right;color: #FA462D;"></b>
          <input id="lname_add" type="text" class="form-control form-control-border border-width-2" placeholder="Last Name">
        </div>
        <div class="form-group">
          <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Contact</code></label>
          <input id="contact_add" type="text" class="form-control form-control-border border-width-2" placeholder="Contact">
        </div>
        <div class="form-group">
          <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Address</code></label>
          <input id="address_add" type="text" class="form-control form-control-border border-width-2" placeholder="Address">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button id="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="edit_button" type="button" class="btn_faculty_add btn btn-primary">Add</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-edit">
  <div class="modal-dialog modal-edit">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Record</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputBorder"><code style="font-size: 20px;">Faculty ID</code></label>
          <input name="id" type="text" class="form-control form-control-border border-width-2" id="id" placeholder="Faculty ID" style="cursor: no-drop;" readonly>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">First Name</code></label>
          <input name="fname" type="text" class="form-control form-control-border border-width-2" id="fname" placeholder="First Name">
        </div>
        <div class="form-group">
          <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Middle Name</code></label>
          <input name="mname" type="text" class="form-control form-control-border border-width-2" id="mname" placeholder="Middle Name">
        </div>
        <div class="form-group">
          <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Last Name</code></label>
          <input name="lname" type="text" class="form-control form-control-border border-width-2" id="lname" placeholder="Last Name">
        </div>
        <div class="form-group">
          <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Contact</code></label>
          <input name="contact" type="text" class="form-control form-control-border border-width-2" id="contact" placeholder="Contact">
        </div>
        <div class="form-group">
          <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Address</code></label>
          <input name="address" type="text" class="form-control form-control-border border-width-2" id="address" placeholder="Address">
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="update" id="btn_update_id" class="btn_update btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>