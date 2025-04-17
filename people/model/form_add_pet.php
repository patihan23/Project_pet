<script>
  $(document).ready(function() {
    $('#add_pet').on('shown.bs.modal', function() {
      $('.select2').select2({
        dropdownParent: $('#add_pet'),
        minimumInputLength: 0,
        width: '100%',
        theme: 'classic',
        placeholder: 'เลือกตัวเลือก...',
        allowClear: true
      });
    });
  });
</script>

<div class="modal fade" id="add_pet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="myModalLabel"><span class="fa fa-plus"></span> เพิ่มข้อมูล Pet</h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <form name="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="status" value="1">
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
                <input type="text" name="Pet_name" class="form-control" required="">
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
                <input type="text" name="Breed" class="form-control" required="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>สีสัตว์เลี้ยง / ตำหนิ :</label>
                <input type="text" name="color" class="form-control" required="">
              </div>
              <div class="form-group">
    <label>อายุสัตว์เลี้ยง :</label>
    <input type="date" id="datepicker" name="p_old" class="form-control" required="">
</div>

<script>
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            beforeShow: function(input, inst) {
                // ปรับแต่งปีให้แสดงเป็นพุทธศักราช
                var date = $(this).datepicker('getDate');
                if (date !== null) {
                    var year = date.getFullYear();
                    $(this).datepicker('option', 'yearRange', (year - 543) + ":" + (year + 543));
                }
            },
            onClose: function(dateText, inst) {
                var date = $(this).datepicker('getDate');
                if (date !== null) {
                    var year = date.getFullYear();
                    // ปรับปีจาก ค.ศ. เป็น พ.ศ.
                    if (year < 2500) {
                        date.setFullYear(year + 543);
                        $(this).datepicker('setDate', date);
                    }
                }
            }
        });
    });
</script>
              <div class="form-group">
                <label>น้ำหนัก [กิโลกรัม] :</label>
                <input type="text" name="weight" class="form-control" required="">
              </div>
              <div class="form-group">
                <label>ชื่อเจ้าของสัตว์เลี้ยง :</label>
                <select name="ID_PO" id="ownerSelect" class="form-select select2" required="">
                  <?php
                  // ดึงข้อมูลชื่อเจ้าของสัตว์เลี้ยงจาก Table pet_own
                  $query = "SELECT ID_PO, Po_name FROM pet_own";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['ID_PO'] . "'>" . $row['Po_name'] . "</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิดหน้าต่างนี้</button>
        <button type="submit" name="btnAddPet" id="btnAddPet" class="btn btn-success">บันทึกข้อมูล</button>
      </div>
      </form>
    </div>
  </div>
</div>