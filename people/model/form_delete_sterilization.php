<!-- Modal Delete Student -->
<div class="modal fade" id="delete_sterilization<?php echo $row['ID_S'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px;">
      <form name="frm_delete_admin" method="post">
      <div class="modal-body" id="txtModal">
      	  <img src="../icon/remove.png" width="13%">
          <h3 id="txtDel"><b>คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลที่เลือก ?</b></h3>
          <h5 id="txtDel2"><b>รหัสการทำหมัน <?php echo $row['ID_S'];?></b></h5>
          <input type="hidden" name="ID_S" value="<?php echo $row['ID_S'];?>">
          <button type="submit" class="btn btn bg-green" name="btnDeleteSterilization" id="btnDeleteSterilization">ใช่ต้องการลบ Yes</button>
		  <button type="button" class="btn btn bg-red" data-dismiss="modal">ไม่ต้องการลบ No</button>
      </div> <!-- ./modal body -->
      </form>
    </div>
  </div>
</div>