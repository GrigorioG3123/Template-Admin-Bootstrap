<?php
include 'db_connect.php'; // Koneksi ke database

// Mengambil daftar transaksi
$query = "SELECT * FROM transactions";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Transaksi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Total (Rp)</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($transaction = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $transaction['id']; ?></td>
                            <td><?php echo number_format($transaction['total_amount'], 0, ',', '.'); ?></td>
                            <td><?php echo $transaction['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada transaksi tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="../index.html" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
