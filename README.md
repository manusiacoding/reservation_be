# Reservation Backend

Link API DOCS : `https://documenter.getpostman.com/view/23130742/2s9YynjNme`

Cara setup & menggunakan project ini :
- clone project ini menggunakan command `git clone https://github.com/manusiacoding/reservation_be.git`
- setelah itu copy & paste .env.example dan ubah namanya menjadi .env
- setelah itu jalankan command `composer install`
- jika command sebelumnya sudah selesai, jalankan command `php artisan key:generate`
- lalu, nyalakan Xampp / Lampp anda
- buat database dengan nama **testing_resto**
- jalankan command `php artisan migrate --seed` untuk menjalankan migration table & seeder
- jika sudah maka jalankan aplikasinya dengan menggunakan command `php artisan serve`
- dan yang terakhir jalankan REST API yang ada di **API DOCS**
- terima kasih.

<hr />

# Database Mapping
![alt text](https://i.ibb.co/C5rCkLR/image.png)
