<script>
  function validateLength(input) {
    // ตรวจสอบความยาวของเบอร์โทร
    if (input.value.length > 10) {
      input.value = input.value.slice(0, 10);
    }
  }

  function validateForm() {
    var numInput = document.querySelector('input[name="num"]');
    if (numInput.value.length !== 10) {
      alert("กรุณากรอกเบอร์โทรให้ครบ 10 หลัก");
      return false; // ป้องกันการส่งฟอร์ม
    }
    return true; // อนุญาตให้ส่งฟอร์ม
  }
</script>

<div class="modal fade" id="add_official" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="myModalLabel"><span class="fa fa-plus"></span> เพิ่มข้อมูลบุคลากร</h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <form name="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
          <div class="form-group">
            <label>ชื่อผู้ใช้:</label>
            <input type="text" name="User" value="" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>รหัสผ่าน:</label>
            <input type="text" name="Pass" value="" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>ชื่อ-นามสกุล:</label>
            <input type="text" name="Off_name" value="" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>เบอร์โทร:</label>
            <input type="text" name="num" value="" class="form-control" pattern="\d{10}" title="กรุณากรอกเบอร์โทร 10 หลัก" required oninput="validateLength(this)">
          </div>
          <div class="form-group">
            <label>อีเมล์:</label>
            <input type="email" name="email" value="" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>ตำแหน่ง:</label>
            <input type="text" name="pst" value="" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>หน้าที่:</label>
            <select name="user_role" class="form-control" required="">
              <option value="user">เจ้าหน้าที่</option>
              <option value="admin">แอดมิน</option>
            </select>
          </div>
          <div class="form-group">
            <label>รูปภาพโปรไฟล์:</label>
            <input type="file" name="profile_image" class="form-control-file" required="">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button> 
        <button type="submit" name="btnAddofficial" id="btnAddofficial" class="btn btn-success ">บันทึกข้อมูล</button>
      </div>
      </form>
    </div>
  </div>
</div>

