<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Guestbook;
use App\Models\HallOfFame;
use App\Models\Member;
use App\Models\Project;
use App\Models\Quote;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admins)
        User::create([
            'name' => 'Super Admin A4A',
            'email' => 'super_admin@a4a.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Admin A4A',
            'email' => 'admin@a4a.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Moderator A4A',
            'email' => 'moderator@a4a.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Staf Nonaktif',
            'email' => 'inactive@a4a.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
            'status' => 'inactive',
        ]);

        // 2. Seed Members (Class Members)
        $member1 = Member::create([
            'name' => 'Akey Maulana',
            'nickname' => 'Akey',
            'role' => 'Ketua Kelas / Lord Akey',
            'bio' => 'Pemimpin spiritual para Antek Antek Akey (A4A).',
            'date_of_birth' => '2005-08-12',
            'photo' => null,
            'instagram' => 'akeyyy',
            'github' => 'akeynesia',
            'email' => 'akey@a4a.com',
            'is_active' => true,
        ]);

        $member2 = Member::create([
            'name' => 'Jonnint Pratama',
            'nickname' => 'Jon',
            'role' => 'Wakil Ketua Kelas',
            'bio' => 'Antek nomor satu kepercayaan Lord Akey.',
            'date_of_birth' => '2005-11-20',
            'photo' => null,
            'instagram' => 'jonnint_',
            'github' => 'Jonnint',
            'email' => 'jonnint@a4a.com',
            'is_active' => true,
        ]);

        $member3 = Member::create([
            'name' => 'Rian Hidayat',
            'nickname' => 'Rian',
            'role' => 'Bendahara Jahanam',
            'bio' => 'Tukang palak uang kas kelas paling ditakuti.',
            'date_of_birth' => '2006-03-15',
            'photo' => null,
            'instagram' => 'rianhdt',
            'github' => 'rianh',
            'email' => 'rian@a4a.com',
            'is_active' => true,
        ]);

        // 3. Seed Projects
        Project::create([
            'member_id' => $member1->id,
            'name' => 'Kultus Akey Website',
            'description' => 'Website official untuk mendokumentasikan keagungan Akey.',
            'thumbnail' => null,
            'repository_url' => 'https://github.com/Lyonse-nt/latihan-git',
            'demo_url' => 'https://a4a-cult.test',
            'status' => 'completed',
        ]);

        Project::create([
            'member_id' => $member2->id,
            'name' => 'Aplikasi Anti-Duit Kas',
            'description' => 'Aplikasi untuk mendeteksi keberadaan bendahara secara real-time.',
            'thumbnail' => null,
            'repository_url' => 'https://github.com/Jonnint/anti-kas',
            'demo_url' => null,
            'status' => 'ongoing',
        ]);

        // 4. Seed Galleries
        Gallery::create([
            'member_id' => $member1->id,
            'photos' => ['galleries/mock_photo1.jpg', 'galleries/mock_photo2.jpg'],
            'category' => 'Kegiatan Kelas',
            'caption' => 'Rapat paripurna membahas uang kas yang menunggak.',
            'date' => '2026-06-10',
            'visibility' => 'public',
        ]);

        Gallery::create([
            'member_id' => $member3->id,
            'photos' => ['galleries/mock_photo3.jpg'],
            'category' => 'Refreshing',
            'caption' => 'Bolos berjamaah di kantin belakang sekolah.',
            'date' => '2026-06-20',
            'visibility' => 'public',
        ]);

        // 5. Seed Events
        Event::create([
            'name' => 'Dies Natalis A4A ke-1',
            'location' => 'Warmindo Dekat Kampus',
            'date' => '2026-08-12',
            'time' => '19:00:00',
            'description' => 'Perayaan hari jadi Antek Antek Akey dengan makan mi instan bersama.',
            'poster' => null,
        ]);

        Event::create([
            'name' => 'Class Meeting Sepak Takraw',
            'location' => 'Lapangan Utama',
            'date' => '2026-07-05',
            'time' => '08:00:00',
            'description' => 'Mendukung tim kelas A4A merebut piala bergilir Lord Akey.',
            'poster' => null,
        ]);

        // 6. Seed Timelines
        Timeline::create([
            'title' => 'Terbentuknya A4A',
            'date' => '2025-06-01',
            'description' => 'Lord Akey mengumpulkan 30 murid terpilih untuk membentuk faksi A4A.',
            'icon' => 'flag',
            'sort_order' => 1,
        ]);

        Timeline::create([
            'title' => 'Kemenangan Class Meeting Pertama',
            'date' => '2025-12-15',
            'description' => 'A4A memenangkan lomba tarik tambang secara curang tapi terhormat.',
            'icon' => 'trophy',
            'sort_order' => 2,
        ]);

        // 7. Seed Hall Of Fame
        HallOfFame::create([
            'member_id' => $member1->id,
            'category' => 'Antek Ter-Manipulatif',
            'winner_name' => 'Akey Maulana',
            'year' => 2025,
            'photo' => null,
        ]);

        HallOfFame::create([
            'member_id' => $member3->id,
            'category' => 'Pemalak Ter-Konsisten',
            'winner_name' => 'Rian Hidayat',
            'year' => 2025,
            'photo' => null,
        ]);

        // 8. Seed Quotes
        Quote::create([
            'quote' => 'Uang kas adalah koentji kesuksesan kelas, tidak bayar denda 50 ribu.',
            'author' => 'Rian Hidayat',
            'is_published' => true,
        ]);

        Quote::create([
            'quote' => 'Tidur di kelas adalah ibadah yang paling nikmat setelah kantin.',
            'author' => 'Lord Akey',
            'is_published' => true,
        ]);

        Quote::create([
            'quote' => 'Dilarang keras berpacaran sesama anggota kelas demi kestabilan negara A4A.',
            'author' => 'Jonnint Pratama',
            'is_published' => false, // Draft
        ]);

        // 9. Seed Guestbook
        Guestbook::create([
            'name' => 'Pak Budi (Wali Kelas)',
            'email' => 'budi@sekolah.sch.id',
            'message' => 'Kelas kalian sangat ramai, tolong kurangi kegaduhan di jam pelajaran saya.',
            'status' => 'approved',
        ]);

        Guestbook::create([
            'name' => 'Siska Kelas Sebelah',
            'email' => 'siska@gmail.com',
            'message' => 'Akey ganteng banget deh, titip salam ya kak.',
            'status' => 'pending',
        ]);

        Guestbook::create([
            'name' => 'Haters A4A',
            'email' => 'hater@gmail.com',
            'message' => 'Kelas cupu, cuma menang tarik tambang aja bangga.',
            'status' => 'rejected',
        ]);

        // 10. Seed Announcements
        Announcement::create([
            'title' => 'Pengumuman Penting: Uang Kas Naik!',
            'content' => 'Mulai minggu depan, uang kas naik menjadi Rp 10.000 per minggu demi kelancaran Dies Natalis.',
            'published_at' => now(),
            'is_pinned' => true,
        ]);

        Announcement::create([
            'title' => 'Agenda Liburan Semester',
            'content' => 'Diharapkan seluruh anggota berkumpul di rumah Akey untuk briefing liburan ke pantai.',
            'published_at' => now()->addMinutes(5),
            'is_pinned' => false,
        ]);
    }
}
