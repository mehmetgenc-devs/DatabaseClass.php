# PHP MySQL DB Class

Bu class, PHP ile MySQL veritabanına kolayca bağlanmanızı, veri eklemenizi (insert), güncellemenizi (update) ve sorgu yapmanızı (query) sağlayan basit bir veritabanı arabirimidir.

## Özellikler

- MySQL veritabanına kolay bağlantı
- `SELECT` sorguları için `query()` metodu
- `INSERT` işlemleri için `insert()` metodu
- `UPDATE` işlemleri için `update()` metodu
- `DELETE` işlemleri için `delete()` metodu
- `INSERT/UPDATE/DELETE` gibi özel sorgular için `q()` metodu
- UTF-8 (utf8mb4) desteği
- Try/catch yapısıyla hata yönetimi
- Türkiye saat dilimi desteği (Europe/Istanbul)

## Kurulum

1. `db.php` gibi bir dosya oluşturup aşağıdaki kodu içine yapıştırın.
2. Veritabanı bilgilerinizi `__construct()` içindeki `$user`, `$password`, `$database`, `$host` alanlarında güncelleyin.

## Kullanım

```php
<?php
require_once 'db.php';

// SELECT örneği
$users = $db->query("SELECT * FROM users");
print_r($users);

// INSERT örneği
$new_users = [
    'name' => 'Mehmet',
    'email' => 'mehmet@muzik.red'
];
$db->insert('users', $new_users);

// UPDATE örneği
$guncelle = [
    'name' => 'Mehmet Genç'
];
$db->update('users', $guncelle, "id = 1");

// Özel sorgu örneği
$db->delete('users', 'id = 1');
