<?php

if (isset($_POST['save'])) {
    // Ambil data dari form
    $customerId = mysqli_real_escape_string($connection, $_POST['customerId']);
    $customerName = mysqli_real_escape_string($connection, $_POST['customerName']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $phoneNumber = mysqli_real_escape_string($connection, $_POST['phoneNumber']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $productId = mysqli_real_escape_string($connection, $_POST['productId']);
    $quantity = (int) $_POST['quantity'];
    $userId = 1; // Ganti sesuai userId yang login
    $status = 0; // Default status pesanan: Belum diproses

    // Validasi data form
    if (empty($customerName) || empty($gender) || empty($phoneNumber) || empty($address) || empty($productId) || $quantity <= 0) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // Periksa stok produk
        $sqlCheckStock = "SELECT stock FROM products WHERE productId = '$productId'";
        $resultStock = mysqli_query($connection, $sqlCheckStock);
        $productData = mysqli_fetch_assoc($resultStock);

        if (!$productData) {
            echo "<script>alert('Produk tidak ditemukan!');</script>";
        } elseif ($productData['stock'] < $quantity) {
            echo "<script>alert('Stok tidak mencukupi!');</script>";
        } else {
            // Mulai transaksi
            mysqli_begin_transaction($connection);

            try {
                // Tambahkan pelanggan baru
                $sqlInsertCustomer = "INSERT INTO customers (customerId, customerName, gender, phoneNumber, address)
                                      VALUES ('$customerId', '$customerName', '$gender', '$phoneNumber', '$address')";
                mysqli_query($connection, $sqlInsertCustomer);

                // Tambahkan pesanan
                $sqlInsertOrder = "INSERT INTO orders (productId, customerId, quantity, userId, status)
                                   VALUES ('$productId', '$customerId', '$quantity', '$userId', '$status')";
                mysqli_query($connection, $sqlInsertOrder);

                // Update stok produk
                $newStock = $productData['stock'] - $quantity;
                $sqlUpdateStock = "UPDATE products SET stock = $newStock WHERE productId = '$productId'";
                mysqli_query($connection, $sqlUpdateStock);

                // Commit transaksi
                mysqli_commit($connection);

                echo "<script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pesanan berhasil disimpan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '?p=order';
                        }
                    });
                </script>";
            } catch (Exception $e) {
                // Rollback jika terjadi kesalahan
                mysqli_rollback($connection);
                echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "');</script>";
            }
        }
    }
}
?>
