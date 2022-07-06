<?php

namespace App\Database\Seeds;

use App\Models\MahasiswaModel;
use CodeIgniter\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        $mahasiswa = new MahasiswaModel();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 291467; $i++) {
            $gender = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $religion = $faker->randomElement(['Islam'], ['Kristen'], ['Hindu'], ['Budha'], ['Konghucu']);
            $mahasiswa->save(
                [
                    'Nama' => $faker->name($gender),
                    'JenisKelamin' => $gender,
                    'Alamat' => $faker->address,
                    'Agama' => $religion,
                    'NoHp' => $faker->phoneNumber,
                    'Email' => $faker->safeEmail
                ]
            );
        }
    }
}
