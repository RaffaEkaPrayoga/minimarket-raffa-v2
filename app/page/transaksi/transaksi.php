<?php
if ($currentUser['level'] === 3) {
    echo "<script>
    window.location = 'index.php?alert=err2';
</script>";
    exit;
}

include "../database/class/transaksi.php";
$pdo = Koneksi::connect();
$transaksi = Transaksi::getInstance($pdo);

// Menangani formulir jika disubmit
if (isset($_POST["submit"])) {
    // Ambil dan sanitasi data POST
    $nonota = htmlspecialchars($_POST['no_nota']);
    $idpell = htmlspecialchars($_POST['id_pelanggan']);
    $totalbeli = htmlspecialchars($_POST['totalbeli']);
    $pembayaran = htmlspecialchars($_POST['pembayaran']);
    $kembalian = htmlspecialchars($_POST['kembalian']);
    $catatan = htmlspecialchars($_POST['catatan']);

    // Validasi input
    if (empty($nonota) || empty($idpell) || empty($totalbeli) || empty($pembayaran)) {
        echo '<script>window.location="index.php?page=transaksi&alert=err1"</script>';
    } else if (!is_numeric($totalbeli) || !is_numeric($pembayaran)) {
        echo '<script>alert("Inputan harus berupa angka");</script>';
    } else {
        // Simpan transaksi
        if ($transaksi->saveTransaction($nonota, $idpell, $totalbeli, $pembayaran, $kembalian, $catatan)) {
            // Redirect setelah menyimpan
            echo '<script>window.location.href = "index.php?page=laporan&act=detail&alert=success1&invoice=' . $nonota . '"</script>';
        } else {
            echo '<script>alert("Gagal menyimpan transaksi.");</script>';
        }
    }
}



// Mendapatkan kode nota baru untuk transaksi
$kodeNota = $transaksi->generateKodeNota();

$query = "SELECT * FROM produk ORDER BY idproduk ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tanggalSekarang = date('Y-n-j H:i:s');

?>

