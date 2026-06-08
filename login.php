<?php
session_start();
require "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($email == "" || $password == "") {
        $message = "Lütfen e-posta ve şifre alanlarını doldurunuz.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password_hash"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: index.php");
            exit;
        } else {
            $message = "E-posta veya şifre hatalı.";
        }
    }
}
?>

<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title>Giriş Yap - VetCare</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
    background-color: rgba(255,255,255,0.18);
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
    background-color: rgba(255,255,255,0.94);
    backdrop-filter: blur(6px);
}
.brand-icon {
    font-size: 38px;
}
.brand-title {
    font-weight: 700;
}
.btn-orange {
    background-color: #f28c28;
    color: white;
}
.btn-orange:hover {
    background-color: #dd790f;
    color: white;
}
.text-orange {
    color: #f28c28;
}
</style>
</head>

<body>
<div class="page-overlay">
<div class="card shadow-lg auth-card">
<div class="card-body p-4 p-md-5">

<div class="text-center mb-4">
    <div class="brand-icon mb-2">🐾</div>
    <h3 class="brand-title mb-1">
        <span class="text-dark">Vet</span><span class="text-orange">Care</span>
    </h3>
    <p class="text-muted mb-0">Veteriner Hasta ve Bakım Takip Sistemi</p>
</div>

<?php if ($message != ""): ?>
<div class="alert alert-danger"><?php echo $message; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">E-posta</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Şifre</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-orange w-100 py-2">Giriş Yap</button>
</form>

<p class="text-center mt-4 mb-0">
    Hesabınız yok mu?
    <a href="register.php" class="text-orange fw-semibold text-decoration-none">Kayıt olun</a>
</p>

</div>
</div>
</div>
</body>
</html>