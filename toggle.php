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

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id < 1) {
    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid ID'
    ]);

    exit;
}

$stmt = $conn->prepare(
    "UPDATE people
     SET status = IF(status = 0, 1, 0)
     WHERE id = ?"
);

$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows !== 1) {
    http_response_code(404);

    echo json_encode([
        'success' => false,
        'message' => 'Record not found'
    ]);

    exit;
}

$stmt = $conn->prepare(
    "SELECT status FROM people WHERE id = ?"
);

$stmt->bind_param('i', $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'id' => $id,
    'status' => (int)$row['status']
]);

?>