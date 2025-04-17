<script>
        function validateLength(input) {
            // Remove any non-digit characters
            input.value = input.value.replace(/\D/g, '');

            if (input.value.length !== 13) {
                input.setCustomValidity("หมายเลขประจำตัวประชาชนต้องมีความยาว 13 ตัวเลข");
            } else {
                input.setCustomValidity("");
            }
        }
    </script>
<div class="modal fade" id="edit_pet_own<?php echo $row['ID_PO'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header bg-warning">
        <h5 class="modal-title" id="myModalLabel"><span class="fa fa-edit"></span> แก้ไขข้อมูลเจ้าของ</h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">
      <form name="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ID_PO" value="<?php echo $row['ID_PO'] ?>" class="form-control" required="">
            <div class="form-group">
            <label>วัน/เดือน/ปี:</label>
            <input type="date" name="date_add" value="<?php echo $row['date_add'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>เจ้าของสัตว์เลี้ยง:</label>
            <input type="text" name="Po_name" value="<?php echo $row['Po_name'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>บ้านเลขที่:</label>
            <input type="text" name="Hno" value="<?php echo $row['Hno'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>หมู่:</label>
            <input type="text" name="Moo" value="<?php echo $row['Moo'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>ตำบล:</label>
            <input type="text" name="tb" value="<?php echo $row['tb'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>หมายเลขประจำตัวประชาชน:</label>
            <input type="text" name="ID" value="<?php echo $row['ID'] ?>" class="form-control" required oninput="validateLength(this)" maxlength="13">
          </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
      <button type="submit" name="btnEditPet_own" id="btnEditPet_own" class="btn btn-success">บันทึกข้อมูล</button>

      </div>
      </form>
    </div>
  </div>
</div>