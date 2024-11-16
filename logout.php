<?php
// Mulai sesi
session_start();

// Hapus semua sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Arahkan pengguna ke halaman login (atau halaman lainnya setelah logout)
header("Location: login.php");
exit();
?>