<div class="main-content" style="padding-left: 0px; padding-right:0;">
    <div class="section">
        <div class="section-header" style="margin-left:0px; margin-right:0px; border-radius: 10px;">
            <h1>Transaksi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="index.php?page=transaksi">Transaksi</a></div>
                <div class="breadcrumb-item"><a href="index.php?page=transaksi">Tambah Transaksi</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="card small mb-3" style="margin-right:-1rem; border-radius:1rem;">
                        <div class=" card-header p-2">
                            <div class="card-title"><i class="far fa-file mr-1"></i> Informasi Nota</div>
                        </div>
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-4 mb-2 text-right pt-1 pr-1">No. Nota : </div>
                                <div class="col-8 mb-2 pl-0">
                                    <input type="text" class="form-control form-control-sm bg-white" value="<?= $kodeNota ?>" readonly>
                                </div>
                                <div class="col-4 mb-2 text-right pt-1 pr-1">Tanggal : </div>
                                <div class="col-8 mb-2 pl-0">
                                    <input type="text" class="form-control form-control-sm bg-white" value="<?= $tanggalSekarang ?>" readonly>
                                </div>
                                <div class="col-4 text-right pt-1 pr-1">Kasir : </div>
                                <div class="col-8 pl-0">
                                    <input type="text" class="form-control form-control-sm bg-white" value="<?= $_SESSION["ssUser"] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card small mb-3" style="margin-right:-1rem;border-radius:1rem;">
                        <div class="card-header p-2">
                            <div class="card-tittle"><i class="far fa-user mr-1"></i> Informasi Pelanggan</div>
                        </div>
                        <div class="card-body p-2">
                            <!-- Form Tambah1 -->


                            <!-- Form Ada1 -->
                            <div id="Ada1">
                                <div class="row">
                                    <div class="col-4 mb-2 text-right pt-1 pr-1">Nama : </div>
                                    <div class="col-8 mb-2 pl-0">
                                        <?php
                                        $pelanggan = $transaksi->getAllPelanggan();
                                        $jsArrayp = "var telepon_pelanggan = new Array();";
                                        $jsArrayp1 = "var alamat_pelanggan = new Array();";
                                        $jsArrayp2 = "var id_pelanggan = new Array();";
                                        ?>
                                        <input type="text" class="form-control form-control-sm bg-white" list="datalist-pelanggan" onchange="changeValuePelanggan(this.value)" required>
                                        <datalist id="datalist-pelanggan">
                                            <?php
                                            foreach ($pelanggan as $row1) {
                                                echo '<option value="' . htmlspecialchars($row1["nama_pelanggan"], ENT_QUOTES, 'UTF-8') . '">';
                                            }
                                            ?>
                                        </datalist>
                                        <input type="hidden" name="id_pelanggan" id="id_pelanggan" class="form-control form-control-sm bg-white">
                                    </div>
                                    <div class="col-4 mb-2 text-right pt-1 pr-1">Telepon : </div>
                                    <div class="col-8 mb-2 pl-0">
                                        <input type="text" class="form-control form-control-sm bg-white" id="telepon_pelanggan" readonly>
                                    </div>
                                    <div class="col-4 mb-2 text-right pt-1 pr-1">Alamat : </div>
                                    <div class="col-8 mb-2 pl-0">
                                        <input type="text" class="form-control form-control-sm bg-white" id="alamat_pelanggan" readonly>
                                    </div>
                                </div>
                            </div><!-- end ada1 -->
                        </div><!-- end card-body -->
                    </div>
                </div>
            </div><!-- end col-lg-3 -->


            <div class="col-lg-9 offset-lg-3" style="margin-top: -25rem;">
                <form id="myCartNew" method="POST">
                    <div id="dynamic-items-container">
                        <!-- Dynamic items will be added here -->
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-2" onclick="addNewItem(1)">Tambah Barang</button>
                </form>

                <?php
                if (isset($_POST['tambahcuy'])) {
                    $idproduk = intval($_POST['idproduk']);
                    $quantity = intval($_POST['quantity']);

                    if ($quantity < 1) {
                        echo '<script>alert("Jumlah barang tidak boleh kurang dari 1"); window.location="index.php?page=transaksi";</script>';
                        exit;
                    }

                    // Check stock
                    $stmt = $pdo->prepare("SELECT stock FROM produk WHERE idproduk = :idproduk");
                    $stmt->execute(['idproduk' => $idproduk]);
                    $stocknya = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($stocknya) {
                        $stock = $stocknya['stock'];
                        $sisa = $stock - $quantity;

                        if ($stock < $quantity) {
                            echo '<script>alert("Oops! Jumlah pengeluaran lebih besar dari stok ...");window.location="index.php?page=transaksi"</script>';
                        } else {
                            try {
                                $pdo->beginTransaction();

                                // Insert into cart
                                $stmt = $pdo->prepare("INSERT INTO keranjang (idproduk, quantity) VALUES (:idproduk, :quantity)");
                                $stmt->execute(['idproduk' => $idproduk, 'quantity' => $quantity]);

                                // Update stock
                                $stmt = $pdo->prepare("UPDATE produk SET stock = :sisa WHERE idproduk = :idproduk");
                                $stmt->execute(['sisa' => $sisa, 'idproduk' => $idproduk]);

                                $pdo->commit();
                                echo '<script>window.location="index.php?page=transaksi"</script>';
                            } catch (Exception $e) {
                                $pdo->rollBack();
                                echo '<script>alert("ERROR: ' . $e->getMessage() . '");history.go(-1);</script>';
                            }
                        }
                    } else {
                        echo '<script>alert("Produk tidak ditemukan");window.location="index.php?page=transaksi"</script>';
                    }
                }

                if (isset($_POST['upone'])) {
                    $idcart = intval($_POST['idcc']);
                    $quantity = intval($_POST['qty']);

                    // Get product ID and current quantity
                    $stmt = $pdo->prepare("SELECT idproduk, quantity FROM keranjang WHERE idcart = :idcart");
                    $stmt->execute(['idcart' => $idcart]);
                    $cartData = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($cartData) {
                        $idproduk = $cartData['idproduk'];
                        $oldQuantity = $cartData['quantity'];

                        // Check stock
                        $stmt = $pdo->prepare("SELECT stock FROM produk WHERE idproduk = :idproduk");
                        $stmt->execute(['idproduk' => $idproduk]);
                        $stocknya = $stmt->fetch(PDO::FETCH_ASSOC);
                        $stock = $stocknya['stock'];

                        $newQuantity = $quantity + $oldQuantity;
                        if ($stock < $newQuantity) {
                            echo '<script>alert("Oops! Jumlah pengeluaran lebih besar dari stok ...");window.location="index.php?page=transaksi"</script>';
                        } else {
                            try {
                                $pdo->beginTransaction();

                                // Update cart and stock
                                $stmt = $pdo->prepare("UPDATE keranjang SET quantity = :quantity WHERE idcart = :idcart");
                                $stmt->execute(['quantity' => $newQuantity, 'idcart' => $idcart]);

                                $sisa = $stock - $quantity;
                                $stmt = $pdo->prepare("UPDATE produk SET stock = :sisa WHERE idproduk = :idproduk");
                                $stmt->execute(['sisa' => $sisa, 'idproduk' => $idproduk]);

                                $pdo->commit();
                                echo '<script>window.location="index.php?page=transaksi"</script>';
                            } catch (Exception $e) {
                                $pdo->rollBack();
                                echo '<script>alert("ERROR: ' . $e->getMessage() . '");history.go(-1);</script>';
                            }
                        }
                    } else {
                        echo '<script>alert("Keranjang tidak ditemukan");window.location="index.php?page=transaksi"</script>';
                    }
                }

                if (isset($_POST['hapuscart'])) {
                    $idcart = intval($_POST['idcart']);

                    // Get product ID and quantity
                    $stmt = $pdo->prepare("SELECT idproduk, quantity FROM keranjang WHERE idcart = :idcart");
                    $stmt->execute(['idcart' => $idcart]);
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($data) {
                        $idproduk = $data['idproduk'];
                        $quantity = $data['quantity'];

                        // Get stock
                        $stmt = $pdo->prepare("SELECT stock FROM produk WHERE idproduk = :idproduk");
                        $stmt->execute(['idproduk' => $idproduk]);
                        $stocknya = $stmt->fetch(PDO::FETCH_ASSOC);
                        $stock = $stocknya['stock'];

                        // Update stock
                        $sisa = $stock + $quantity;
                        try {
                            $pdo->beginTransaction();

                            $stmt = $pdo->prepare("UPDATE produk SET stock = :sisa WHERE idproduk = :idproduk");
                            $stmt->execute(['sisa' => $sisa, 'idproduk' => $idproduk]);

                            // Delete from cart
                            $stmt = $pdo->prepare("DELETE FROM keranjang WHERE idcart = :idcart");
                            $stmt->execute(['idcart' => $idcart]);

                            $pdo->commit();
                            echo '<script>window.location="index.php?page=transaksi"</script>';
                        } catch (Exception $e) {
                            $pdo->rollBack();
                            echo '<script>alert("ERROR: ' . $e->getMessage() . '");history.go(-1);</script>';
                        }
                    } else {
                        echo '<script>alert("Keranjang tidak ditemukan");window.location="index.php?page=transaksi"</script>';
                    }
                }
                ?>


                <div class="card small">
                    <div class="card-header p-2 d-flex align-items-center justify-content-center">
                        <div class="card-title text-center h6 font-weight-bold">
                            <i class="far fa-cart-plus"></i> Keranjang
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data_produk = $transaksi->getProdukKeranjang();

                                $subtotalcart1 = 0;
                                $no = 1;
                                foreach ($data_produk as $d) {
                                    $idcart = $d['idcart'];
                                    $subtotalcart = $d['harga_jual'] * $d['quantity'];
                                    $subtotalcart1 += $subtotalcart;

                                    echo '<tr>
                                        <td>' . $no . '</td>
                                        <td>' . $d["kode_produk"] . '</td>
                                        <td>' . $d["nama_produk"] . '</td>
                                        <td>' . number_format($d["harga_jual"], 0, ',', '.') . '</td>
                                        <td>' . $d["quantity"] . '</td>
                                        <td>' . number_format($subtotalcart, 0, ',', '.') . '</td>
                                        <td>
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="idcart" value="' . $d["idcart"] . '">
                                                <button type="submit" name="hapuscart" class="btn btn-danger btn-sm mt-1">Hapus</button>
                                            </form>
                                        </td>           
                                    </tr>';
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="bg-total p-2 text-right print-none">
                            Rp.<?= ribuan($subtotalcart1) ?>
                        </div>
                        <!-- Form Simpan Transaksi -->
                        <form method="POST" id="form-simpan-transaksi">
                            <div class="row">
                                <div class="col-lg-7 mb-2">
                                    <textarea name="catatan" class="form-control form-control-sm" id="catatan" placeholder="Catatan Transaksi (Jika Ada)" cols="10" rows="5"></textarea>
                                </div>
                                <div class="col-lg-5 mb-2 print-none">
                                    <div class="row">
                                        <div class="col-5 mb-2 text-right pt-1 pr-2" style="font-weight:500;">Pembayaran :</div>
                                        <div class="col-7 mb-2 pl-0">
                                            <input type="hidden" name="no_nota" value="<?= htmlspecialchars($kodeNota) ?>">
                                            <input type="hidden" name="id_pelanggan" id="id_pelanggan" class="form-control form-control-sm bg-white">
                                            <input type="hidden" name="totalbeli" value="<?= $subtotalcart1 ?>" id="hargatotal">
                                            <input type="number" class="form-control form-control-sm bg-white" placeholder="0" name="pembayaran" id="bayarnya" onchange="totalnya()" required>
                                        </div>
                                        <div class="col-5 text-right pt-1 pr-2" style="font-weight:500;">Kembalian :</div>
                                        <div class="col-7 pl-0">
                                            <input type="text" class="form-control form-control-sm bg-white" placeholder="0" name="kembalian" id="total1" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-right mt-2" style="margin-left: -5rem; margin-top:-2rem;">
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash-restore-alt mr-1"></i> Reset
                                    </button>
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                        <i class="far fa-file mr-1"></i> Simpan
                                    </button>
                                </div>
                            </div><!-- end row -->
                        </form>
                    </div><!-- end print -->
                </div><!-- end col-lg-9 -->
            </div><!-- end row -->
            </form>
        </div><!-- end section -->


        <script>
            var itemCount = 0;

            function addNewItem() {
                itemCount++;
                var newItem = `
            <div class="row print-none" id="item-${itemCount}">
                <div class="col-12 col-lg-3 m-pr-0">
                    <label class="mb-1">Kode Produk</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" list="datalist1-${itemCount}" onchange="changeValue(this.value, ${itemCount})" aria-describedby="basic-addon2" required>
                        <datalist id="datalist1-${itemCount}">
                            <?php foreach ($barang as $row_brg) { ?>
                                <option value="<?= htmlspecialchars($row_brg["kode_produk"], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($row_brg["kode_produk"], ENT_QUOTES, 'UTF-8') ?>
                            <?php } ?>
                        </datalist>
                    </div>
                </div>
                <div class="col-6 col-lg-2 pr-0">
                    <label class="mb-1">Nama Produk</label>
                    <input type="hidden" class="form-control form-control-sm bg-white" name="idproduk" id="idproduk-${itemCount}" readonly>
                    <input type="text" class="form-control form-control-sm bg-white" id="nama_produk-${itemCount}" readonly>
                </div>
                <div class="col-6 col-lg-2 m-pr-0">
                    <label class="mb-1">Harga</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="harga_jual-${itemCount}" onchange="total(${itemCount})">
                </div>
                <div class="col-6 col-lg-1 pr-0">
                    <label class="mb-1">Stock</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="stock-${itemCount}" readonly>
                </div>
                <div class="col-6 col-lg-1 pr-0">
                    <label class="mb-1">Qty</label>
                    <input type="number" class="form-control form-control-sm" id="quantity-${itemCount}" onchange="total(${itemCount})" name="quantity" placeholder="0" required>
                </div>
                <div class="col-lg-3">
                    <label class="mb-1">Subtotal</label>
                    <div class="input-group">
                        <input type="number" class="form-control form-control-sm bg-white" id="subtotal-${itemCount}" name="tambahcuy" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-danger btn-sm border-0" type="reset">
                                <i class="fa fa-trash-restore-alt"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
                $('#dynamic-items-container').append(newItem);
            }

            function total(itemId) {
                var harga = parseFloat(document.getElementById('harga_jual-' + itemId).value.replace(/\./g, '').replace(/,/g, '.')) || 0;
                var qty = parseInt(document.getElementById('quantity-' + itemId).value) || 0;
                var subtotal = harga * qty;
                document.getElementById('subtotal-' + itemId).value = ribuan(subtotal);
                document.getElementById("myCartNew").submit();
            }

            function totalnya() {
                var harga = parseInt(document.getElementById('hargatotal').value);
                var pembayaran = parseInt(document.getElementById('bayarnya').value);
                var kembali = pembayaran - harga;
                document.getElementById('total1').value = kembali;
            }

            function ribuan(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }


            function changeValue(kode_produk, itemId) {
                var idproduk = "";
                var nama_produk = "";
                var harga_jual = "";
                var stock = "";

                <?php
                foreach ($barang as $row_brg) {
                    echo "if (kode_produk == '" . $row_brg["kode_produk"] . "') {";
                    echo "idproduk = '" . $row_brg["idproduk"] . "';";
                    echo "nama_produk = '" . $row_brg["nama_produk"] . "';";
                    echo "harga_jual = '" . $row_brg["harga_jual"] . "';";
                    echo "stock = '" . $row_brg["stock"] . "';";
                    echo "}";
                }
                ?>

                document.getElementById('idproduk-' + itemId).value = idproduk;
                document.getElementById('nama_produk-' + itemId).value = nama_produk;
                document.getElementById('harga_jual-' + itemId).value = harga_jual;
                document.getElementById('stock-' + itemId).value = stock;
            }

            function changeValuePelanggan(nama) {
                <?php
                foreach ($pelanggan as $row) {
                    echo "if (nama === '" . htmlspecialchars($row["nama_pelanggan"], ENT_QUOTES, 'UTF-8') . "') {";
                    echo "document.getElementById('telepon_pelanggan').value = '" . htmlspecialchars($row["telepon_pelanggan"], ENT_QUOTES, 'UTF-8') . "';";
                    echo "document.getElementById('alamat_pelanggan').value = '" . htmlspecialchars($row["alamat_pelanggan"], ENT_QUOTES, 'UTF-8') . "';";
                    echo "document.getElementById('id_pelanggan').value = '" . htmlspecialchars($row["id_pelanggan"], ENT_QUOTES, 'UTF-8') . "';";
                    echo "}";
                }
                ?>
            }

            document.getElementById('form-simpan-transaksi').addEventListener('submit', function() {
                var idPelanggan = document.getElementById('id_pelanggan').value;
                document.getElementById('form-simpan-transaksi').querySelector('input[name="id_pelanggan"]').value = idPelanggan;
            });


            function hapusItem(itemId) {
                document.getElementById('item-' + itemId).remove();
            }

            document.getElementById('form-simpan-transaksi').addEventListener('submit', function(event) {
                var idPelanggan = document.getElementById('id_pelanggan').value;
                if (!idPelanggan) {
                    window.location = "index.php?page=transaksi&alert=err1";
                    event.preventDefault(); // Hentikan pengiriman form jika id_pelanggan kosong
                }
            });
        </script>