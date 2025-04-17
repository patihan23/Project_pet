<!-- Modal Delete Student -->
<div class="modal fade text-center" id="delete_history_v<?php echo $row['ID_HV'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px;">
      <form name="frm_delete_admin" method="post">
      <div class="modal-body" id="txtModal">
      	  <img src="../icon/remove.png" width="13%">
          <h3 id="txtDel"><b>คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลที่เลือก ?</b></h3>
          <h5 id="txtDel2"><b>รหัสการฉีดวัคซีน <?php echo $row['ID_HV'];?></b></h5>
          <h5 id="txtDel2"><b>วันที่ฉีดวัคซีน <?php echo $row['HV_date'];?></b></h5>
          <h5 id="txtDel2"><b>ชื่อสัตว์เลี้ยง <?php echo $row['Pet_name'];?></b></h5>
          <input type="hidden" name="ID_HV" value="<?php echo $row['ID_HV'];?>">
          <button type="submit" class="btn btn-success" name="btnDeleteHistory_v" id="btnDeleteHistory_v">Yes</button>
		  <button type="button" class="btn btn-danger" data-dismiss="modal">  No</button>
      </div> <!-- ./modal body -->
      </form>
    </div>
  </div>
</div>