<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Subjects</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item active">Subjects</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Subject List</h3>
          <button style="float: right;" type="button" class="btn_add btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Add Record</button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Offer No.</th>
                <th>Course Code</th>
                <th>Description</th>
                <th>Units</th>
                <th style="width:10%;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($subjects_row = mysqli_fetch_assoc($get_subjects)) {

              ?>

                <tr>
                  <td><?php echo $subjects_row['offer_no'] ?></td>
                  <td><?php echo $subjects_row['Course_code'] ?></td>
                  <td><?php echo $subjects_row['Description'] ?></td>
                  <td><?php echo $subjects_row['units'] ?></td>
                  <td>
                    <div class="btn-group">
                      <button type="button" data-id="<?php echo $subjects_row['id'] ?><?php echo $splittercode?><?php echo $subjects_row['Course_code'] ?><?php echo $splittercode?><?php echo $subjects_row['Description'] ?><?php echo $splittercode?><?php echo $subjects_row['units'] ?><?php echo $splittercode?><?php echo $subjects_row['offer_no'] ?>" class="edit_btn_subject btn btn-success" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pen" aria-hidden="true"></i></button>
                      <!--button type="button" id="subject_remove" data-id="<?php echo $subjects_row['id'] ?>" class="subject_remove btn btn-default" disabled><i class="fa fa-trash" aria-hidden="true"></i></button-->
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
      <!--form method="POST"-->
        <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Offer No.</code></label><b id="subject_on_edit_error" style="float: right;color: #FA462D;"></b>
            <!--input name="offer_no" type="number" class="form-control form-control-border border-width-2" id="offer_no" placeholder="Offer No." style="cursor: no-drop;" readonly-->
            <input name="offer_no" type="number" class="form-control form-control-border border-width-2" id="offer_no" placeholder="Offer No.">
          </div>
          <div class="form-group">
            <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Course Code</code></label><b id="subject_cc_edit_error" style="float: right;color: #FA462D;"></b>
            <input name="subject_id" type="number" class="form-control form-control-border border-width-2" id="subject_id" placeholder="id" hidden>
            <input name="cc" type="text" class="form-control form-control-border border-width-2" id="cc" placeholder="Course Code">
          </div>
          <div class="form-group">
            <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Description</code></label><b id="subject_desc_edit_error" style="float: right;color: #FA462D;"></b>
            <input name="desc" type="text" class="form-control form-control-border border-width-2" id="desc" placeholder="Description">
          </div>
          <div class="form-group">
            <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Units</code></label><b id="subject_units_edit_error" style="float: right;color: #FA462D;"></b>
            <input name="units" type="number" class="form-control form-control-border border-width-2" id="units" placeholder="Units">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button name="subject_update" class="subject_update btn btn-primary">Update</button>
        </div>
      <!--/form-->
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
      <!--form method="POST"-->
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Offer No.</code></label><b id="subject_on_error" style="float: right;color: #FA462D;"></b>
            <input name="offer_no_add" type="number" class="form-control form-control-border border-width-2" id="offer_no_add" placeholder="Offer No.">
          </div>
          <div class="form-group">
            <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Course Code</code></label><b id="subject_cc_error" style="float: right;color: #FA462D;"></b>
            <input name="cc_add" type="text" class="form-control form-control-border border-width-2" id="cc_add" placeholder="Course Code">
          </div>
          <div class="form-group">
            <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Description</code></label><b id="subject_desc_error" style="float: right;color: #FA462D;"></b>
            <input name="desc_add" type="text" class="form-control form-control-border border-width-2" id="desc_add" placeholder="Description">
          </div>
          <div class="form-group">
            <label for="exampleInputBorderWidth2"><code style="color:lightgreen; font-size: 20px;">Units</code></label><b id="subject_units_error" style="float: right;color: #FA462D;"></b>
            <input name="units_add" type="number" class="form-control form-control-border border-width-2" id="units_add" placeholder="Units">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button name="subject_add" class="subject_add btn btn-primary">Add</button>
        </div>
      <!--/form-->
    </div>
  </div>
</div>