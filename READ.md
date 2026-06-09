
# VetCare - Veteriner Hasta ve Bakım Takip Sistemi

## Proje Tanıtımı

VetCare, veteriner kliniklerinde hayvan hastaların kayıtlarının tutulması ve takip edilmesi amacıyla geliştirilmiş web tabanlı bir yönetim sistemidir.

Proje kapsamında kullanıcılar sisteme kayıt olabilir, güvenli şekilde giriş yapabilir ve kendilerine ait hayvan hasta kayıtlarını oluşturabilir, görüntüleyebilir, güncelleyebilir ve silebilirler.

Uygulama Bursa Teknik Üniversitesi Web Tabanlı Programlama dersi kapsamında PHP ve MySQL kullanılarak geliştirilmiştir.

---

## Kullanılan Teknolojiler

* PHP
* MySQL / MariaDB
* HTML5
* CSS3
* Bootstrap 5
* PDO
* PHP Session


## Proje Özellikleri

### Kullanıcı İşlemleri

* Kullanıcı kaydı oluşturma
* Şifreli giriş sistemi
* Oturum açma
* Oturum kapatma
* Session tabanlı kullanıcı doğrulama

### Hasta Yönetimi (CRUD)

#### Create

Yeni hayvan hasta kaydı ekleme

#### Read

Kayıtlı hayvan hastaları listeleme

#### Update

Mevcut hasta bilgilerini güncelleme

#### Delete

Hasta kayıtlarını silme

## Tutulan Bilgiler

Sistem içerisinde her hayvan için aşağıdaki bilgiler saklanabilmektedir:

### Hayvan Bilgileri

* Hayvan adı
* Tür
* Cins
* Yaş

### Sahip Bilgileri

* Sahip adı soyadı
* Telefon numarası

### Bakım Bilgileri

* Mama markası
* Son tıraş tarihi

### Aşı Bilgileri

* Son aşı tarihi
* Sonraki aşı tarihi
* Aşı durum takibi

### Sağlık Bilgileri

* Teşhis
* Tedavi
* Notlar


## Güvenlik Özellikleri

* Kullanıcı şifreleri veritabanında düz metin olarak tutulmamaktadır.
* Şifreler `password_hash()` fonksiyonu ile hashlenerek saklanmaktadır.
* Giriş işlemlerinde `password_verify()` kullanılmaktadır.
* Kullanıcı oturumları PHP Session yapısı ile yönetilmektedir.
* Kullanıcılar yalnızca kendi oluşturdukları kayıtları görüntüleyebilir ve düzenleyebilir.

---

## Dosya Yapısı

add_pet.php        -> Yeni hasta ekleme ekranı

config.php         -> Veritabanı bağlantı ayarları

delete_pet.php     -> Hasta silme işlemi

edit_pet.php       -> Hasta güncelleme işlemi

index.php          -> Yönetim paneli

login.php          -> Kullanıcı giriş ekranı

logout.php         -> Oturum kapatma işlemi

register.php       -> Kullanıcı kayıt ekranı

test.php           -> Veritabanı bağlantı testi

login-bg.png       -> Giriş ve kayıt ekranı arka plan görseli

dashboard.png      -> Yönetim paneli arka plan görseli


---

## Veritabanı Yapısı

### users

Kullanıcı bilgilerini saklar.

Alanlar:

* id
* name
* email
* password_hash

### pets

Hayvan hasta bilgilerini saklar.

Alanlar:

* id
* user_id
* pet_name
* species
* breed
* age
* owner_name
* owner_phone
* food_brand
* last_vaccine
* next_vaccine
* last_grooming
* diagnosis
* treatment
* notes
* created_at

---

## Ekran Görüntüleri

### Giriş Ekranı



<img width="1440" height="801" alt="Ekran Resmi 2026-06-09 00 09 32" src="https://github.com/user-attachments/assets/a11f44b4-9f97-4965-ab46-0b582ba1875d" />
<img width="1439" height="809" alt="Ekran Resmi 2026-06-09 00 08 59" src="https://github.com/user-attachments/assets/d055c294-013b-4ae9-ad2b-1c8938a7cda5" />


### Yönetim Paneli

<img width="1432" height="791" alt="Ekran Resmi 2026-06-09 00 16 06" src="https://github.com/user-attachments/assets/6074e273-776d-4ae4-8dec-7be1a2b10705" />


---

## Demo Videosu

Video bağlantısı:[Demo Videosu]https://youtu.be/U3eEIWLo1Qw?si=R9X2Q4Vo9sFSP6h9



---

## Kurulum

1. Proje dosyalarını sunucuya yükleyiniz.
2. MySQL/MariaDB veritabanını oluşturunuz.
3. users ve pets tablolarını oluşturunuz.
4. config.php dosyasındaki veritabanı ayarlarını düzenleyiniz.
5. Uygulamayı çalıştırınız.

---

## Geliştirenler

**YAĞMUR DERİN ABDİL-22360859069**
**NUR KÖM-23360859079**
---

