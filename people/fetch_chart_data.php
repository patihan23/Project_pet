<?php
include('../config.php');

if (isset($_POST['year'])) {
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    $query = "
        SELECT 
            Type_pet,
            COUNT(*) as count,
            CASE 
                WHEN Type_pet = 1 THEN 'สุนัข'
                WHEN Type_pet = 2 THEN 'แมว'
            END AS type,
            CASE 
                WHEN Gender = 1 THEN 'เพศผู้'
                WHEN Gender = 2 THEN 'เพศเมีย'
            END AS gender
        FROM pet 
        WHERE YEAR(year_added) = '$year'
        GROUP BY Type_pet, Gender
    ";
    $result = mysqli_query($conn, $query);

    $labels = [];
    $data = [];
    $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#FF9F40']; // ตัวอย่างสี

    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['type'] . ' - ' . $row['gender'];
        $data[] = $row['count'];
    }

    echo json_encode([
        'labels' => $labels,
        'data' => $data,
        'colors' => $colors
    ]);
}

mysqli_close($conn);
?>
