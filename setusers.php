<?php
require_once "config.php";


$users = [
    [
        'userid' => 'admin1',
        'password' => password_hash('admin1', PASSWORD_DEFAULT),
        'user_type' => 'admin',
        'user_status' => 'active',
        'first_name' => 'Admin',
        'last_name' => 'Name1',
        'email' => 'admin1@utdallas.edu'
    ],
    [
        'userid' => 'user2',
        'password' => password_hash('user2', PASSWORD_DEFAULT),
        'user_type' => 'user',
        'user_status' => 'active',
        'first_name' => 'User',
        'last_name' => 'Name2',
        'email' => 'user2@utdallas.edu'
    ]
];

foreach ($users as $user) {
    $stmt = $conn->prepare("INSERT INTO user (userid, password, user_type, user_status, first_name, last_name, email)
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssss",
        $user['userid'],
        $user['password'],
        $user['user_type'],
        $user['user_status'],
        $user['first_name'],
        $user['last_name'],
        $user['email']
    );
    $stmt->execute();
}

echo "Initial admin and user inserted successfully.";
?>
