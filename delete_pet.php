<?php
session_start();
require "config.php";

// Giriş kontrolü
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// URL'den gelen bir ID var mı ve sayı mı kontrol et
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $pet_id = $_GET["id"];
    $user_id = $_SESSION["user_id"];

    try {
        // GÜVENLİK: Sadece bu kullanıcıya ait olan hayvanı sil
        $stmt = $pdo->prepare("DELETE FROM pets WHERE id = ? AND user_id = ?");
        $stmt->execute([$pet_id, $user_id]);

        // İşlem başarılıysa panele geri dön
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        die("Silme işlemi sırasında bir hata oluştu: " . $e->getMessage());
    }
} else {
    // Geçersiz ID durumunda panele yönlendir
    header("Location: index.php");
    exit;
}
?>