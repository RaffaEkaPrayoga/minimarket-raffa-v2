<?php
include '../database/class/dashboard.php';
$dashboardFunctions = new DashboardFunctions();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="path/to/fontawesome/css/all.css">
    <link rel="stylesheet" href="path/to/your/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <style>
        .main-content {
            padding-left: 150px;
        }

        .row {
            margin-left: -60px;
            margin-right: -60px;
        }

        .m-min {
            margin-left: -2.75px;
            padding-right: 0px;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <section class="section col-lg-12">
            <div class="section-header" style="margin-left:-35px; margin-right:-35px; border-radius: 10px;">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 m-min">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pelanggan</h4>
                            </div>
                            <div class="card-body">
                                <span style="font-size: 19px;"><?php echo $dashboardFunctions->getTotalPelanggan(); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 m-min">
                    <div class="card card-statistic-1 card">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Product Terjual</h4>
                            </div>
                            <div class="card-body">
                                <span style="font-size: 19px;"><?php echo $dashboardFunctions->getTotalProductTerjual(); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 m-min">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fa fa-dollar-sign text-light"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Hasil yang didapat</h4>
                            </div>
                            <div class="card-body">
                                <span style="font-size: 19px;">Rp.<?php echo $dashboardFunctions->ribuan($dashboardFunctions->getHasilDidapat()); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 m-min">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <span style="font-size: 19px;">Rp.<?php echo $dashboardFunctions->ribuan($dashboardFunctions->getTotalPenjualan()); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mx-auto">Data Pembelian dari Pelanggan</h4>
                            <form method="post" action="index.php?cetak=chart" target="_blank">
                                <input type="hidden" name="chart_data" id="chart_data">
                                <button type="submit" class="btn btn-info" id="downloadButton">PDF</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-10 mx-auto align-items-center">
                                <canvas id="myBarChart" height="60" width="100"></canvas>
                            </div>
                            <p class="text-small font-weight-bold" style="margin-left: 20rem;">Data yang di tampilkan dalam bentuk rupiah</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php
    $pembelianPelanggan = $dashboardFunctions->getPembelianPelanggan();
    $pelanggan = array_column($pembelianPelanggan, 'nama_pelanggan');
    $total = array_column($pembelianPelanggan, 'totalbeli');
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("myBarChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($pelanggan) ?>,
                    datasets: [{
                        label: 'Rupiah',
                        data: <?= json_encode($total) ?>,
                        backgroundColor: '#6777ef',
                        borderColor: '#677777',
                        borderWidth: 0,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: true,
                                color: '#f2f2f2'
                            },
                            ticks: {
                                beginAtZero: true,
                                min: 0,
                                max: 50000
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            document.getElementById('downloadButton').addEventListener('click', function() {
                var canvas = document.getElementById("myBarChart");
                var imgData = canvas.toDataURL('image/png');
                document.getElementById('chart_data').value = imgData;
            });
        });
    </script>
</body>

</html>