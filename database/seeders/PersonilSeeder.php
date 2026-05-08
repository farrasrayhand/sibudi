<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\EmploymentStatus;
use App\Models\Personil;
use Illuminate\Database\Seeder;

class PersonilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = collect(['PNS', 'P3K'])->mapWithKeys(function (string $status) {
            $model = EmploymentStatus::updateOrCreate(['name' => $status]);

            return [$status => $model->id];
        });

        $data = [
            'BIDANG KEBUDAYAAN' => [
                ['Al kahfi Pratama', 'P3K'],
                ['Aries Hariyanti', 'PNS'],
                ['Dadang Pujiantoko, S.Sn', 'P3K'],
                ['Eddy Riwayanto', 'PNS'],
                ['Fitriani, A.Md', 'P3K'],
                ['Hj. Siti Aisyah', 'PNS'],
                ['Lucia Dyah Prasetyarini, S.H', 'PNS'],
                ['Maulidan Rahmat Syahidin, S.Sn', 'P3K'],
                ['Monica Fourtina', 'P3K'],
                ['Nardi', 'PNS'],
                ['Priangga Wicaksana, S.Pd', 'PNS'],
                ['Sih Sudiono, SE', 'PNS'],
                ['Subaedah Gani', 'PNS'],
                ['Wiwin Wijayhanti, S.Sos', 'P3K'],
            ],
            'BIDANG PEMBINAAN KETENAGAAN' => [
                ['Agus Riady,S.Kom', 'P3K'],
                ['Ardi Haryanto,S.Kom', 'P3K'],
                ['Armin, S.Pd, M.Pd', 'PNS'],
                ['Dhamar Tri Prasetyo, S.STP., M.M', 'PNS'],
                ['Dhiba Pramiswara Aldhino,SE', 'P3K'],
                ['Edy Suyanto', 'PNS'],
                ['Ermitha Veriana Putri,S.Kom', 'P3K'],
                ['Ganis Danu Asmoro', 'PNS'],
                ['Ismadi Rakhmat', 'PNS'],
                ['Linda Pratiwi,S.Pd', 'P3K'],
                ['Niken. W, S.Pd', 'P3K'],
                ['Norhasanah Salamon', 'PNS'],
                ['Pahrurraji', 'PNS'],
                ['Singgih Bayu Pratama, S.Tr.Ip', 'PNS'],
                ['Wulan Yuliana, S.E', 'P3K'],
                ['Yuliana Syahidin,S.K.M', 'P3K'],
            ],
            'BIDANG PEMBINAAN PENDIDIKAN KHUSUS' => [
                ['Abdul Majid, SE', 'P3K'],
                ['Akhmad Jumaidi', 'PNS'],
                ['Annisa Ramadhan Yusticia Ishadi Putri, S.H', 'P3K'],
                ['Annisa Rizki Khairani', 'P3K'],
                ['Budi Suryanto, S.Hut', 'P3K'],
                ['Christina, S.Pd', 'PNS'],
                ['Herdyana Yanunda Putri, ST', 'P3K'],
                ['Isna Mulyati, S.Ag', 'PNS'],
                ['Reni Herlina, A.Md', 'PNS'],
                ['Rosidah Rifai, S.Pi', 'P3K'],
                ['Sapi\'i, S.Pd, M.Pd', 'PNS'],
                ['Sholeh', 'PNS'],
                ['Suprapto,S.STP', 'PNS'],
                ['Widya Astuti, SE', 'P3K'],
                ['Zulfikar Alibuto', 'PNS'],
            ],
            'BIDANG PEMBINAAN SMA' => [
                ['Agus Hariyanto,S.Si', 'PNS'],
                ['Agus Hary Wibowo, S.Kom', 'PNS'],
                ['Agus Imam Mahdi, SE', 'P3K'],
                ['Irwansyah', 'P3K'],
                ['Isni Anawati, S.Kom', 'P3K'],
                ['Muhammad Dedy Setiawan', 'P3K'],
                ['Muhammad Jasniansyah, S.E, M.Si', 'PNS'],
                ['Nia Fitrianita Wulandari, SE', 'P3K'],
                ['Noor Aslamiyah, A.Md', 'PNS'],
                ['Radiatul, SE', 'P3K'],
                ['Ramon Enrico', 'P3K'],
                ['Rini, A.Md', 'PNS'],
                ['Rustam, S.Kom', 'P3K'],
                ['Siti Mariam, S.Pd', 'PNS'],
                ['Sri Idhayani', 'PNS'],
            ],
            'BIDANG PEMBINAAN SMK' => [
                ['Abdi Irwan, S.Sos', 'PNS'],
                ['Ali Sadikin', 'PNS'],
                ['Gefri H Sianturi, SE', 'P3K'],
                ['Irsyam', 'P3K'],
                ['Jihan Fakhirah, S.Pd', 'P3K'],
                ['Muhamat Achmadi', 'PNS'],
                ['Muhammad Rifai, SE', 'P3K'],
                ['Muhammad Rizali Noor,A.Md', 'P3K'],
                ['Sulastri', 'PNS'],
                ['Surasa, S.Pd., M.Si.', 'PNS'],
                ['Tity Anwar, S.T, M.Si', 'PNS'],
                ['Vina Oktaria', 'PNS'],
                ['Yogi Sudarmanto Ramadhan, A. Md', 'P3K'],
            ],
            'DISDIKBUD ESELON (BIDANG SMA)' => [
                ['Dr. Siti Aminah, M.Si', 'PNS'],
                ['Dra. Atik Sulistyowati', 'PNS'],
                ['Mochamad Mursalin, S.Pd., M.Eng', 'PNS'],
            ],
            'PIMPINAN' => [
                ['Armin, S.Pd, M.Pd', 'PNS'],
            ],
            'SEKRETARIAT' => [
                ['Ir. Rahmat Ramadhan.,S.T.,M.M', 'PNS'],
            ],
            'SUB BAGIAN KEUANGAN' => [
                ['Adi Gunawan', 'P3K'],
                ['Aditia Nugroho', 'P3K'],
                ['Asmada Sari, S.Pd', 'P3K'],
                ['Astri Dian Sari,S.E', 'P3K'],
                ['Awang Rachmad. S., A.Md', 'PNS'],
                ['BAMBANG WIDIYATNO,S.Pd', 'P3K'],
                ['Dwi Agus Renaldi, S.Sos', 'P3K'],
                ['EMI MARLINA,S.Pd', 'P3K'],
                ['Edwin Darmawan', 'P3K'],
                ['Ely Susanti Umar, A.Md', 'PNS'],
                ['Erwansyah, S.Sos', 'P3K'],
                ['Faisal Erlangga Sanora,S.Sos', 'P3K'],
                ['Fathan Nur', 'PNS'],
                ['Fitrianida, S.Pd', 'P3K'],
                ['Herdi Nirwany, SE', 'PNS'],
                ['Heriyansyah', 'PNS'],
                ['Hj. Nurjanah, S.E', 'PNS'],
                ['Indryani', 'P3K'],
                ['Ira Puspita, S.Pd', 'P3K'],
                ['MASFAH,S.Pd', 'P3K'],
                ['MELIANA OMI,S.Pd', 'P3K'],
                ['Machfud Nur Syamsudin', 'P3K'],
                ['Muhammad Zaldy Rezha Pegriadi, S.Kom', 'P3K'],
                ['NINA KUSWOYO,S.Pd', 'P3K'],
                ['Novyanthi Eka Rosida, SE', 'PNS'],
                ['Nur Sakinah Mardatillah, S.Pd', 'P3K'],
                ['Randhi Akhdiyat, SE', 'PNS'],
                ['Riski Septiani Yolanda, SE', 'P3K'],
                ['Rusli, S.Sos', 'P3K'],
                ['Syarifah Pitriani Al Hasni, S. M', 'PNS'],
            ],
            'SUB BAGIAN PERENCANAAN' => [
                ['Hemelda, S.AB', 'PNS'],
                ['Hudriani, S.Pd', 'P3K'],
                ['Irfan Mahfudz Guntur, S.Kom', 'P3K'],
                ['Irfan Rizqoni Noor', 'P3K'],
                ['Lamri', 'PNS'],
                ['Mulyani Oktavia, S.Sos', 'P3K'],
                ['Rachmad Budianto, S.IP', 'P3K'],
                ['Rusmita, S.Stat', 'P3K'],
                ['Sugianto, S.Pd., M.Pd', 'PNS'],
                ['Wiku Mukti Vambudi, S.Kom', 'P3K'],
            ],
            'SUB BAGIAN UMUM & KEPEGAWAIAN' => [
                ['Achmad Denny Saputra, S.E', 'P3K'],
                ['Anwar Sadat, S.Pi', 'P3K'],
                ['Bambang Hadiyanto, S.E', 'PNS'],
                ['Budhi Sukaryadi', 'PNS'],
                ['Budi Sutrisno, M.Pd', 'PNS'],
                ['Didik Cahyono', 'PNS'],
                ['Firman Wahyudi, S.Pd', 'P3K'],
                ['Fitria, S.Pi', 'P3K'],
                ['Friska Rianty Amelia, S.T.', 'P3K'],
                ['Hadyan Abdurrahman Hakim,S.IP', 'PNS'],
                ['Hendra Gunawan', 'PNS'],
                ['Herlina Windy Prastiwi, A.Md', 'PNS'],
                ['Karsidi, A. Md', 'P3K'],
                ['La Burahima', 'PNS'],
                ['Lia Novita Sari', 'P3K'],
                ['M. Herdi Riyanto, S.E', 'P3K'],
                ['M. Wahyu Machsuri, S.H', 'P3K'],
                ['Monik Turasmia, S.E', 'P3K'],
                ['Muhammad Heru Sutrisno, S.H', 'P3K'],
                ['Muhammad Surya Nor, SE, MM', 'P3K'],
                ['Nona Meisyarah Alamsyah', 'P3K'],
                ['Noviandy, S.I.Kom', 'P3K'],
                ['Novita Rahman, S.Pd', 'P3K'],
                ['Poby Suhendra, S.Kom', 'P3K'],
                ['Rabiatul Maulida,S.S', 'P3K'],
                ['Riwono', 'PNS'],
                ['Robiyatul Ardalia Wulandari', 'PNS'],
                ['Sunarto', 'PNS'],
                ['Surya Dharma', 'P3K'],
                ['Suseno', 'PNS'],
                ['Susi Apriani. A.Md', 'PNS'],
                ['Syaiful Alam, S.H', 'PNS'],
                ['Syamsuni', 'PNS'],
                ['Tri Vinanti Budi Astuti, S.Pd', 'P3K'],
            ],
        ];

        foreach ($data as $bidangName => $personils) {
            $bidang = Bidang::updateOrCreate(['name' => $bidangName]);

            foreach ($personils as [$name, $status]) {
                Personil::updateOrCreate(
                    [
                        'bidang_id' => $bidang->id,
                        'name' => $name,
                    ],
                    [
                        'employment_status_id' => $statuses[$status],
                    ]
                );
            }
        }
    }
}
