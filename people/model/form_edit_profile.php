<script>
    function validateLength(input) {
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
    }
</script>

<div class="modal fade" id="editProfile<?php echo $loggedInUserID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <h5 class="modal-title" id="myModalLabel"><span class="fas fa-address-card"></span> แก้ไขข้อมูลโปรไฟล์ </h5>
                <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <font color="#FFFFFF">&times;</font>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <form name="editProfileForm<?php echo $row['ID_OFF']; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="ID_OFF" value="<?php echo $row['ID_OFF']; ?>" class="form-control" required="">
                    <input type="hidden" name="pst" value="<?php echo $row['pst']; ?>" class="form-control" required="">
                    <input type="hidden" name="user_role" value="<?php echo $row['user_role']; ?>" class="form-control" required="">
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
                                <input type="number" name="num" value="<?php echo $row['num']; ?>" class="form-control" required oninput="validateLength(this)">
                            </div>
                            <div class="form-group">
                                <label>อีเมล์:</label>
                                <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ตำแหน่ง:</label>
                                <input type="text" name="" value="<?php echo $row['pst']; ?>" class="form-control" required="" disabled>
                            </div>
                            <div class="form-group">
                                <label>หน้าที่:</label>
                                <input type="text" name="" value="<?php
                                                                    if ($row['user_role'] == 'user') {
                                                                        echo 'เจ้าหน้าที่';
                                                                    } elseif ($row['user_role'] == 'admin') {
                                                                        echo 'แอดมิน';
                                                                    }
                                                                    ?>" class="form-control" required="" disabled>
                            </div>
                            <div class="form-group">
                                <label>รูปภาพโปรไฟล์:</label>
                                <input type="file" name="profile_image" class="form-control-file">
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
            <button type="submit" name="btnEditProfile" id="btnEditProfile<?php echo $row['ID_OFF']; ?>" class="swal-button swal-button--confirm btn btn-success">บันทึกข้อมูล</button>

            </div>
            </form>
        </div>
    </div>
</div>