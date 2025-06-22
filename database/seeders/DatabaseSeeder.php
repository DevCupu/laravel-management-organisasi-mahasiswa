<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
use App\Models\Member;
use App\Models\Event;
use App\Models\Document;
use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin SIORMAWA',
            'email' => 'admin@siormawa.ac.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create sample organizations
        $organizations = [
            [
                'name' => 'Himpunan Mahasiswa Teknik Informatika',
                'acronym' => 'HMTI',
                'category' => 'himpunan',
                'description' => 'Organisasi mahasiswa jurusan Teknik Informatika yang fokus pada pengembangan teknologi dan inovasi.',
                'established_date' => '2020-01-15',
                'status' => 'active',
                'email' => 'hmti@university.ac.id',
                'phone' => '021-12345678',
            ],
            [
                'name' => 'Badan Eksekutif Mahasiswa',
                'acronym' => 'BEM',
                'category' => 'bem',
                'description' => 'Badan eksekutif mahasiswa tingkat universitas yang mengayomi seluruh mahasiswa.',
                'established_date' => '2019-03-10',
                'status' => 'active',
                'email' => 'bem@university.ac.id',
                'phone' => '021-87654321',
            ],
            [
                'name' => 'Unit Kegiatan Mahasiswa Seni',
                'acronym' => 'UKM SENI',
                'category' => 'ukm',
                'description' => 'Unit kegiatan mahasiswa yang bergerak di bidang seni dan budaya.',
                'established_date' => '2018-09-05',
                'status' => 'active',
                'email' => 'ukmseni@university.ac.id',
            ],
            [
                'name' => 'Palang Merah Remaja',
                'acronym' => 'PMR',
                'category' => 'ormawa',
                'description' => 'Organisasi kemanusiaan yang bergerak dalam bidang kesehatan dan kebencanaan.',
                'established_date' => '2017-11-20',
                'status' => 'active',
                'email' => 'pmr@university.ac.id',
            ],
        ];

        foreach ($organizations as $orgData) {
            $org = Organization::create($orgData);

            // Create sample members for each organization
            for ($i = 1; $i <= rand(15, 30); $i++) {
                Member::create([
                    'organization_id' => $org->id,
                    'student_id' => '2021' . str_pad($org->id * 100 + $i, 3, '0', STR_PAD_LEFT),
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber(),
                    'position' => $i === 1 ? 'Ketua' : ($i === 2 ? 'Wakil Ketua' : ($i === 3 ? 'Sekretaris' : 'Anggota')),
                    'join_date' => fake()->dateTimeBetween('-2 years', 'now'),
                    'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']), // 75% active
                ]);
            }

            //     // Create sample events for each organization
            //     for ($i = 1; $i <= rand(3, 8); $i++) {
            //         Event::create([
            //             'organization_id' => $org->id,
            //             'title' => fake()->sentence(4),
            //             'description' => fake()->paragraph(),
            //             'category' => fake()->randomElement(['Workshop', 'Seminar', 'Kompetisi', 'Sosial', 'Rapat']),
            //             'event_date' => fake()->dateTimeBetween('-1 month', '+3 months'),
            //             'start_time' => fake()->time(),
            //             'end_time' => fake()->time(),
            //             'location' => fake()->address(),
            //             'max_participants' => rand(20, 100),
            //             'current_participants' => rand(0, 50),
            //             'status' => fake()->randomElement(['upcoming', 'completed', 'ongoing']),
            //             'registration_deadline' => fake()->dateTimeBetween('now', '+2 months'),
            //             'created_by' => $admin->id,
            //         ]);
            //     }

            //     // Create sample documents for each organization
            //     for ($i = 1; $i <= rand(2, 6); $i++) {
            //         Document::create([
            //             'organization_id' => $org->id,
            //             'title' => fake()->sentence(3),
            //             'description' => fake()->paragraph(),
            //             'file_name' => fake()->word() . '.pdf',
            //             'file_path' => 'documents/' . $org->acronym . '/' . fake()->word() . '.pdf',
            //             'file_size' => rand(100000, 5000000), // 100KB to 5MB
            //             'file_type' => 'pdf',
            //             'category' => fake()->randomElement(['Proposal', 'Laporan', 'Surat', 'Dokumen']),
            //             'status' => fake()->randomElement(['published', 'draft']),
            //             'uploaded_by' => $admin->id,
            //         ]);
            //     }

            //     // Create sample announcements
            //     for ($i = 1; $i <= rand(1, 3); $i++) {
            //         Announcement::create([
            //             'organization_id' => $org->id,
            //             'title' => fake()->sentence(5),
            //             'content' => fake()->paragraphs(3, true),
            //             'type' => fake()->randomElement(['general', 'event', 'urgent']),
            //             'target_audience' => 'all',
            //             'status' => 'published',
            //             'publish_date' => fake()->dateTimeBetween('-1 week', 'now'),
            //             'expire_date' => fake()->dateTimeBetween('+1 week', '+1 month'),
            //             'created_by' => $admin->id,
            //         ]);
            //     }
            // }

            // // Create some general announcements (not tied to specific organization)
            // for ($i = 1; $i <= 3; $i++) {
            //     Announcement::create([
            //         'organization_id' => null,
            //         'title' => 'Pengumuman Umum: ' . fake()->sentence(4),
            //         'content' => fake()->paragraphs(2, true),
            //         'type' => 'general',
            //         'target_audience' => 'all',
            //         'status' => 'published',
            //         'publish_date' => fake()->dateTimeBetween('-3 days', 'now'),
            //         'expire_date' => fake()->dateTimeBetween('+1 week', '+1 month'),
            //         'created_by' => $admin->id,
            //     ]);
            // }
        }
    }
}
