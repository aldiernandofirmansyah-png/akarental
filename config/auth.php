<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Autentikasi
    |--------------------------------------------------------------------------
    |
    | Opsi ini mendefinisikan "guard" autentikasi default dan "broker" 
    | reset password untuk aplikasi Anda. Anda dapat mengubah nilai-nilai ini
    | sesuai kebutuhan, namun nilai ini sudah sangat pas untuk sebagian besar aplikasi.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Autentikasi Guards
    |--------------------------------------------------------------------------
    |
    | Selanjutnya, Anda dapat mendefinisikan setiap guard autentikasi untuk aplikasi Anda.
    | Tentu saja, konfigurasi default yang hebat telah ditetapkan untuk Anda
    | yang menggunakan penyimpanan sesi serta penyedia pengguna Eloquent.
    |
    | Semua guard autentikasi memiliki penyedia pengguna, yang mendefinisikan bagaimana
    | pengguna sebenarnya diambil dari basis data atau sistem penyimpanan lainnya
    | yang digunakan oleh aplikasi. Biasanya, Eloquent digunakan.
    |
    | Didukung: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Semua guard autentikasi memiliki penyedia pengguna, yang mendefinisikan bagaimana
    | pengguna sebenarnya diambil dari basis data atau sistem penyimpanan lainnya
    | yang digunakan oleh aplikasi. Biasanya, Eloquent digunakan.
    |
    | Jika Anda memiliki banyak tabel atau model pengguna, Anda dapat mengonfigurasi banyak
    | penyedia untuk mewakili model / tabel tersebut. Penyedia ini kemudian dapat
    | ditetapkan ke guard autentikasi tambahan yang telah Anda definisikan.
    |
    | Didukung: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Opsi konfigurasi ini menentukan perilaku fungsi reset password Laravel,
    | termasuk tabel yang digunakan untuk penyimpanan token
    | dan penyedia pengguna yang dipanggil untuk mengambil pengguna.
    |
    | Waktu kedaluwarsa adalah jumlah menit setiap token reset akan
    | dianggap valid. Fitur keamanan ini menjaga token berumur pendek sehingga
    | mereka memiliki waktu lebih sedikit untuk ditebak. Anda dapat mengubah ini sesuai kebutuhan.
    |
    | Pengaturan throttle adalah jumlah detik yang harus ditunggu pengguna sebelum
    | menghasilkan token reset password lagi. Ini mencegah pengguna untuk
    | dengan cepat menghasilkan sejumlah besar token reset password.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TOKEN', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan jumlah detik sebelum jendela konfirmasi
    | password kedaluwarsa dan pengguna diminta untuk memasukkan kembali password mereka
    | melalui layar konfirmasi. Secara default, timeout berlangsung selama tiga jam.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
