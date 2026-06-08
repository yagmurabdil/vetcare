<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];

    $pet_name = trim($_POST["pet_name"]);
    $species = trim($_POST["species"]);
    $breed = trim($_POST["breed"]);
    $age = trim($_POST["age"]);
    $owner_name = trim($_POST["owner_name"]);
    $owner_phone = trim($_POST["owner_phone"]);
    $food_brand = trim($_POST["food_brand"]);
    $last_vaccine = $_POST["last_vaccine"];
    $next_vaccine = $_POST["next_vaccine"];
    $last_grooming = $_POST["last_grooming"];
    $diagnosis = trim($_POST["diagnosis"]);
    $treatment = trim($_POST["treatment"]);
    $notes = trim($_POST["notes"]);

    if ($pet_name == "" || $species == "") {
        $message = "Hayvan adı ve tür alanları zorunludur.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO pets 
        (user_id, pet_name, species, breed, age, owner_name, owner_phone, food_brand, last_vaccine, next_vaccine, last_grooming, diagnosis, treatment, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([$user_id, $pet_name, $species, $breed, $age, $owner_name, $owner_phone, $food_brand, $last_vaccine, $next_vaccine, $last_grooming, $diagnosis, $treatment, $notes]);

        header("Location: index.php");
        exit;
    }
}
?>

<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title>Yeni Hasta Ekle - VetCare</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background-color: #f2f3f5;
}
.navbar-custom {
    background-color: #343a40;
}
.text-orange {
    color: #f28c28;
}
.btn-orange {
    background-color: #f28c28;
    color: white;
    border: none;
}
.btn-orange:hover {
    background-color: #dd790f;
    color: white;
}
.form-card {
    border: none;
    border-radius: 22px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.section-title {
    font-weight: 700;
    color: #f28c28;
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
<div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🐾 Vet<span class="text-orange">Care</span></a>
    <div class="ms-auto">
        <a href="index.php" class="btn btn-outline-light btn-sm">Panele Dön</a>
    </div>
</div>
</nav>

<div class="container py-4">

<div class="card form-card">
<div class="card-body p-4 p-md-5">

<h3 class="text-orange mb-1">Yeni Hasta Ekle</h3>
<p class="text-muted mb-4">Kliniğe gelen hayvan hastanın sağlık, bakım ve beslenme bilgilerini kaydediniz.</p>

<?php if ($message != ""): ?>
<div class="alert alert-warning"><?php echo $message; ?></div>
<?php endif; ?>

<form method="POST">

<h5 class="section-title mb-3">Hayvan Bilgileri</h5>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Hayvan Adı</label>
        <input type="text" name="pet_name" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Türü</label>
        <input type="text" name="species" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Cinsi</label>
        <input type="text" name="breed" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Yaşı</label>
        <input type="number" name="age" class="form-control" min="0">
    </div>
</div>

<hr>

<h5 class="section-title mb-3">Sahip Bilgileri</h5>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Sahip Adı Soyadı</label>
        <input type="text" name="owner_name" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Telefon Numarası</label>
        <input type="text" name="owner_phone" class="form-control">
    </div>
</div>

<hr>

<h5 class="section-title mb-3">Beslenme ve Bakım Bilgileri</h5>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Mama Markası</label>
        <input type="text" name="food_brand" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Son Tıraş Tarihi</label>
        <input type="date" name="last_grooming" class="form-control">
    </div>
</div>

<hr>

<h5 class="section-title mb-3">Aşı Bilgileri</h5>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Son Aşı Tarihi</label>
        <input type="date" name="last_vaccine" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Sonraki Aşı Tarihi</label>
        <input type="date" name="next_vaccine" class="form-control">
    </div>
</div>

<hr>

<h5 class="section-title mb-3">Sağlık Bilgileri</h5>

<div class="mb-3">
    <label class="form-label">Teşhis</label>
    <textarea name="diagnosis" class="form-control" rows="2"></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Tedavi</label>
    <textarea name="treatment" class="form-control" rows="2"></textarea>
</div>

<div class="mb-4">
    <label class="form-label">Notlar</label>
    <textarea name="notes" class="form-control" rows="3"></textarea>
</div>

<div class="d-flex justify-content-between">
    <a href="index.php" class="btn btn-secondary">İptal</a>
    <button type="submit" class="btn btn-orange">Kaydet</button>
</div>

</form>
</div>
</div>

</div>
</body>
</html>