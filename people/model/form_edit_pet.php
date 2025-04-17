<script>
  $(document).ready(function() {
  $('#edit_pet<?php echo $row['ID_P'] ?>').on('shown.bs.modal', function() {
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
<div class="modal fade" id="edit_pet<?php echo $row['ID_P'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="myModalLabel"><span class="fa fa-edit"></span> แก้ไขข้อมูลสัตว์เลี้ยง</h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <form name="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="ID_P" value="<?= $row['ID_P']; ?>">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>ประเภทสัตว์เลี้ยง:</label>
                <select name="Type_pet" class="form-select form-control" required="">
                  <option value="1">สุนัข</option>
                  <option value="2">แมว</option>
                </select>
              </div>
              <div class="form-group">
                <label>ชื่อสัตว์เลี้ยง:</label>
                <input type="text" name="Pet_name" value="<?php echo $row['Pet_name'] ?>" class="form-control" required="">
              </div>
              <div class="form-group">
                <label>เพศสัตว์เลี้ยง:</label>
                <select name="Gender" class="form-control" required="">
                  <option value="1">เพศผู้</option>
                  <option value="2">เพศเมีย</option>
                </select>
              </div>
              <div class="form-group">
                <label>สายพันธุ์สัตว์เลี้ยง :</label>
                <input type="text" name="Breed" value="<?php echo $row['Breed'] ?>" class="form-control" required="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>สีสัตว์เลี้ยง :</label>
                <input type="text" name="color" value="<?php echo $row['color'] ?>" class="form-control" required="">
              </div>
              <div class="form-group">
                <label>อายุสัตว์เลี้ยง :</label>
                <input type="date" name="p_old" value="<?php echo $row['p_old'] ?>" class="form-control" required="">
              </div>
              <div class="form-group">
                <label>น้ำหนัก [กิโลกรัม] :</label>
                <input type="text" name="weight" value="<?php echo $row['weight'] ?>" class="form-control" required="">
              </div>
              <input type="hidden" name="ID_PO" value="<?= $row['ID_PO']; ?>">
              <div class="form-group">
                <label>ชื่อเจ้าของสัตว์เลี้ยง :</label>
                <select name="ID_PO" class="form-select select2" required="">
                  <?php
                  // ดึงข้อมูลชื่อเจ้าของสัตว์เลี้ยงจาก Table pet_own
                  $queryp = "SELECT ID_PO, Po_name FROM pet_own";
                  $resultp = mysqli_query($conn, $queryp);

                  while ($rowp = mysqli_fetch_assoc($resultp)) {
                    echo "<option value='" . $rowp['ID_PO'] . "' " . ($rowp['ID_PO'] == $row['ID_PO'] ? " selected" : "") . ">" . $rowp['Po_name'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>สถานะสัตว์เลี้ยง :</label>
                <select name="status" class="form-control" required="">
                  <option value="1">ยังมีชีวิต</option>
                  <option value="2">เสียชีวิต</option>
                </select>
              </div>
            </div>
          </div>
      </div>





      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
        <button type="submit" name="btnEditPet" id="btnEditPet" class="btn btn-success">บันทึกข้อมูล</button>
      </div>
      </form>
    </div>
  </div>
</div>