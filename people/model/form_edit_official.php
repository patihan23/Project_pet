<script>
  function validateLength(input) {
    // ตรวจสอบความยาวของเบอร์โทร
    if (input.value.length > 10) {
      input.value = input.value.slice(0, 10);
    }
    
    // กรองให้รับเฉพาะตัวเลขเท่านั้น
    input.value = input.value.replace(/\D/g, '');
  }

  function validateForm(form) {
    var numInput = form.querySelector('input[name="num"]');
    
    // ตรวจสอบว่าเป็นตัวเลขเท่านั้น
    if (/\D/.test(numInput.value)) {
      alert("กรุณากรอกเฉพาะตัวเลขเท่านั้น");
      return false;
    }
    
    // ตรวจสอบความยาว
    if (numInput.value.length !== 10) {
      alert("กรุณากรอกเบอร์โทรให้ครบ 10 หลัก");
      return false; // ป้องกันการส่งฟอร์ม
    }
    
    return true; // อนุญาตให้ส่งฟอร์ม
  }
</script>

<div class="modal fade" id="editOfficial<?php echo $row['ID_OFF']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <h5 class="modal-title" id="myModalLabel"><span class="fas fa-edit"></span> แก้ไขข้อมูลบุคลากร </h5>
                <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <font color="#FFFFFF">&times;</font>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <form name="editProfileForm<?php echo $row['ID_OFF']; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm(this)">
                    <input type="hidden" name="ID_OFF" value="<?php echo $row['ID_OFF']; ?>" class="form-control" required="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ชื่อผู้ใช้:</label>
                                <input type="text" name="User" value="<?php echo $row['User']; ?>" class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label>รหัสผ่าน:</label>
                                <input type="text" name="Pass" value="<?php echo $row['Pass']; ?>" class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label>ชื่อ-นามสกุล:</label>
                                <input type="text" name="Off_name" value="<?php echo $row['Off_name']; ?>" class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label>เบอร์โทร:</label>
                                <input type="text" name="num" value="<?php echo $row['num']; ?>" class="form-control" pattern="\d{10}" title="กรุณากรอกเบอร์โทร 10 หลัก" required oninput="validateLength(this)">
                            </div>
                            <div class="form-group">
                                <label>อีเมล์:</label>
                                <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ตำแหน่ง:</label>
                                <input type="text" name="pst" value="<?php echo $row['pst']; ?>" class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label>หน้าที่:</label>
                                <select name="user_role" class="form-control" required="">
                                    <option value="admin" <?php if ($row['user_role'] == 'admin') echo 'selected'; ?>>แอดมิน</option>
                                    <option value="user" <?php if ($row['user_role'] == 'user') echo 'selected'; ?>>เจ้าหน้าที่</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>รูปภาพโปรไฟล์:</label>
                                <input type="file" name="profile_image" class="form-control-file">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                        <button type="submit" name="btnEditofficial" id="btnEditofficial<?php echo $row['ID_OFF']; ?>" class="swal-button swal-button--confirm btn btn-success">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
