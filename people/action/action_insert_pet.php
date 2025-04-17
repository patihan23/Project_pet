<?php
if (isset($_POST['btnAddPet'])) {
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

    $query_pet = mysqli_query($conn, $sql_pet);
    if ($query_pet) {
        echo  '
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: "บันทึกข้อมูลสำเร็จ",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                    });
                });
            </script>
        ';
    } else {
        echo '
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "ไม่สามารถบันทึกข้อมูลได้",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "' . $_SERVER['REQUEST_URI'] . '";
                });
            });
        </script>
        ';
    }
}
?>
