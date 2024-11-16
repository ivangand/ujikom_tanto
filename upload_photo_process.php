<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Proses unggah foto
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file benar-benar gambar
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File yang diunggah bukan gambar.";
        $uploadOk = 0;
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "File sudah ada. Menggunakan file yang sudah ada.";
        $uploadOk = 1; // Tetap izinkan karena file bisa digunakan kembali
    }

    // Cek ukuran file (maksimal 2MB)
    if ($_FILES["photo"]["size"] > 2000000) {
        echo "File terlalu besar.";
        $uploadOk = 0;
    }

    // Batasi format file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Jika tidak ada error, upload file
    if ($uploadOk == 1) {
        if (!file_exists($target_file)) {
            // Hanya upload file jika belum ada
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                echo "File " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " berhasil diunggah.";
            } else {
                echo "Ada kesalahan saat mengunggah file.";
                $uploadOk = 0; // Gagal mengunggah
            }
        }

        // Jika unggah berhasil atau file sudah ada, simpan data ke database
        if ($uploadOk == 1) {
            // Pastikan nama field benar, sesuaikan dengan tabel di database (ubah dari photo_path ke file_path jika diperlukan)
            $query = "INSERT INTO photo (title, description, photo_path) VALUES ('$title', '$description', '$target_file')";
            
            // Eksekusi query
            if (mysqli_query($conn, $query)) {
                echo "Foto berhasil disimpan ke database!";
                header("Location: photos.php"); // Redirect ke halaman photos
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

    $conn->close();
}
?>
