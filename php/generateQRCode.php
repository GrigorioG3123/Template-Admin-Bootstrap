<?php
include 'db_connect.php'; // Koneksi ke database

require 'vendor/autoload.php'; // Pastikan Anda sudah menginstall library QR Code

use Endroid\QrCode\QrCode;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];

    // Buat QR Code
    $qrCode = new QrCode("Nama Produk: $productName, Harga: $productPrice");
    $qrCode->setSize(300);
    $qrCode->setMargin(10);
    
    // Simpan QR Code ke file
    $fileName = 'qr_codes/' . uniqid() . '.png';
    $qrCode->writeFile($fileName);

    // Simpan data produk ke database
    $stmt = $conn->prepare("INSERT INTO products (name, price, qr_code) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $productName, $productPrice, $fileName);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'qr_code' => $fileName]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }

    $stmt->close();
}

$conn->close();
?>
