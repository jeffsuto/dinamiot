# Dinamiot
Dinamiot merupakan web dashboard dan web server untuk monitoring perangkat IoT secara realtime. Dengan menambahkan perangkat baru di website, pengguna akan mendapatkan endpoint API untuk digunakan sebagai akses perangkat IoT ke web server. Pada web ini, setiap perangkat memilki dashboardnya sendiri. Terdapat dua kategori untuk komponen perangkat, yaitu komponen dengan jenis analog dan digital, contohnya: Generator memiliki 3 komponen yang akan dimonitoring, yaitu: Suhu (analog), Bahan Bakar (analog), Kipas pendingin (digital). Pada dashboard Generator, komponen suhu dan bahan bakar akan ditampilkan dalam bentu Chart Line dan Gauge Chart, sedangkan komponen kipas pendingin akan ditampilkan dalam bentuk panel yang menunjukan status ON atau OFF.

- [Dinamiot](#dinamiot)
    - [Installation](#installation)
        - [Clone Project](#clone-project)
        - [Update Composer](#update-composer)
        - [Install NPM Package](#install-npm-package)
        - [Configure Env](#configure-env)
        - [Finishing](#finishing)
    - [Useage](#useage)
        - [Laravel 
        
## Installation
Pastikan anda sudah memiliki MongoDB PHP Driver. Jika anda belum memiliki, silahkan melihat petunjuk instalasi di http://php.net/manual/en/mongodb.installation.php

### Clone Project
```
$ https://github.com/jeffsuto/dinamiot.git
```
### Update Composer
Setelah melakukan cloning project, masuklah ke direktori project dinamiot. Setelah masuk ke dalam direktori, jalankan perintah dibawah ini untuk mengupdate package laravel.

Pastikan anda sudah menginstall composer. Jika anda belum menginstal, silahkan melihat petunjuk intalasi di https://getcomposer.org/doc/00-intro.md.
```
$ composer update
```
### Install NPM Package
Beberapa package node.js dibutuhkan pada project ini untuk proses menampilkan secara realtime data. Package node.js yang dibutuhkan antara lain:
- socket.io
```
$ npm install socket.io
```
- redis
```
$ npm install redis
```
- dotenv
```
$ npm install dotenv
```
### Configure Env
Pada file ```.env.example```, ubah nama file tersebut menjadi ```.env```.

*Anda dapat melewati langkah ini jika nilai - nilai yang ada di file ```.env``` ini tidak memiliki masalah pada sistem operasi anda.

Lakukan konfigurasi database pada file .env berikut jika terdapat ketidak sesuaian dengan konfigurasi database pada sistem anda.
```
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=db_devices_monitoring
DB_USERNAME=
DB_PASSWORD=
```
Lakukan konfigurasi redis jika terdapat ketidak sesuaian dengan konfigurasi redis pada sistem anda. 
```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```
Anda dapat mengubah nilai port pada ```SOCKET_PORT``` jika nilai PORT pada file .env ini sudah digunakan di sistem operasi anda.
```
SOCKET_PORT=1997
```
### Finishing
Setelah melakukan konfigurasi pada file ```.env```, jalankan perintah berikut ini pada command line:
- Clear config and cache laravel
```
$ php artisan config:cache

$ php artisan config:clear
```
- Migrating database
```
$ php artisan migrate
```
