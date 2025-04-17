<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Searchable Select Box</title>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
  <div class="form-group">
    <label>ชื่อสัตว์เลี้ยงและเจ้าของ:</label>
    <select name="ID_P" class="form-control select2" required="">
      <?php
      // ดึงข้อมูลชื่อสัตว์เลี้ยงและเจ้าของสัตว์เลี้ยงจาก Table pet และ pet_own
      $query = "SELECT pet.ID_P, pet.Pet_name, pet_own.ID_PO, pet_own.Po_name
                FROM pet
                JOIN pet_own ON pet.ID_P = pet_own.ID_PO";
      $result = mysqli_query($conn, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['ID_P'] . "'>" . $row['Pet_name'] . " [เจ้าของชื่อ] " . $row['Po_name'] . "</option>";
      }
      ?>
    </select>
  </div>

  <script>
  $(document).ready(function() {
    $('.select2').select2();
  });
  </script>
</body>
</html>
