<?php

namespace Database\Seeders;

use App\Models\Benefit;
use App\Models\Category;
use App\Models\Course;
use App\Models\Faq;
use App\Models\Module;
use App\Models\PaymentMethod;
use App\Models\PremiumDescription;
use App\Models\PremiumMembership;
use App\Models\SubModule;
use App\Models\Testimonial;
use App\Models\Uniqueness;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('1q2w3e4r5t'),
            'sosial_media' => 'instagram.com',
            'no_hp' => '62811959019',
            'is_admin' => true,
	    'referral_code' => 'Z4CXBSQT'
        ]);

        Course::create([
            'title' => 'Bisnis dan Hukum',
            'description' => 'Bisnis dan Hukum adalah lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam elementum ultricies dolor, sed pulvinar quam euismod quis. In condimentum lacus lacus, vel ornare odio dignissim vel. Quisque ut erat nulla. Phasellus quis lorem vitae ipsum tempor rutrum. Mauris viverra nec ex vel sodales. ',
            'phone' => '62811959019',
            'address' => 'Maktab Square, Jl. K S Tubun No.19, RT.03/RW.02, Cibuluh, Bogor Utara, Bogor City, West Java 16151',
            'banner_main_text' => 'Belajar Bisnis dan Hukum Kapan Saja, Di Mana Saja',
            'banner_text' => 'Kursus online dan artikel kami dirancang untuk membantu Anda memahami dunia bisnis dan hukum dengan mudah dan fleksibel.',
            'trailer' => 'y7Px2qWOH9A'
        ]);

        Module::create([
            'title' => 'Modul 1',
            'order' => 1,
            'course_id' => 1
        ]);
        Module::create([
            'title' => 'Modul 2',
            'order' => 2,
            'course_id' => 1
        ]);
        Module::create([
            'title' => 'Modul 3',
            'order' => 3,
            'course_id' => 1
        ]);

        Category::create([
            'name' => 'Bisnis',
            'slug' => 'bisnis'
        ]);
        Category::create([
            'name' => 'Hukum',
            'slug' => 'hukum'
        ]);

        SubModule::create([
            'module_id' => 1,
            'title' => 'Materi 1',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
            'type' => 'video',
            'content' => 'oh2u7aSxYIU',
            'order' => 1,
            'published_date' => '2023-12-09 14:26:28'
        ]);
        SubModule::create([
            'module_id' => 2,
            'title' => 'Materi 1',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
            'type' => 'video',
            'content' => 'LRs8Qu_X3EY',
            'order' => 1,
            'published_date' => '2023-12-09 14:26:28'
        ]);
        SubModule::create([
            'module_id' => 3,
            'title' => 'Materi 1',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.',
            'type' => 'video',
            'content' => 'FVHspnpHPmM',
            'order' => 1,
            'published_date' => '2023-12-09 14:26:28'
        ]);

        Testimonial::create([
            'name' => 'Ibu Dina, 35 tahun',
            'occupation' => 'Ibu Rumah Tangga',
            'type' => 'Text',
            'content' => 'Saya selalu merasa bingung bagaimana cara terbaik menghadapi anak yang sulit diatur. Setelah mengikuti kelas Parenting Cerdas, saya memahami pentingnya komunikasi yang hangat dan disiplin yang positif. Sekarang hubungan saya dengan anak jauh lebih baik. Terima kasih, Akademi Keluarga Cerdas!',
            'is_active' => true
        ]);
        Testimonial::create([
            'name' => 'Andi dan Fira, 28 dan 27 tahun',
            'occupation' => 'Pasangan Baru Menikah 1 Tahun',
            'type' => 'Text',
            'content' => 'Program ini menjadi investasi terbaik dalam hubungan kami. Program ini mengajarkan bagaimana memahami peran masing-masing, menyelesaikan konflik dengan bijak, dan merencanakan keuangan keluarga. Kami merasa lebih siap menjalani kehidupan rumah tangga sampai dengan puluhan tahun lamanya.',
            'is_active' => true
        ]);
        Testimonial::create([
            'name' => 'Pak Johan, 40 tahun',
            'occupation' => 'Karyawan Swasta',
            'type' => 'Text',
            'content' => 'Sebagai pekerja dengan jadwal yang padat, saya merasa kurang hadir untuk keluarga. Program Pengelolaan Waktu di Akademi Keluarga Cerdas membantu saya membuat prioritas yang lebih baik. Sekarang saya lebih terlibat dalam kehidupan anak-anak dan hubungan saya dengan pasangan menjadi lebih harmonis.',
            'is_active' => true
        ]);
        Testimonial::create([
            'name' => 'Bu Aisyah, 42 tahun',
            'occupation' => 'Guru',
            'type' => 'Text',
            'content' => 'Sebagai seorang pendidik, saya merasa program Akademi Keluarga Cerdas sangat relevan. Materi tentang mendidik anak dengan cinta dan nilai-nilai Islami memberikan inspirasi bagi saya untuk membantu lebih banyak keluarga di lingkungan sekolah.',
            'is_active' => true
        ]);
        Testimonial::create([
            'name' => 'Pak Hadi, 50 tahun',
            'occupation' => 'Profesional',
            'type' => 'Text',
            'content' => 'Kami pernah menghadapi konflik besar dalam keluarga yang hampir membuat hubungan kami retak. Layanan konseling keluarga dari Akademi Keluarga Cerdas benar-benar membantu kami memahami perspektif satu sama lain. Sekarang, kami merasa lebih dekat dan lebih kuat sebagai keluarga.',
            'is_active' => true
        ]);
        Testimonial::create([
            'name' => 'Pak Agus dan Bu Nia, 45 dan 42 tahun',
            'occupation' => 'Pasangan Menikah 20 Tahun',
            'type' => 'Text',
            'content' => 'Saya merasa rumah tangga kami seperti di ujung tanduk karena komunikasi yang buruk dan banyaknya konflik. Setelah mengikuti kelas komunikasi efektif di Akademi Keluarga Cerdas, kami belajar bagaimana saling mendengarkan dan memahami. Sekarang, rumah tangga kami terasa jauh lebih harmonis, penuh cinta, dan masalah besar yang dulu tampak tak terpecahkan kini bisa kami hadapi bersama.',
            'is_active' => true
        ]);

        Faq::create([
            'question' => 'Apa itu Bisnis dan Hukum?',
            'answer' => 'Akademi Keluarga Cerdas adalah lembaga pendidikan dan pelatihan yang bertujuan untuk membantu keluarga menjadi lebih harmonis, cerdas, dan berdaya melalui program-program berbasis nilai-nilai keislaman, ilmu pengetahuan, dan keterampilan praktis.',
            'is_active' => true
        ]);
        Faq::create([
            'question' => 'Siapa yang bisa mengikuti program Akademi Keluarga Cerdas?',
            'answer' => 'Program kami terbuka untuk semua kalangan, mulai dari pasangan yang belum menikah (calon suami/istri), pasangan suami istri, orang tua, hingga keluarga secara keseluruhan yang ingin meningkatkan kualitas hidup mereka.',
            'is_active' => true
        ]);
        Faq::create([
            'question' => 'Apa saja program unggulan yang ditawarkan?',
            'answer' => 'Pembelajaran yang ditawarkan berupa ...',
            'is_active' => true
        ]);
        Faq::create([
            'question' => 'Apakah programnya berbasis online? ',
            'answer' => 'Ya, kami memahami waktu dan kesibukan Anda. Anda bisa belajar fleksible, kapan saja dan di mana saja sesuai dengan jadwal Anda. Ketika pembelajaran Live Zoom, Anda pun tetap akan mendapatkan rekaman materi.',
            'is_active' => true
        ]);
        Faq::create([
            'question' => 'Siapa saja narasumber atau pengajar di Akademi Keluarga Cerdas?',
            'answer' => 'Kami menghadirkan para pakar di bidang parenting, pendidikan, psikologi keluarga, konsultan keuangan Islami, serta pembicara inspiratif yang memiliki pengalaman luas dalam membantu keluarga menjadi lebih harmonis dan cerdas.',
            'is_active' => true
        ]);
        Faq::create([
            'question' => 'Apakah Akademi Keluarga Cerdas hanya untuk keluarga Muslim?',
            'answer' => 'Meskipun pendekatan kami berbasis nilai-nilai Islami, program ini terbuka untuk siapa saja yang ingin belajar dan meningkatkan kualitas keluarganya.',
            'is_active' => true
        ]);
        Faq::create([
            'question' => 'Apa manfaat yang bisa didapatkan dari mengikuti program ini?',
            'answer' => 'Anda akan mendapatkan:
            1. Pemahaman mendalam tentang peran dan tanggung jawab dalam keluarga.
            2. Keterampilan praktis dalam mengelola hubungan, keuangan, dan pengasuhan anak.
            3. Solusi konkret untuk masalah keluarga yang sering muncul.
            4. Komunitas yang mendukung untuk terus bertumbuh bersama.',
            'is_active' => true
        ]);
        Faq::create([
            'question' => 'Apakah ada layanan konseling keluarga di Akademi Keluarga Cerdas?',
            'answer' => 'Ya, kami menyediakan layanan konseling keluarga untuk membantu menyelesaikan masalah dalam rumah tangga secara personal dan profesional pada sesi zoom berkala. Anda bisa bertanya baik melalui kontak atau melalui zoom. Jawaban akan kami berikan di setiap materi update berkala atau juga via zoom.',
            'is_active' => true
        ]);

        PaymentMethod::create([
            'nama_bank' => 'BCA Syariah',
            'nama_akun' => 'Risky Irawan',
            'no_rekening' => '0140063504',
            'is_active' => true
        ]);
        PaymentMethod::create([
            'nama_bank' => 'Bank Mandiri',
            'nama_akun' => 'Risky Irawan',
            'no_rekening' => '1330029603602',
            'is_active' => true
        ]);

        Benefit::create([
            'title' => 'Edukasi Praktis dan Relevan',
            'description' => 'Kursus dan artikel kami dirancang oleh para ahli di bidang bisnis dan hukum, memberikan solusi praktis yang relevan dengan kebutuhan Anda di dunia nyata.',
            'is_active' => true
        ]);
        Benefit::create([
            'title' => 'Akses Kapan Saja, Di Mana Saja',
            'description' => 'Belajar fleksibel tanpa batasan waktu dan tempat. Platform kami memungkinkan Anda mengakses kursus dan artikel kapan pun Anda membutuhkannya.',
            'is_active' => true
        ]);
        Benefit::create([
            'title' => 'Panduan Lengkap untuk Bisnis dan Hukum',
            'description' => 'Dapatkan wawasan menyeluruh mulai dari strategi bisnis hingga perlindungan hukum. Kami membantu Anda membuat keputusan yang tepat dan terinformasi.',
            'is_active' => true
        ]);
        Benefit::create([
            'title' => 'Tingkatkan Kepercayaan Diri dalam Berbisnis',
            'description' => 'Kuasai pengetahuan hukum dan bisnis untuk menjalankan usaha tanpa khawatir. Bangun fondasi yang kokoh untuk pertumbuhan bisnis Anda.',
            'is_active' => true
        ]);
        Benefit::create([
            'title' => 'Belajar dari Para Ahli Terpercaya',
            'description' => 'Dapatkan ilmu langsung dari mentor profesional yang berpengalaman di bidang bisnis dan hukum. Temukan wawasan eksklusif yang tidak Anda dapatkan di tempat lain.',
            'is_active' => true
        ]);

        PremiumMembership::create([
            'title' => 'Jangan Lewatkan Kesempatan Ini',
            'sub_title' => 'Bergabunglah dengan Bisnis dan Hukum sekarang dan mulailah perjalanan Anda menuju kesuksesan!',
            'description' => 'Akses ke semua bahan materi untuk meningkatkan karir anda',
            'price' => 499000
        ]);

        PremiumDescription::create([
            'premium_membership_id' => 1,
            'content' => 'Akses ke semua bahan materi seperti video, audio, dokumen, dan artikel',
        ]);
        PremiumDescription::create([
            'premium_membership_id' => 1,
            'content' => 'Komunitas eksklusif, bergabung dengan komunitas profesional properti yang siap berbagi pengalaman dan tips berharga',
        ]);
        PremiumDescription::create([
            'premium_membership_id' => 1,
            'content' => 'Mendapatkan sertifikat',
        ]);

        Uniqueness::create([
            'title' => 'Kurikulum Terkini dan Relevan',
            'description' => 'Kurikulum kami selalu diperbarui untuk mengikuti tren terbaru di industri properti. Pelajari strategi menemukan Hot Leads, Closing, pemasaran digital, branding, negosiasi, dan banyak lagi.',
            'is_active' => true
        ]);
        Uniqueness::create([
            'title' => 'Studi Kasus Nyata',
            'description' => 'Setiap materi dilengkapi dengan studi kasus dari transaksi yang berhasil. Ini akan membantu Anda melihat bagaimana teori diterapkan dalam dunia nyata dan bisa diterapkan dalam bisnis Anda.',
            'is_active' => true
        ]);
        Uniqueness::create([
            'title' => 'Mentor Berpengalaman',
            'description' => 'Belajar dari mentor yang telah berhasil menjual ribuan unit properti. Mereka akan membimbing Anda melalui setiap langkah untuk memastikan Anda bisa menerapkan ilmu yang didapat.',
            'is_active' => true
        ]);
    }
}
