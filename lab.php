<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Lab</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item active">Lab</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Laboratory</h3>
          <button style="float: right;" type="button" class="add_lab btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Add Record</button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Lab No.</th>
                <th>Building</th>
                <th style="width:10%;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($lab_row = mysqli_fetch_assoc($get_lab)) {

              ?>

                <tr>
                  <td><?php echo $lab_row['Lab_no'] ?></td>
                  <td><?php echo $lab_row['Building'] ?></td>
                  <td>
                    <div class="btn-group">
                      <button type="button" data-id="<?php echo $lab_row['Lab_no'] ?>,<?php echo $lab_row['Building'] ?>,<?php echo $lab_row['id'] ?>" class="edit_lab btn btn-success" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pen" aria-hidden="true"></i></button>
                      <button type="button" id="lab_remove" data-id="<?php echo $lab_row['Lab_no'] ?>" class="lab_remove btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lab No.</code></label>
          <input name="lab_id" type="number" class="form-control form-control-border border-width-2" id="lab_id" placeholder="Lab ID" style="cursor: no-drop;" hidden>
          <input name="lab_no" type="text" class="form-control form-control-border border-width-2" id="lab_no" placeholder="Lab No.">
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Building</code></label>
          <input name="lab_building" type="text" class="form-control form-control-border border-width-2" id="lab_building" placeholder="Building">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="lab_update" class="lab_update btn btn-primary">Update</button>
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
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Lab No.</code></label>
          <input name="lab_no_add" type="text" class="form-control form-control-border border-width-2" id="lab_no_add" placeholder="Lab No.">
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Building</code></label>
          <input name="lab_building_add" type="text" class="form-control form-control-border border-width-2" id="lab_building_add" placeholder="Building">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="lab_add" class="lab_add btn btn-primary">Add</button>
      </div>
    </div>
  </div>
</div>