<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];

$stmt = $pdo->prepare("SELECT * FROM pets WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

function vaccineStatus($next_vaccine) {
    if ($next_vaccine == "" || $next_vaccine == null) {
        return ["Belirtilmedi", "secondary"];
    }

    $today = new DateTime();
    $vaccineDate = new DateTime($next_vaccine);
    $diff = (int)$today->diff($vaccineDate)->format("%r%a");

    if ($diff < 0) {
        return ["Aşı Gecikmiş", "danger"];
    } elseif ($diff <= 7) {
        return ["Aşı Yaklaşıyor", "warning"];
    } else {
        return ["Güncel", "success"];
    }
}
?>

<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title>VetCare Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background-color: #f2f3f5;
    font-family: Arial, sans-serif;
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
.panel-card, .table-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.table-card {
    overflow: hidden;
}
.table thead th {
    background-color: #343a40;
    color: white;
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
<div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🐾 Vet<span class="text-orange">Care</span></a>

    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-white">Hoş geldiniz, <?php echo htmlspecialchars($user_name); ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Çıkış Yap</a>
    </div>
</div>
</nav>

<div class="container py-4">

<div class="card panel-card mb-4">
<div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h3 class="mb-1 text-orange">Veteriner Hasta Kayıtları</h3>
        <p class="text-muted mb-0">Hayvan hastaların aşı, bakım, beslenme ve tedavi bilgilerini buradan takip edebilirsiniz.</p>
    </div>

    <a href="add_pet.php" class="btn btn-orange">+ Yeni Hasta Ekle</a>
</div>
</div>

<?php if (count($pets) == 0): ?>

<div class="alert alert-warning">
    Henüz kayıtlı hayvan hasta bulunmamaktadır. İlk kaydı eklemek için <strong>Yeni Hasta Ekle</strong> butonunu kullanabilirsiniz.
</div>

<?php else: ?>

<div class="card table-card">
<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
<thead>
<tr>
    <th>Hayvan</th>
    <th>Tür / Cins</th>
    <th>Sahip</th>
    <th>Mama</th>
    <th>Sonraki Aşı</th>
    <th>Aşı Durumu</th>
    <th class="text-end">İşlemler</th>
</tr>
</thead>

<tbody>
<?php foreach ($pets as $pet): ?>
<?php $status = vaccineStatus($pet["next_vaccine"]); ?>

<tr>
    <td>
        <strong><?php echo htmlspecialchars($pet["pet_name"]); ?></strong><br>
        <small class="text-muted">Yaş: <?php echo htmlspecialchars($pet["age"]); ?></small>
    </td>

    <td>
        <?php echo htmlspecialchars($pet["species"]); ?><br>
        <small class="text-muted"><?php echo htmlspecialchars($pet["breed"]); ?></small>
    </td>

    <td>
        <?php echo htmlspecialchars($pet["owner_name"]); ?><br>
        <small class="text-muted"><?php echo htmlspecialchars($pet["owner_phone"]); ?></small>
    </td>

    <td><?php echo htmlspecialchars($pet["food_brand"]); ?></td>

    <td><?php echo htmlspecialchars($pet["next_vaccine"]); ?></td>

    <td>
        <span class="badge bg-<?php echo $status[1]; ?>">
            <?php echo $status[0]; ?>
        </span>
    </td>

    <td class="text-end">
        <a href="edit_pet.php?id=<?php echo $pet["id"]; ?>" class="btn btn-orange btn-sm">Düzenle</a>
        <a href="delete_pet.php?id=<?php echo $pet["id"]; ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Bu kaydı silmek istediğinizden emin misiniz?');">Sil</a>
    </td>
</tr>

<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<?php endif; ?>

</div>
</body>
</html>