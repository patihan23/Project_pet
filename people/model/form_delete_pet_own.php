<!-- Modal Delete Student -->
<div class="modal fade text-center" id="delete_pet_own<?php echo $row['ID_PO'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px;">
      <form name="frm_delete_admin" method="post">
      <div class="modal-body" id="txtModal">
      	  <img src="../icon/remove.png" width="13%">
          <h3 id="txtDel"><b>คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลที่เลือก ?</b></h3>
          <h5 id="txtDel2"><b>รหัสเจ้าของ <?php echo $row['ID_PO'];?></b></h5>
          <h5 id="txtDel2"><b>ชื่อ เจ้าของสัตว์เลี้ยง <?php echo $row['Po_name'];?></b></h5>
          <input type="hidden" name="ID_PO" value="<?php echo $row['ID_PO'];?>">
          <button type="submit" class="btn btn-success" name="btnDeletePet_own" id="btnDeletePet_own">Yes</button>
		  <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div> <!-- ./modal body -->
      </form>
    </div>
  </div>
</div>