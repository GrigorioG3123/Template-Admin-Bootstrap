<?php
include 'db_connect.php'; // Koneksi ke database

// Memproses transaksi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $totalAmount = $_POST['total_amount'];

    // Insert ke tabel transaksi
    $stmt = $conn->prepare("INSERT INTO transactions (total_amount, created_at) VALUES (?, NOW())");
    $stmt->bind_param("d", $totalAmount);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }

    $stmt->close();
}

$conn->close();
?>
