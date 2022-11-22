<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Semester</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item active">Semester</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Semester</h3>
          <button style="float: right;" type="button" class="add_sem btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Add Record</button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Sem ID</th>
                <th>Semester</th>
                <th>Description</th>
                <th>School Year</th>
                <th style="width:10%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($sem_row = mysqli_fetch_assoc($get_sem)) {

                switch ($sem_row['Sem_no']) {
                  case '1':
                    $sem_disp = '1st Sem';
                    break;
                  case '2':
                    $sem_disp = '2nd Sem';
                    break;
                  case '3':
                    $sem_disp = 'Summer';
                    break;
                  default:
                    $sem_disp = 'Error';
                    break;
                }

              ?>

                <tr>
                  <td><?php echo $sem_row['Sem_id'] ?></td>
                  <td><?php echo $sem_disp ?></td>
                  <td><?php echo $sem_row['Sem_description'] ?></td>
                  <td><?php echo $sem_row['School_year'] ?></td>
                  <td>
                    <div class="btn-group">
                      <button type="button" data-id="<?php echo $sem_row['Sem_id'] ?><?php echo $splittercode?><?php echo $sem_row['Sem_no'] ?><?php echo $splittercode?><?php echo $sem_row['Sem_description'] ?><?php echo $splittercode?><?php echo $sem_row['School_year'] ?>" class="edit_sem btn btn-success" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pen" aria-hidden="true"></i></button>
                      <!--button type="button" id="sem_remove" data-id="" class="sem_remove btn btn-default" disabled><i class="fa fa-trash" aria-hidden="true"></i></button-->
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
          <label for="exampleInputBorder"><code style="font-size: 20px;">Sem ID.</code></label>
          <input id="sem_id" type="number" class="form-control form-control-border border-width-2" placeholder="Sem ID." style="cursor: no-drop;" readonly>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Semester</code></label>
          <select id="sem_no" class="custom-select">
            <option value="none">Select Semester</option>
            <option value="1">1st Semester</option>
            <option value="2">2nd Semester</option>
            <option value="3">Summer</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">School Year</code></label>
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button id="sem_sy_from_update1" type="button" class="btn btn-info">From</button>
                </div>
                <input id="sem_sy_from_update" type="number" class="form-control">
              </div>
            </div>
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button id="sem_sy_to_update2" type="button" class="btn btn-info">To</button>
                </div>
                <input id="sem_sy_to_update" type="number" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="sem_update" class="sem_update btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-add">
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
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Semester</code></label>
          <select id="sem_no_add" class="custom-select">
            <option value="none">Select Semester</option>
            <option value="1">1st Semester</option>
            <option value="2">2nd Semester</option>
            <option value="3">Summer</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">School Year</code></label>
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button id="sem_sy_from1" type="button" class="btn btn-info" disabled>From</button>
                </div>
                <input id="sem_sy_from" type="number" class="form-control">
              </div>
            </div>
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <button id="sem_sy_to2" type="button" class="btn btn-info" disabled>To</button>
                </div>
                <input id="sem_sy_to" type="number" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="sem_add" class="sem_add btn btn-primary">Add</button>
      </div>
    </div>
  </div>
</div>