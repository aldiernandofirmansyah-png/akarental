<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver Sesi Default
    |--------------------------------------------------------------------------
    |
    | Opsi ini menentukan driver sesi default yang digunakan untuk
    | permintaan masuk. Laravel mendukung berbagai opsi penyimpanan untuk
    | menyimpan data sesi. Penyimpanan basis data adalah pilihan default yang baik.
    |
    | Didukung: "file", "cookie", "database", "memcached",
    |            "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Masa Berlaku Sesi
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan jumlah menit yang Anda inginkan agar sesi
    | diizinkan untuk tetap tidak aktif sebelum kedaluwarsa. Jika Anda ingin sesi
    | kedaluwarsa segera setelah browser ditutup, Anda dapat
    | menunjukkannya melalui opsi konfigurasi expire_on_close.
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Enkripsi Sesi
    |--------------------------------------------------------------------------
    |
    | Opsi ini memungkinkan Anda untuk dengan mudah menentukan bahwa semua data sesi Anda
    | harus dienkripsi sebelum disimpan. Semua enkripsi dilakukan
    | secara otomatis oleh Laravel dan Anda dapat menggunakan sesi seperti biasa.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Lokasi File Sesi
    |--------------------------------------------------------------------------
    |
    | Saat menggunakan driver sesi "file", file sesi ditempatkan
    | pada disk. Lokasi penyimpanan default didefinisikan di sini; namun,
    | Anda bebas untuk menyediakan lokasi lain tempat file tersebut harus disimpan.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Koneksi Basis Data Sesi
    |--------------------------------------------------------------------------
    |
    | Saat menggunakan driver sesi "database" atau "redis", Anda dapat menentukan
    | koneksi yang harus digunakan untuk mengelola sesi ini. Ini harus
    | sesuai dengan koneksi dalam opsi konfigurasi basis data Anda.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Tabel Basis Data Sesi
    |--------------------------------------------------------------------------
    |
    | Saat menggunakan driver sesi "database", Anda dapat menentukan tabel untuk
    | digunakan untuk menyimpan sesi. Tentu saja, default yang wajar didefinisikan
    | untuk Anda; namun, Anda dipersilakan untuk mengubah ini ke tabel lain.
    |
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Penyimpanan Cache Sesi
    |--------------------------------------------------------------------------
    |
    | Saat menggunakan salah satu backend sesi berbasis cache, Anda dapat
    | menentukan penyimpanan cache yang harus digunakan untuk menyimpan data sesi
    | di antara permintaan. Ini harus sesuai dengan salah satu penyimpanan cache Anda yang ditentukan.
    |
    | Mempengaruhi: "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Lotere Pembersihan Sesi
    |--------------------------------------------------------------------------
    |
    | Beberapa driver sesi harus membersihkan lokasi penyimpanan mereka secara manual untuk
    | menyingkirkan sesi lama dari penyimpanan. Berikut adalah peluang terjadinya hal tersebut
    | pada permintaan tertentu. Secara default, peluangnya adalah 2 dari 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nama Cookie Sesi
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat mengubah nama cookie sesi yang dibuat oleh
    | framework. Biasanya, Anda tidak perlu mengubah nilai ini
    | karena melakukannya tidak memberikan peningkatan keamanan yang berarti.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Jalur Cookie Sesi
    |--------------------------------------------------------------------------
    |
    | Jalur cookie sesi menentukan jalur di mana cookie akan
    | dianggap tersedia. Biasanya, ini adalah jalur root dari
    | aplikasi Anda, tetapi Anda bebas mengubah ini jika diperlukan.
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Domain Cookie Sesi
    |--------------------------------------------------------------------------
    |
    | Nilai ini menentukan domain dan subdomain yang tersedia untuk cookie sesi.
    | Secara default, cookie akan tersedia untuk domain root
    | tanpa subdomain. Biasanya, ini tidak perlu diubah.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Cookie Hanya HTTPS
    |--------------------------------------------------------------------------
    |
    | Dengan mengatur opsi ini ke true, cookie sesi hanya akan dikirim kembali
    | ke server jika browser memiliki koneksi HTTPS. Ini akan menjaga
    | cookie agar tidak dikirim kepada Anda saat tidak dapat dilakukan dengan aman.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | Hanya Akses HTTP
    |--------------------------------------------------------------------------
    |
    | Mengatur nilai ini ke true akan mencegah JavaScript mengakses
    | nilai cookie dan cookie hanya akan dapat diakses melalui
    | protokol HTTP. Tidak disarankan untuk menonaktifkan opsi ini.
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Cookie Same-Site
    |--------------------------------------------------------------------------
    |
    | Opsi ini menentukan bagaimana cookie Anda berperilaku saat permintaan lintas situs
    | terjadi, dan dapat digunakan untuk memitigasi serangan CSRF. Secara default,
    | kami akan mengatur nilai ini ke "lax" untuk mengizinkan permintaan lintas situs yang aman.
    |
    | Lihat: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
    |
    | Didukung: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Cookie Terpartisi
    |--------------------------------------------------------------------------
    |
    | Mengatur nilai ini ke true akan mengaitkan cookie dengan situs tingkat atas untuk
    | konteks lintas situs. Cookie terpartisi diterima oleh browser
    | saat ditandai "secure" dan atribut Same-Site diatur ke "none".
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
