<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            width: 300px;
            margin: 0 auto;
            padding: 10px;
        }
        .center {
            text-align: center;
        }
        .line {
            border-bottom: 1px dashed #000;
            margin: 5px 0;
        }
        table {
            width: 100%;
        }
        td {
            vertical-align: top;
        }
        .right {
            text-align: right;
        }
        .signature {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="center">
        <strong>KLINIK DR. ZHULFI</strong><br>
        Keboan, Kec. Ngusikan, Kabupaten Jombang<br>
        Jawa Timur, Indonesia
    </div>

    <div class="line"></div>
    <div>
        <strong>Nama:</strong> <?= htmlspecialchars($pasien['nama']) ?><br>
        <strong>Penyakit:</strong> <?= htmlspecialchars($pasien['penyakit']) ?><br>
        <strong>Tanggal:</strong> <?= date('d/m/Y') ?>
    </div>

    <div class="line"></div>

    <?php
        $obat  = json_decode($pasien['obat'], true);
        $qty   = json_decode($pasien['qty'], true);
        $harga = json_decode($pasien['harga'], true);
        $jumlahItem = count($obat);
    ?>

    <table>
        <?php for ($i = 0; $i < $jumlahItem; $i++): ?>
            <tr>
                <td><?= htmlspecialchars($obat[$i] ?? '-') ?></td>
                <td class="right"><?= htmlspecialchars($qty[$i] ?? '0') ?> x</td>
                <td class="right">Rp<?= number_format((float)($harga[$i] ?? 0), 0, ',', '.') ?></td>
            </tr>
        <?php endfor; ?>
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td><strong>Total</strong></td>
            <td></td>
            <td class="right"><strong>Rp<?= number_format((float)$pasien['total_harga'], 0, ',', '.') ?></strong></td>
        </tr>
        <tr>
            <td><strong>Biaya Konsultasi</strong></td>
            <td></td>
            <td class="right">Rp<?= number_format((float)$pasien['biaya_konsultasi'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><strong>Grand Total</strong></td>
            <td></td>
            <td class="right">
                <strong>
                    Rp<?= number_format((float)$pasien['total_harga'] + (float)$pasien['biaya_konsultasi'], 0, ',', '.') ?>
                </strong>
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="center">
        Terima kasih atas kunjungan Anda<br>
        Semoga lekas sembuh 🙏
    </div>

    <div class="signature">
        <br><br><br>
        <p>(Dr. Ahmad Dzulfikar Haq)</p>
    </div>
</body>
</html>
