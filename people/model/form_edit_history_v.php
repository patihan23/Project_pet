<script>
  $(document).ready(function() {
  $('#edit_history_v<?php echo $row['ID_HV'] ?>').on('shown.bs.modal', function() {
    $(this).find('.select2').select2({
      dropdownParent: $(this),
      minimumInputLength: 0,
      width: '100%',
      theme: 'classic',
      placeholder: 'เลือกตัวเลือก...',
      allowClear: true
    });
  });
});
</script>

<div class="modal fade" id="edit_history_v<?php echo $row['ID_HV'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="myModalLabel"><span class="fa fa-edit"></span> แก้ไขข้อมูลประวัติฉีดวัคซีน</h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <form name="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="ID_HV" value="<?= $row['ID_HV']; ?>">
          <div class="form-group">
            <label>วันที่ฉีดวัคซีน:</label>
            <input type="date" name="HV_date" value="<?php echo $row['HV_date'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>วันที่ฉีดวัคซีนครั้งถัดไป:</label>
            <input type="date" name="next_Hv_date" value="<?php echo $row['next_Hv_date'] ?>" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>ชื่อวัคซีน:</label>
            <select name="ID_VC" class="form-control" required="">
              <?php
              $query_vaccine = "SELECT ID_VC, V_name FROM vaccine";
              $result_vaccine = mysqli_query($conn, $query_vaccine);
              while ($row_vaccine = mysqli_fetch_assoc($result_vaccine)) {
                echo "<option value='" . $row_vaccine['ID_VC'] . "' " . ($row_vaccine['ID_VC'] == $row['ID_VC'] ? " selected" : "") . ">" . $row_vaccine['V_name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>ชื่อสัตว์เลี้ยงและเจ้าของ:</label>
            <select name="ID_P" class="form-control select2" required="">
              <?php
              $query_pet_owner = "SELECT pet.ID_P, pet.Pet_name, COALESCE(pet_own.Po_name, 'ไม่มีเจ้าของ') AS Po_name
                                  FROM pet
                                  LEFT JOIN pet_own ON pet.ID_P = pet_own.ID_PO";
              $result_pet_owner = mysqli_query($conn, $query_pet_owner);
              $selectedID_P = isset($row['ID_P']) ? $row['ID_P'] : '';
              while ($row_pet_owner = mysqli_fetch_assoc($result_pet_owner)) {
                $isSelected = ($row_pet_owner['ID_P'] == $selectedID_P) ? " selected" : "";
                echo "<option value='" . $row_pet_owner['ID_P'] . "'" . $isSelected . ">" . $row_pet_owner['Pet_name'] . " [เจ้าของชื่อ] " . $row_pet_owner['Po_name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>สัตวแพทย์รับผิดชอบ:</label>
            <select name="ID_OFF" class="form-control select2" required="">
              <?php
              $query_official = "SELECT ID_OFF, OFF_name FROM official";
              $result_official = mysqli_query($conn, $query_official);
              while ($row_official = mysqli_fetch_assoc($result_official)) {
                echo "<option value='" . $row_official['ID_OFF'] . "' " . ($row_official['ID_OFF'] == $row['ID_OFF'] ? " selected" : "") . ">" . $row_official['OFF_name'] . "</option>";
              }
              ?>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
        <button type="submit" name="btnEditHistory_v" id="btnEditHistory_v" class="btn btn-success">บันทึกข้อมูล</button>
      </div>
      </form>
    </div>
  </div>
</div>
