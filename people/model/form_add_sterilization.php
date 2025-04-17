<div class="modal fade" id="add_sterilization" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-green">
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-plus"></span> เพิ่มข้อมูล Sterilization</h4>
      </div>
      <div class="modal-body">

        <form name="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>วันที่ทำหมัน:</label>
            <input type="date" name="S_date" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>สัตว์ที่ได้รับการทำหมัน:</label>
            <select name="ID_P" class="form-control" required="">
              <?php
              // ดึงข้อมูลชื่อเจ้าของสัตว์เลี้ยงจาก Table pet_own
              $query = "SELECT ID_P, Pet_name FROM pet";
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['ID_P'] . "'>" . $row['Pet_name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>เจ้าหน้าที่ ที่รับผิดชอบ:</label>
            <select name="ID_OFF" class="form-control" required="">
              <?php
              // ดึงข้อมูลชื่อเจ้าของสัตว์เลี้ยงจาก Table pet_own
              $query = "SELECT ID_OFF, OFF_name FROM official";
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['ID_OFF'] . "'>" . $row['OFF_name'] . "</option>";
              }
              ?>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="btnAddSterilization" id="btnAddSterilization" class="btn btn bg-green btn-sm">บันทึกข้อมูล</button>
        <button type="button" class="btn btn bg-red btn-sm" data-dismiss="modal">ปิดหน้าต่างนี้</button>
      </div>
      </form>
    </div>
  </div>
</div>