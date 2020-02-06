# Dinamiot
Dinamiot merupakan web dashboard dan web server untuk monitoring perangkat IoT. Dengan menambahkan perangkat baru di website, pengguna akan mendapatkan endpoint API untuk digunakan sebagai akses perangkat IoT ke web server. Pada web ini, setiap perangkat memilki dashboardnya sendiri. Terdapat dua kategori untuk komponen perangkat, yaitu komponen dengan jenis analog dan digital, contohnya: Generator memiliki 3 komponen yang akan dimonitoring, yaitu: Suhu (analog), Bahan Bakar (analog), Kipas pendingin (digital). Pada dashboard Generator, komponen suhu dan bahan bakar akan ditampilkan dalam bentu Chart Line dan Gauge Chart, sedangkan komponen kipas pendingin akan ditampilkan dalam bentuk panel yang menunjukan status ON atau OFF.

- [Dinamiot](#dinamiot)
    - [Installation](#installation)
        - [Clone Project](#clone-project)
        - [Update Composer](#update-composer)
        - [Configure Env](#configure-env)
        
## Installation
Pastikan anda sudah memiliki MongoDB PHP Driver. Anda bisa melihat petunjuk instalasi di http://php.net/manual/en/mongodb.installation.php

### Clone Project
```
$ https://github.com/jeffsuto/dinamiot.git
```
### Update Composer
Setelah melakukan cloning project, masuklah ke direktori project dinamiot. Setelah masuk ke dalam direktori, jalankan perintah dibawah ini untuk mengupdate package laravel.
```
$ composer update
```
### Configure Env
Pada file ```.env.example```, ubah nama file tersebut menjadi ```.env```. Lakukan konfigurasi file .env berikut jika terdapat ketidak sesuaian dengan lingkungan sistem anda.
```
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=db_devices_monitoring
DB_USERNAME=
DB_PASSWORD=
```
