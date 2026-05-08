<?php

namespace Database\Seeders;

use App\Models\Guestbook;
use Illuminate\Database\Seeder;

class GuestbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guestbooks = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'phone' => '081234567890',
                'organization' => 'Dinas Pendidikan',
                'visit_date' => now()->toDateString(),
                'message' => 'Koordinasi agenda rapat dan penyerahan dokumen.',
                'status' => 'approved',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@example.com',
                'phone' => '082112345678',
                'organization' => 'PT Nusantara Digital',
                'visit_date' => now()->subDay()->toDateString(),
                'message' => 'Konsultasi layanan administrasi.',
                'status' => 'pending',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.pratama@example.com',
                'phone' => '083812345678',
                'organization' => 'Universitas Merdeka',
                'visit_date' => now()->subDays(2)->toDateString(),
                'message' => 'Permohonan data untuk kebutuhan penelitian.',
                'status' => 'rejected',
            ],
        ];

        foreach ($guestbooks as $guestbook) {
            Guestbook::updateOrCreate(
                ['email' => $guestbook['email']],
                $guestbook
            );
        }
    }
}
