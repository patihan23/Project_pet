<div class="modal fade" id="edit_vaccine<?php echo $row['ID_VC'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="myModalLabel"><span class="fa fa-edit"></span> แก้ไขข้อมูลวัคซีน</h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <form name="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="ID_VC" value="<?php echo $row['ID_VC'] ?>" class="form-control" required="">
          <div class="form-group">
            <label>ชื่อวัคซีน:</label>
            <input type="text" name="V_name" value="<?php echo $row['V_name'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>รายละเอียดวัคซีน:</label>
            <input type="text" name="V_info" value="<?php echo $row['V_info'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>การจัดเก็บวัคซีน:</label>
            <input type="text" name="V_storage" value="<?php echo $row['V_storage'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>วันที่หมดอายุ:</label>
            <input type="date" name="Expiration_date" value="<?php echo $row['Expiration_date'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>จำนวนที่มี:</label>
            <input type="number" name="Dosage" value="<?php echo $row['Dosage'] ?>" class="form-control" required="">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
        <button type="submit" name="btnEditVaccine" id="btnEditVaccine" class="btn btn-success">บันทึกข้อมูล</button>
      </div>
      </form>
    </div>
  </div>
</div>