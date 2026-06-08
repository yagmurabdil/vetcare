<?php
session_start();
require "config.php";

// Giriş kontrolü
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$message = "";
$success_message = "";

// 1. ADIM: Düzenlenecek hayvanın mevcut verilerini veritabanından çek (GET)
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$pet_id = $_GET["id"];

// GÜVENLİK: Sadece giriş yapan kullanıcıya ait mi kontrol et
$stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ? AND user_id = ?");
$stmt->execute([$pet_id, $user_id]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

// Eğer böyle bir hayvan yoksa veya kullanıcıya ait değilse panele postala
if (!$pet) {
    header("Location: index.php");
    exit;
}

// 2. ADIM: Form gönderildiğinde güncelleme işlemini yap (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_name     = trim($_POST["pet_name"]);
    $species      = trim($_POST["species"]);
    $breed        = trim($_POST["breed"]);
    $age          = trim($_POST["age"]);
    $owner_name   = trim($_POST["owner_name"]);
    $owner_phone  = trim($_POST["owner_phone"]);
    $food_brand   = trim($_POST["food_brand"]);
    $diagnosis    = trim($_POST["diagnosis"]);
    $treatment    = trim($_POST["treatment"]);
    $notes        = trim($_POST["notes"]);

    // PHP Aşamasında Boş Tarih Kontrolleri (Veritabanına NULL basabilmek için)
    $last_vaccine  = !empty($_POST["last_vaccine"])  ? $_POST["last_vaccine"]  : null;
    $next_vaccine  = !empty($_POST["next_vaccine"])  ? $_POST["next_vaccine"]  : null;
    $last_grooming = !empty($_POST["last_grooming"]) ? $_POST["last_grooming"] : null;

    if ($pet_name == "" || $species == "") {
        $message = "Hayvan adı ve tür alanları zorunludur.";
    } else {
        try {
            $sql = "UPDATE pets SET 
                    pet_name = ?, species = ?, breed = ?, age = ?, 
                    owner_name = ?, owner_phone = ?, food_brand = ?, 
                    last_vaccine = ?, next_vaccine = ?, last_grooming = ?, 
                    diagnosis = ?, treatment = ?, notes = ? 
                    WHERE id = ? AND user_id = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $pet_name, $species, $breed, $age, 
                $owner_name, $owner_phone, $food_brand, 
                $last_vaccine, $next_vaccine, $last_grooming, 
                $diagnosis, $treatment, $notes,
                $pet_id, $user_id
            ]);

            // Verileri güncelledikten sonra formda yeni verilerin görünmesi için local değişkeni de güncelle
            $success_message = "Hasta bilgileri başarıyla güncellendi!";
            
            // Güncel verileri tekrar çek
            $stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ? AND user_id = ?");
            $stmt->execute([$pet_id, $user_id]);
            $pet = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $message = "Güncelleme hatası: " . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title>Hasta Düzenle - VetCare</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel=\"stylesheet\">

<style>
body {
    background-color: #f8f9fa;
}
.navbar-custom {
    background-color: #f28c28;
}
.btn-orange {
    background-color: #f28c28;
    color: white;
}
.btn-orange:hover {
    background-color: #dd790f;
    color: white;
}
.section-title {
    color: #f28c28;
    border-left: 4px solid #f28c28;
    padding-left: 8px;
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🐾 VetCare</a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light btn-sm">Panele Dön</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold text-dark">Hasta Kartını Düzenle: <?php echo htmlspecialchars($pet["pet_name"]); ?></h4>
        </div>
        <div class="card-body p-4">

            <?php if ($message != ""): ?>
                <div class="alert alert-danger"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($success_message != ""): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <h5 class="section-title mb-3">Temel Bilgiler</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hayvan Adı *</label>
                        <input type="text" name="pet_name" class="form-control" value="<?php echo htmlspecialchars($pet["pet_name"]); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tür * (Ön: Kedi, Köpek)</label>
                        <input type="text" name="species" class="form-control" value="<?php echo htmlspecialchars($pet["species"]); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cins / Irk</label>
                        <input type="text" name="breed" class="form-control" value="<?php echo htmlspecialchars($pet["breed"]); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Yaş</label>
                        <input type="text" name="age" class="form-control" value="<?php echo htmlspecialchars($pet["age"]); ?>">
                    </div>
                </div>

                <hr>
                <h5 class="section-title mb-3">Sahip Bilgileri</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sahibinin Adı Soyadı</label>
                        <input type="text" name="owner_name" class="form-control" value="<?php echo htmlspecialchars($pet["owner_name"]); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sahibinin Telefonu</label>
                        <input type="text" name="owner_phone" class="form-control" value="<?php echo htmlspecialchars($pet["owner_phone"]); ?>">
                    </div>
                </div>

                <hr>
                <h5 class="section-title mb-3">Bakım Bilgileri</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mama Markası</label>
                        <input type="text" name="food_brand" class="form-control" value="<?php echo htmlspecialchars($pet["food_brand"]); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Son Tıraş Tarihi</label>
                        <input type="date" name="last_grooming" class="form-control" value="<?php echo $pet["last_grooming"]; ?>">
                    </div>
                </div>

                <hr>
                <h5 class="section-title mb-3">Aşı Bilgileri</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Son Aşı Tarihi</label>
                        <input type="date" name="last_vaccine" class="form-control" value="<?php echo $pet["last_vaccine"]; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sonraki Aşı Tarihi</label>
                        <input type="date" name="next_vaccine" class="form-control" value="<?php echo $pet["next_vaccine"]; ?>">
                    </div>
                </div>

                <hr>
                <h5 class="section-title mb-3">Sağlık Bilgileri</h5>
                <div class="mb-3">
                    <label class="form-label">Teşhis</label>
                    <textarea name="diagnosis" class="form-control" rows="2"><?php echo htmlspecialchars($pet["diagnosis"]); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tedavi</label>
                    <textarea name="treatment" class="form-control" rows="2"><?php echo htmlspecialchars($pet["treatment"]); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notlar</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo htmlspecialchars($pet["notes"]); ?></textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-orange px-5">Değişiklikleri Kaydet</button>
                    <a href="index.php" class="btn btn-secondary px-4 ms-2">İptal Et</a>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>