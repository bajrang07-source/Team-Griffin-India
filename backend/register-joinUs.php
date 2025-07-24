<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include("config.php");

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$department = $data['department'] ?? '';
$why = $data['why'] ?? '';

if (!$name || !$email || !$department || !$why) {
    http_response_code(400);
    echo json_encode(["message" => "All fields are required."]);
    exit;
}

$checkEmail = "SELECT * FROM recruitment_data WHERE email='$email'";
$result = $conn->query($checkEmail);

if ($result->num_rows > 0) {
    die("Email is already registered.");
}

$sql = "INSERT INTO recruitment_data (name, email, department, why) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $department, $why);

if ($stmt->execute()) {
    echo json_encode(["message" => "Application submitted successfully!"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>