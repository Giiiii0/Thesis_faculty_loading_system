<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Rooms</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../">Home</a></li>
            <li class="breadcrumb-item active">Rooms</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Rooms</h3>
          <button style="float: right;" type="button" class="add_room btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Add Record</button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Room No</th>
                <th>Building</th>
                <th style="width:10%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($room_row = mysqli_fetch_assoc($get_room)) {

              ?>

                <tr>
                  <td><?php echo $room_row['Room_no'] ?></td>
                  <td><?php echo $room_row['building'] ?></td>
                  <td>
                    <div class="btn-group">
                      <button type="button" data-id="<?php echo $room_row['id'] ?><?php echo $splittercode ?><?php echo $room_row['Room_no'] ?><?php echo $splittercode ?><?php echo $room_row['building'] ?>" class="edit_room btn btn-success" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pen" aria-hidden="true"></i></button>
                      <!--button type="button" id="room_remove" data-id="" class="room_remove btn btn-default" disabled><i class="fa fa-trash" aria-hidden="true"></i></button-->
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
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Room No.</code></label><b id="room_no_edit_error" style="float: right;color: #FA462D;"></b>
          <input name="room_id" type="number" class="form-control form-control-border border-width-2" id="room_id" placeholder="Room ID" hidden>
          <input name="room_no" type="text" class="form-control form-control-border border-width-2" id="room_no" placeholder="Room No.">
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Description</code></label><b id="room_building_edit_error" style="float: right;color: #FA462D;"></b>
          <input name="building" type="text" class="form-control form-control-border border-width-2" id="building" placeholder="Building">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="room_update" class="room_update btn btn-primary">Update</button>
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
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Room No.</code></label><b id="room_no_error" style="float: right;color: #FA462D;"></b>
          <input name="room_no_add" type="text" class="form-control form-control-border border-width-2" id="room_no_add" placeholder="Room No.">
        </div>
        <div class="form-group">
          <label for="exampleInputBorder"><code style="color:lightgreen; font-size: 20px;">Description</code></label><b id="room_building_error" style="float: right;color: #FA462D;"></b>
          <input name="building_add" type="text" class="form-control form-control-border border-width-2" id="building_add" placeholder="Building">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button name="room_add" class="room_add btn btn-primary">Add</button>
      </div>
    </div>
  </div>
</div>