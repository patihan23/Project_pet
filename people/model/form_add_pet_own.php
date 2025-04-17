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
<div class="modal fade" id="add_pet_own" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="myModalLabel"><i class="fa-solid fa-user-plus"></i> เพิ่มข้อมูลเจ้าของ</h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">

        <form name="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>เจ้าของสัตว์เลี้ยง:</label>
            <input type="text" name="Po_name" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>บ้านเลขที่:</label>
            <input type="text" name="Hno" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>หมู่:</label>
            <input type="text" name="Moo" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>ตำบล:</label>
            <input type="text" name="tb" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>หมายเลขประจำตัวประชาชน:</label>
            <input type="text" name="ID" class="form-control" required oninput="validateLength(this)" maxlength="13">
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="btnAddPet_own" id="btnAddPet_own" class="btn btn-success ">บันทึกข้อมูล</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
      </div>
      </form>
    </div>
  </div>
</div>