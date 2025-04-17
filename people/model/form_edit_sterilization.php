<div class="modal fade" id="edit_sterilization<?php echo $row['ID_S'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-yellow">
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-edit"></span> แก้ไขข้อมูล การทำหมัน</h4>
      </div>
      <div class="modal-body">
      <form name="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="ID_S" value="<?= $row['ID_S']; ?>">
          <div class="form-group">
            <label>วันที่ทำหมัน:</label>
            <input type="date" name="S_date" value="<?php echo $row['S_date'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>สัตว์ที่ได้รับการทำหมัน:</label>
            <select name="ID_P" class="form-control"  required="">
              <?php
              // ดึงข้อมูลชื่อเจ้าของสัตว์เลี้ยงจาก Table pet_own
              $querys = "SELECT ID_P, Pet_name FROM pet";
              $results = mysqli_query($conn, $querys);

              while ($rows = mysqli_fetch_assoc($results)) {
                echo "<option value='" . $rows['ID_P'] . "' " . ($rows['ID_P'] == $row['ID_P'] ? " selected" : "") . ">" . $rows['Pet_name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>เจ้าหน้าที่ ที่รับผิดชอบ:</label>
            <select name="ID_OFF" class="form-control" required="">
              <?php
              // ดึงข้อมูลชื่อเจ้าของสัตว์เลี้ยงจาก Table pet_own
              $queryd = "SELECT ID_OFF, OFF_name FROM official";
              $resultd = mysqli_query($conn, $queryd);

              while ($rowd = mysqli_fetch_assoc($resultd)) {
                echo "<option value='" . $rowd['ID_OFF'] . "' " . ($rowd['ID_OFF'] == $row['ID_OFF'] ? " selected" : "") . ">" . $rowd['OFF_name'] . "</option>";
              }
              ?>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="btnEditSterilization" id="btnEditSterilization" class="btn btn bg-green btn-sm">บันทึกข้อมูล</button>
        <button type="button" class="btn btn bg-red btn-sm" data-dismiss="modal">ปิดหน้าต่างนี้</button>
      </div>
      </form>
    </div>
  </div>
</div>