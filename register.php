<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require "config.php";


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($name == "" || $email == "" || $password == "") {
        $message = "Lütfen tüm alanları doldurunuz.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $password_hash]);

            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $message = "Bu e-posta adresi zaten kayıtlı olabilir.";
        }
    }
}
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>Kayıt Ol - VetCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS kütüphanesi -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background-image: url("login-bg.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .page-overlay {
            min-height: 100vh;
            background-color: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 22px;
            background-color: rgba(255, 255, 255, 0.93);
            backdrop-filter: blur(6px);
        }

        .brand-icon {
            font-size: 38px;
            line-height: 1;
        }

        .brand-title {
            font-weight: 700;
            letter-spacing: 0.3px;
        }
    </style>
</head>

<body>

<div class="page-overlay">
    <div class="card shadow-lg auth-card">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <div class="brand-icon mb-2">🐾</div>
                <h3 class="text-success brand-title mb-1">VetCare</h3>
                <p class="text-muted mb-0">Veteriner Hasta ve Bakım Takip Sistemi</p>
            </div>

            <?php if ($message != ""): ?>
                <div class="alert alert-warning">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Ad Soyad</label>
                    <input type="text" name="name" class="form-control" placeholder="Adınızı ve soyadınızı giriniz" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">E-posta</label>
                    <input type="email" name="email" class="form-control" placeholder="ornek@mail.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Şifre</label>
                    <input type="password" name="password" class="form-control" placeholder="Şifrenizi giriniz" required>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2">
                    Kayıt Ol
                </button>
            </form>

            <p class="text-center mt-4 mb-0">
                Zaten hesabınız var mı?
                <a href="login.php" class="text-success fw-semibold text-decoration-none">Giriş yapın</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>