$(document).ready(function () {
    let cart = [];
    let totalAmount = 0;

    // Menambahkan produk ke keranjang
    $("#addProduct").click(function () {
        const productCode = $("#productCode").val();

        // Mencari produk berdasarkan kode
        $.ajax({
            url: "php/getProduct.php",
            type: "POST",
            data: { product_code: productCode },
            success: function (data) {
                const product = JSON.parse(data);
                if (product) {
                    cart.push(product);
                    totalAmount += product.price;
                    updateCart();
                } else {
                    alert("Produk tidak ditemukan.");
                }
            }
        });
    });

    // Memperbarui tampilan keranjang
    function updateCart() {
        $("#cartBody").empty();
        cart.forEach((item, index) => {
            $("#cartBody").append(`
                <tr>
                    <td>${item.name}</td>
                    <td>${item.price}</td>
                    <td><button class="btn btn-danger" onclick="removeProduct(${index})">Hapus</button></td>
                </tr>
            `);
        });
        $("#totalAmount").text("Rp " + totalAmount.toLocaleString());
    }

    // Menghapus produk dari keranjang
    window.removeProduct = function (index) {
        totalAmount -= cart[index].price;
        cart.splice(index, 1);
        updateCart();
    }

    // Proses checkout
    $("#checkoutButton").click(function () {
        if (cart.length > 0) {
            $.ajax({
                url: "php/processTransaction.php",
                type: "POST",
                data: { total_amount: totalAmount },
                success: function (data) {
                    const response = JSON.parse(data);
                    if (response.success) {
                        alert("Transaksi berhasil!");
                        cart = [];
                        totalAmount = 0;
                        updateCart();
                    } else {
                        alert("Transaksi gagal: " + response.message);
                    }
                }
            });
        } else {
            alert("Keranjang kosong!");
        }
    });
});
