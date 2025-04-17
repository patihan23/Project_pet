<script>
  $(document).ready(function() {
    $('#add_history_v').on('shown.bs.modal', function() {
      $('.select2').select2({
        dropdownParent: $('#add_history_v'),
        minimumInputLength: 0,
        width: '100%',
        theme: 'classic',
        placeholder: 'เลือกตัวเลือก...',
        allowClear: true
      });
    });
  });
</script>


<div class="modal fade" id="add_history_v" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="myModalLabel"><span class="fa fa-plus"></span> ประวัติการฉีดวัคซีน</h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">

        <form name="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>วันที่ฉีดวัคซีน:</label>
            <input type="date" name="HV_date" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>วันที่ฉีดวัคซีนครั้งถัดไป:</label>
            <input type="date" name="next_Hv_date" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>ชื่อวัคซีน:</label>
            <select name="ID_VC" class="form-control" required="">
              <?php
              // ดึงข้อมูลชื่อเจ้าของสัตว์เลี้ยงจาก Table pet_own
              $query = "SELECT ID_VC, V_name FROM vaccine";
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['ID_VC'] . "'>" . $row['V_name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
    <label>ชื่อสัตว์เลี้ยงและเจ้าของ:</label>
    <select name="ID_P" class="form-control select2" required="">
      <?php
      // ดึงข้อมูลชื่อสัตว์เลี้ยงและเจ้าของจาก Table pet และ pet_own แต่กรองสัตว์เลี้ยงที่ยังไม่ตาย (status != 2)
      $query = "SELECT pet.ID_P, pet.Pet_name, COALESCE(pet_own.Po_name, 'ไม่มีเจ้าของ') AS Po_name
                FROM pet
                LEFT JOIN pet_own ON pet.ID_PO = pet_own.ID_PO
                WHERE pet.status != 2"; // กรองสัตว์เลี้ยงที่ยังมีชีวิตอยู่
      $result = mysqli_query($conn, $query);

      if (!$result) {
        die("Error in query: " . mysqli_error($conn)); // แสดงข้อผิดพลาดถ้าคิวรีไม่สำเร็จ
      }

      // แสดงผลรายการสัตว์เลี้ยง
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . htmlspecialchars($row['ID_P']) . "'>" . htmlspecialchars($row['Pet_name']) . " [เจ้าของชื่อ] " . htmlspecialchars($row['Po_name']) . "</option>";
      }
      ?>
    </select>
</div>




          <div class="form-group">
            <label>สัตวแพทย์รับผิดชอบ:</label>
            <select name="ID_OFF" class="form-control select2" required="">
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
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
        <button type="submit" name="btnAddHistory_v" id="btnAddHistory_v" class="btn btn-success ">บันทึกข้อมูล</button>
      </div>
      </form>
    </div>
  </div>
</div>