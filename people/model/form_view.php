<div class="modal fade" id="viewProfileModal<?php echo $row['ID_P'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="myModalLabel"><span class="fa fa-search-plus"></span> VIEW </h5>
        <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF">&times;</font>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <form name="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <input type="hidden" name="ID_PO" value="<?= $row['ID_PO']; ?>">
              <div class="form-group">
                <label>ชื่อเจ้าของสัตว์เลี้ยง :</label>
                <input type="text" name="P_place" value="<?php echo $row['Po_name'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>บ้านเลขที่ :</label>
                <input type="text" name="P_place" value="<?php echo $row['Hno'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>หมู่ที่ :</label>
                <input type="text" name="P_place" value="<?php echo $row['Moo'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>หมายเลขประจำตัวประชาชน :</label>
                <input type="text" name="P_place" value="<?php echo $row['ID'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>เลขเจ้าของสัตว์เลี้ยง :</label>
                <input type="text" name="P_place" value="<?php echo $row['ID_PO'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>วันที่ฉีดวัคซีน :</label>
                <input type="text" name="P_place" value="<?php echo !empty($row['HV_date']) ? $row['HV_date'] : 'ยังไม่ได้รับการฉีดวัคซีน'; ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>วันที่ฉีดวัคซีนครั้งถัดไป :</label>
                <input type="text" name="P_place" value="<?php echo !empty($row['next_Hv_date']) ? $row['next_Hv_date'] : 'ยังไม่ได้รับการฉีดวัคซีน'; ?>" class="form-control" required="" disabled>
              </div>

              <div class="form-group">
                <label>สถานะการฉีดวัคซีน:</label>
                <input type="text" name="status" 
                       value="<?php echo !empty($row['next_Hv_date']) ? 'มีกำหนดฉีดวัคซีนครั้งถัดไป: ' . $row['next_Hv_date'] : 'ยังไม่ได้รับการฉีดวัคซีน'; ?>" 
                       class="form-control" 
                       required="" 
                       disabled>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>รหัสสัตว์เลี้ยง:</label>
                <input type="text" name="Pet_name" value="<?php echo $row['ID_PO'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>ประเภทสัตว์เลี้ยง:</label>
                <input type="text" name="Pet_name" value="<?php
                                                          if ($row['Type_pet'] == 1) {
                                                            echo 'สุนัข';
                                                          } elseif ($row['Type_pet'] == 2) {
                                                            echo 'แมว';
                                                          } else {
                                                            echo 'ไม่ทราบ';
                                                          }
                                                          ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>ชื่อสัตว์เลี้ยง:</label>
                <input type="text" name="Pet_name" value="<?php echo $row['Pet_name'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>เพศสัตว์เลี้ยง:</label>
                <input type="text" name="Pet_name" value=" <?php
                                                            if ($row['Gender'] == 1) {
                                                              echo 'เพศผู้';
                                                            } elseif ($row['Gender'] == 2) {
                                                              echo 'เพศเมีย';
                                                            } else {
                                                              echo 'ไม่ทราบ';
                                                            }
                                                            ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>สายพันธุ์สัตว์เลี้ยง :</label>
                <input type="text" name="Breed" value="<?php echo $row['Breed'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>สีสัตว์เลี้ยง :</label>
                <input type="text" name="color" value="<?php echo $row['color'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>น้ำหนัก[กรัม]</label>
                <input type="text" name="color" value="<?php echo $row['weight'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>อายุสัตว์เลี้ยง :</label>
                <input type="date" name="p_old" value="<?php echo $row['p_old'] ?>" class="form-control" required="" disabled>
              </div>
              <div class="form-group">
                <label>สถานะสัตว์เลี้ยง:</label>
                <div style="background-color: 
                  <?php 
                    if ($row['status'] == 1) {
                      echo '#d4edda';  // สีเขียวอ่อน (สำหรับยังมีชีวิต)
                    } elseif ($row['status'] == 2) {
                      echo '#f8d7da';  // สีแดงอ่อน (สำหรับเสียชีวิต)
                    } else {
                      echo '#fefefe';  // สีขาว (สำหรับไม่ทราบ)
                    }
                  ?>; padding: 10px;">
                  <?php 
                    if ($row['status'] == 1) {
                      echo 'ยังมีชีวิต';
                    } elseif ($row['status'] == 2) {
                      echo 'เสียชีวิต';
                    } else {
                      echo 'ไม่ทราบ';
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
              Close
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
