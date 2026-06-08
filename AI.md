## Soru

Kullanıcı kayıt formundan gelen bilgileri veritabanına kaydeden basit bir PHP kodu örneği gösterebilir misin?

**ChatGPT:**

```php
$name = $_POST["name"];
$email = $_POST["email"];

$stmt = $pdo->prepare(
    "INSERT INTO users(name,email)
     VALUES(?,?)"
);

$stmt->execute([$name,$email]);
```

---

## Soru

Giriş yapan kullanıcının adını session'a kaydetmek için örnek kod verebilir misin?

**ChatGPT:**

```php
$_SESSION["user_id"] = $user["id"];
$_SESSION["user_name"] = $user["name"];
```

---

## Soru

PHP'de çıkış yap (logout) işlemi için örnek kod gösterebilir misin?

**ChatGPT:**

```php
session_start();

$_SESSION = array();

session_destroy();

header("Location: login.php");
exit;
```

---

## Soru

PDO hata ayarlarını açmak için hangi satırı kullanmalıyım?

**ChatGPT:**

```php
$pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);
```

---


## Soru

FTP ile hostinge bağlanırken "530 Non-anonymous sessions must use encryption" hatası aldım. Ne yapmalıyım?

**ChatGPT:**

Normal FTP yerine FTPS (FTP-SSL) kullanılması gerektiği belirtildi.

---

## Soru

Cyberduck ile dosyaları yükledim fakat site açılmıyor. İlk kontrol etmem gereken klasör hangisi?

**ChatGPT:**

Dosyaların public_html klasörüne yüklenip yüklenmediği kontrol edilmelidir.

---

## Soru

Canlı sunucuya taşıdıktan sonra veritabanı bağlantısı çalışmıyorsa ilk hangi dosyayı kontrol etmeliyim?

**ChatGPT:**

config.php dosyasındaki host, kullanıcı adı, şifre ve veritabanı bilgilerinin kontrol edilmesi gerektiği belirtildi.

---

## Soru

PDO ile aynı sorguda birden fazla koşul kullanarak kayıt çekmek için örnek verebilir misin?

**ChatGPT:**

```sql id="ygx0lb"
SELECT *
FROM pets
WHERE user_id = ?
AND species = ?;
```

---


## Soru

Kullanıcıya ait kayıt sayısını ve en son eklediği kaydı aynı anda göstermek istersem nasıl bir sorgu kullanabilirim?

**ChatGPT:**

```sql id="4lz7um"
SELECT COUNT(*) AS toplam
FROM pets
WHERE user_id = ?;
```

ve

```sql id="pk6r95"
SELECT *
FROM pets
WHERE user_id = ?
ORDER BY created_at DESC
LIMIT 1;
```

---

## Soru

PDO'da sorgunun başarılı olup olmadığını nasıl kontrol edebilirim?

**ChatGPT:**

```php id="ejp7ea"
if($stmt->execute()){
    echo "Başarılı";
}
```

---

## Soru

Veritabanında aynı e-posta ile ikinci kez kayıt olunmasını nasıl engelleyebilirim?

**ChatGPT:**

email alanına UNIQUE kısıtı eklenmesi önerildi.

---

## Soru

Bir kayıt güncellenirken önce kullanıcının o kaydın sahibi olup olmadığını nasıl kontrol edebilirim?

**ChatGPT:**

```sql id="q4gfvn"
SELECT *
FROM pets
WHERE id = ?
AND user_id = ?;
```

---

## Soru

PDO kullanırken try-catch bloğu neden kullanılmalıdır?

**ChatGPT:**

Veritabanı hatalarını yakalamak ve kullanıcıya doğrudan sistem hatası göstermemek için kullanılabilir.

---

## Soru

Tarih alanı boş bırakıldığında veritabanına NULL göndermek için nasıl bir kontrol yapılabilir?

**ChatGPT:**

```php id="lws47l"
$date =
!empty($_POST["date"])
? $_POST["date"]
: null;
```

---

## Soru

Bir kullanıcının sadece kendi kayıtlarını güncelleyebilmesini sağlayan UPDATE sorgusu nasıl yazılabilir?

**ChatGPT:**

```sql id="bzy8zj"
UPDATE pets
SET pet_name = ?
WHERE id = ?
AND user_id = ?;
```

---
