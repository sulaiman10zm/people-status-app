<?php

header('Content-Type: application/json; charset=utf-8');

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);

    exit;
}

$name = trim($_POST['name'] ?? '');
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);

if ($name === '' || $age === false || $age < 1 || $age > 120) {
    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid name and age'
    ]);

    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO people (name, age, status) VALUES (?, ?, 0)"
);

$stmt->bind_param('si', $name, $age);

if (!$stmt->execute()) {
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Could not save the record'
    ]);

    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Record added successfully',
    'person' => [
        'id' => $stmt->insert_id,
        'name' => $name,
        'age' => $age,
        'status' => 0
    ]
]);

?>