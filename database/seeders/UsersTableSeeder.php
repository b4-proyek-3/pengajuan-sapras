<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['name' => 'Muammar Syarif Alghifari', 'email' => 'MPM@POLBAN.AC.ID', 'nim' => '225134015', 'ormawa' => 'Majelis Perwakilan Mahasiswa (MPM)'],
            ['name' => 'Thian Giovani Mubarak', 'email' => 'BEM@POLBAN.AC.ID', 'nim' => '221734028', 'ormawa' => 'Badan Eksekutif Mahasiswa (BEM)'],
            ['name' => 'Jhonassen Morientes Situmorang', 'email' => 'HMJTS@POLBAN.AC.ID', 'nim' => '221210044', 'ormawa' => 'HMJ Teknik Sipil'],
            ['name' => 'Hilmy Fauzi', 'email' => 'HMJTM@POLBAN.AC.ID', 'nim' => '221234025', 'ormawa' => 'HMJ Teknik Mesin'],
            ['name' => 'Muhammad Rizki', 'email' => 'HMJTE@POLBAN.AC.ID', 'nim' => '221311051', 'ormawa' => 'HMJ Teknik Elektro'],
            ['name' => 'Muhammad Syauqi Hakami', 'email' => 'HMJTK@POLBAN.AC.ID', 'nim' => '221410088', 'ormawa' => 'HMJ Teknik Kimia'],
            ['name' => 'Farrel Keiza Muhammad Yamin Putra', 'email' => 'HMJTKI@POLBAN.AC.ID', 'nim' => '221524009', 'ormawa' => 'HMJ Teknik Komputer dan Informatika'],
            ['name' => 'Azka Azrial Mutaqin', 'email' => 'HMJTRA@POLBAN.AC.ID', 'nim' => '221624007', 'ormawa' => 'HMJ Teknik Refrigerasi dan Tata Udara'],
            ['name' => 'M. Syawal Fauzi', 'email' => 'HMJTKE@POLBAN.AC.ID', 'nim' => '221734018', 'ormawa' => 'HMJ Teknik Konversi Energi'],
            ['name' => 'Tri Wisnu Nurjaman', 'email' => 'HMJA@POLBAN.AC.ID', 'nim' => '225110032', 'ormawa' => 'HMJ Akuntansi'],
            ['name' => 'Gena Firdaus Mulyana', 'email' => 'HMJAN@POLBAN.AC.ID', 'nim' => '225311104', 'ormawa' => 'HMJ Administrasi Niaga'],
            ['name' => 'Azalia Aryani', 'email' => 'HMJBI@POLBAN.AC.ID', 'nim' => '225311036', 'ormawa' => 'HMJ Bahasa Inggris'],
            ['name' => 'Muhammad Rizki', 'email' => 'UKM-ROBOTIKA@POLBAN.AC.ID', 'nim' => '221311050', 'ormawa' => 'UKM Robotika'],
            ['name' => 'Dhiwa Febri Pratama', 'email' => 'UKM-OTOMOTIF@POLBAN.AC.ID', 'nim' => '221234008', 'ormawa' => 'UKM Otomotif'],
            ['name' => 'Muhammad Raihan Fasya Mian', 'email' => 'UKM-WIRUS@POLBAN.AC.ID', 'nim' => '221524020', 'ormawa' => 'UKM Kewirausahaan'],
            ['name' => 'Mia Puji Lestari', 'email' => 'UKM-ELTRAS@POLBAN.AC.ID', 'nim' => '225121018', 'ormawa' => 'UKM The Education and Entertainment Line Transmitter Radio Stations (ELTRAS)'],
            ['name' => 'Fathurrahim Zulkarnain', 'email' => 'UKM-ASSALAM@POLBAN.AC.ID', 'nim' => '221734041', 'ormawa' => 'UKM Asosiasi Mahasiswa Islam (Assalam)'],
            ['name' => 'Michael Christian Tambunan', 'email' => 'UKM-PMK@POLBAN.AC.ID', 'nim' => '221210048', 'ormawa' => 'UKM Persekutuan Mahasiswa Kristen (PMK)'],
            ['name' => 'Alexander Immanuel', 'email' => 'UKM-KMK@POLBAN.AC.ID', 'nim' => '221144003', 'ormawa' => 'UKM Keluarga Mahasiswa Katholik (KMK)'],
            ['name' => 'Putera Rizki Firdaus Al Rauf', 'email' => 'UKM-KABAYAN@POLBAN.AC.ID', 'nim' => '225210023', 'ormawa' => 'UKM Kebudayaan Baraya Sunda (Kabayan)'],
            ['name' => 'Reza Firmansyah', 'email' => 'UKM-PSM@POLBAN.AC.ID', 'nim' => '225231025', 'ormawa' => 'UKM Paduan Suara Mahasiswa (PSM)'],
            ['name' => 'Valdi Aditya Djuharjana', 'email' => 'UKM-MUSKING@POLBAN.AC.ID', 'nim' => '225231102', 'ormawa' => 'UKM Musik dan Teater'],
            ['name' => 'Ilham Muhammad Yusuf', 'email' => 'UKM-UKBM@POLBAN.AC.ID', 'nim' => '225134046', 'ormawa' => 'UKM Unit Kesenian Budaya Minang (UKBM)'],
            ['name' => 'Jhonatan Pratama Siahaan', 'email' => 'UKM-UBSU@POLBAN.AC.ID', 'nim' => '225134049', 'ormawa' => 'UKM Unit Budaya & Seni Sumatera Utara (UBSU)'],
            ['name' => 'Isa Munajar', 'email' => 'UKM-USF@POLBAN.AC.ID', 'nim' => '221210243', 'ormawa' => 'UKM Sepak Bola dan Futsal (USF)'],
            ['name' => 'Dara Muthazar Bachtiar', 'email' => 'UKM-BASKET@POLBAN.AC.ID', 'nim' => '225231010', 'ormawa' => 'UKM Bola Basket'],
            ['name' => 'Ade Tri Verawati', 'email' => 'UKM-VOLLEY@POLBAN.AC.ID', 'nim' => '225231022', 'ormawa' => 'UKM Bola Voli'],
            ['name' => 'Fauzi Alfirasi', 'email' => 'UKM-BULUTANGKIS@POLBAN.AC.ID', 'nim' => '225231101', 'ormawa' => 'UKM Bulu Tangkis'],
            ['name' => 'Rifqi Ahmad Rabbani', 'email' => 'UKM-CATUR@POLBAN.AC.ID', 'nim' => '225231036', 'ormawa' => 'UKM Catur'],
            ['name' => 'Haidar Ali Lukman', 'email' => 'UKM-BELADIRI@POLBAN.AC.ID', 'nim' => '225231005', 'ormawa' => 'UKM Bela Diri'],
            ['name' => 'Litha Briani Sutardi', 'email' => 'UKM-SAGA@POLBAN.AC.ID', 'nim' => '221410104', 'ormawa' => 'UKM Perhimpunan Penempuh Rimba dan Pendaki Gunung (PPRPG) SAGA'],
            ['name' => 'Aulia Muthmainah', 'email' => 'UKM-KSRPMI@POLBAN.AC.ID', 'nim' => '221410103', 'ormawa' => 'UKM Korp Sukarela (KSR) PMI'],
            ['name' => 'Alda Pratista', 'email' => 'UKM-PRAMUKA@POLBAN.AC.ID', 'nim' => '221234003', 'ormawa' => 'UKM Pramuka'],
            ['name' => 'Najla Khairunnisa Permana', 'email' => 'UKM-FELLAS@POLBAN.AC.ID', 'nim' => '225110025', 'ormawa' => 'UKM Fellas']
        ];        

        foreach ($users as $user) {
            $randomPassword = 'Polban' . rand(1000, 9999);
            
            // Tentukan id_user baru
            $newIdUser = DB::table('users')->max('id_user') + 1;
        
            DB::table('users')->insert([
                'id_user' => $newIdUser,
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($randomPassword),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        
            // Ambil id_user yang baru saja dimasukkan
            $idUser = DB::table('users')->where('email', $user['email'])->value('id_user');
        
            // Ambil id_ormawa berdasarkan email
            $idOrmawa = DB::table('ormawa')->where('nama_ormawa', $user['ormawa'])->value('id_ormawa');        
            DB::table('pengaju')->insert([
                'nim' => $user['nim'],
                'id_user' => $idUser,
                'id_ormawa' => $idOrmawa,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        
            echo "User: {$user['name']} - Email: {$user['email']} - Password: {$randomPassword}\n";
        }
    }
}
