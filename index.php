<?php

if ($_SERVER['REQUEST_URI'] === '/') {
    header('Content-Type: text/plain; charset=utf-8');
    echo "API Created By: Yash Jaruhar Ji";
    exit;
}

header('Content-Type: application/json; charset=utf-8');

$file = __DIR__ . '/data.json';

if (!file_exists($file)) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Database file not found"
    ]);
    exit;
}

$data = json_decode(file_get_contents($file), true);

if (!is_array($data)) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Invalid JSON database"
    ]);
    exit;
}

/* Mobile search */
if (isset($_GET['mobile'])) {

    $mobile = trim($_GET['mobile']);

    foreach ($data as $record) {

        if (isset($record['mobile']) && $record['mobile'] === $mobile) {

            echo json_encode([
                "success" => true,
                "data" => $record
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            exit;
        }
    }

    http_response_code(404);

    echo json_encode([
        "success" => false,
        "error" => "Mobile number not found"
    ], JSON_PRETTY_PRINT);

    exit;
}

/* ID search */
if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    foreach ($data as $record) {

        if ((int)$record['id'] === $id) {

            echo json_encode([
                "success" => true,
                "data" => $record
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            exit;
        }
    }

    http_response_code(404);

    echo json_encode([
        "success" => false,
        "error" => "Record not found"
    ], JSON_PRETTY_PRINT);

    exit;
}

/* All records */
echo json_encode([
    "success" => true,
    "count" => count($data),
    "data" => $data
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);