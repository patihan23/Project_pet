<?php
include('config.php');

if (mysqli_connect_errno()) {
    echo json_encode(['error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()]);
    exit();
}

if (isset($_POST['year']) && !empty($_POST['year'])) {
    $year = mysqli_real_escape_string($conn, $_POST['year']);
} else {
    echo json_encode(['error' => 'No year provided']);
    exit();
}

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
    WHERE YEAR(year_added) = ?
    GROUP BY Type_pet, Gender
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $year);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $labels = [];
    $data = [];
    $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#FF9F40'];

    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['type'] . ' - ' . $row['gender'];
        $data[] = $row['count'];
    }

    $response = json_encode([
        'labels' => $labels,
        'data' => $data,
        'colors' => $colors
    ]);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'JSON encoding error: ' . json_last_error_msg()]);
    } else {
        echo $response;
    }
} else {
    echo json_encode(['error' => 'No data found for the selected year']);
}

$stmt->close();
mysqli_close($conn);
?>
