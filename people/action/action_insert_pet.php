<?php
if (isset($_POST['btnAddPet'])) {
    // เก็บค่าจากฟอร์ม
    $Type_pet = mysqli_real_escape_string($conn, $_POST['Type_pet']);
    $Pet_name = mysqli_real_escape_string($conn, $_POST['Pet_name']);
    $Gender = mysqli_real_escape_string($conn, $_POST['Gender']);
    $Breed = mysqli_real_escape_string($conn, $_POST['Breed']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $p_old = mysqli_real_escape_string($conn, $_POST['p_old']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $ID_PO = mysqli_real_escape_string($conn, $_POST['ID_PO']);

    // Get the current year
    $year_added = date('Y');

    // สร้างคำสั่ง SQL
    $sql_pet = "INSERT INTO pet
        (Type_pet, 
        Pet_name,
        Gender,
        Breed,
        color,
        p_old,
        weight,
        status,
        ID_PO,
        year_added
        ) 
        VALUES
        ('$Type_pet', 
        '$Pet_name',
        '$Gender',
        '$Breed',
        '$color',
        '$p_old',
        '$weight',
        '$status',
        '$ID_PO',
        '$year_added')";

    // ประมวลผลคำสั่ง SQL
    $query_pet = mysqli_query($conn, $sql_pet);
    
    // ตรวจสอบผลลัพธ์และใช้ session-based notification แทน
    if ($query_pet) {
        $_SESSION['swal_success'] = true;
        $_SESSION['swal_message'] = 'บันทึกข้อมูลสำเร็จ';
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['swal_error'] = true;
        $_SESSION['swal_message'] = 'ไม่สามารถบันทึกข้อมูลได้: ' . mysqli_error($conn);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>
