<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "foto_galeri");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Tangkap data dari form register
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST['email']; // pastikan 'email' ada di form

// Query insert data ke database
$query = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";

// Eksekusi query
if ($koneksi->query($query) === TRUE) {
    echo "<script>alert('Registrasi berhasil!');</script>";
    header('location: register.html');
} else {
    echo "Error: " . $query . "<br>" . $koneksi->error;
}

// Tutup koneksi
$koneksi->close();
?>
