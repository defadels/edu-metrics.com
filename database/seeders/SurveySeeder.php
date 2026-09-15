<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\LikertScale;
use App\Models\LikertScaleOption;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Response;
use App\Models\Survey;
use App\Models\SurveyCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Admin User exists
        $admin = User::query()->where('role', 'admin')->first();
        if (! $admin) {
            $this->call(NewUserSeeder::class);
            $admin = User::query()->where('role', 'admin')->first();
        }

        // 2. Ensure Student Users exist
        $students = User::query()->where('role', 'mahasiswa')->orderBy('nim')->get();
        if ($students->isEmpty()) {
            $this->call(StudentSeeder::class);
            $students = User::query()->where('role', 'mahasiswa')->orderBy('nim')->get();
        }

        // Distribute program studies to students if not set
        $programStudies = User::PROGRAM_STUDIES;
        foreach ($students as $index => $student) {
            if (empty($student->program_study)) {
                $student->program_study = $programStudies[$index % count($programStudies)];
                $student->save();
            }
        }

        // Refresh student collection after updating
        $students = User::query()->where('role', 'mahasiswa')->orderBy('nim')->get();

        // 3. Create Likert Scales & Options
        $satisfactionScale = LikertScale::query()->firstOrCreate([
            'name' => 'Skala Kepuasan 5 Poin',
        ], [
            'min_value' => 1,
            'max_value' => 5,
            'min_label' => 'Sangat Tidak Puas',
            'max_label' => 'Sangat Puas',
        ]);

        $satisfactionOptions = [
            1 => 'Sangat Tidak Puas',
            2 => 'Tidak Puas',
            3 => 'Cukup Puas',
            4 => 'Puas',
            5 => 'Sangat Puas',
        ];

        foreach ($satisfactionOptions as $val => $label) {
            LikertScaleOption::query()->firstOrCreate([
                'likert_scale_id' => $satisfactionScale->id,
                'value' => $val,
            ], [
                'label' => $label,
                'order' => $val,
            ]);
        }

        $agreementScale = LikertScale::query()->firstOrCreate([
            'name' => 'Skala Persetujuan 5 Poin',
        ], [
            'min_value' => 1,
            'max_value' => 5,
            'min_label' => 'Sangat Tidak Setuju',
            'max_label' => 'Sangat Setuju',
        ]);

        $agreementOptions = [
            1 => 'Sangat Tidak Setuju',
            2 => 'Tidak Setuju',
            3 => 'Netral / Ragu-ragu',
            4 => 'Setuju',
            5 => 'Sangat Setuju',
        ];

        foreach ($agreementOptions as $val => $label) {
            LikertScaleOption::query()->firstOrCreate([
                'likert_scale_id' => $agreementScale->id,
                'value' => $val,
            ], [
                'label' => $label,
                'order' => $val,
            ]);
        }

        // 4. Create Survey Categories
        $catDosen = SurveyCategory::query()->firstOrCreate([
            'name' => 'Evaluasi Pembelajaran & Dosen',
        ], [
            'description' => 'Evaluasi proses belajar mengajar, kurikulum, dan kompetensi pedagogik serta profesional dosen.',
            'is_active' => true,
        ]);

        $catFasilitas = SurveyCategory::query()->firstOrCreate([
            'name' => 'Fasilitas & Sarana Kampus',
        ], [
            'description' => 'Evaluasi kenyamanan dan kelayakan sarana perkuliahan, laboratorium, perpustakaan, dan akses internet.',
            'is_active' => true,
        ]);

        $catLayanan = SurveyCategory::query()->firstOrCreate([
            'name' => 'Layanan Akademik & Kemahasiswaan',
        ], [
            'description' => 'Evaluasi kecepatan, keramahan, dan efektivitas pelayanan administrasi akademik dan bimbingan kemahasiswaan.',
            'is_active' => true,
        ]);

        // 5. Feedback Pools for Text Answers
        $dosenFeedbackPool = [
            'Penjelasan materi perkuliahan sangat jelas dan terstruktur. Dosen juga sangat komunikatif saat sesi tanya jawab.',
            'Mohon agar slide presentasi dan materi pengantar dapat dibagikan di portal e-learning sebelum jam kuliah dimulai.',
            'Perbanyak sesi studi kasus nyata dan latihan proyek agar mahasiswa lebih memahami penerapan teori di dunia kerja.',
            'Dosen sangat sabar dalam membimbing praktikum dan selalu memberikan feedback yang membangun pada tugas kami.',
            'Waktu pengembalian tugas dan hasil kuis mohon dapat dipercepat agar kami bisa mengevaluasi kesalahan sebelum ujian.',
            'Metode diskusi interaktif dan pemecahan masalah (Problem Based Learning) sangat menyenangkan dan tidak membosankan.',
            'Secara keseluruhan proses pembelajaran sangat memuaskan, kurikulum yang diajarkan sangat relevan.',
            'Alangkah baiknya jika rekaman video penjelasan materi diunggah ke platform daring untuk dipelajari kembali.',
            'Dosen selalu hadir tepat waktu dan memberikan contoh kasus industri yang sangat memperluas wawasan kami.',
            'Mohon waktu pengerjaan tugas proyek kelompok diberikan durasi yang cukup agar hasilnya lebih maksimal.',
        ];

        $fasilitasFeedbackPool = [
            'Koneksi WiFi kampus di beberapa lantai gedung perkuliahan sering tidak stabil saat jam sibuk, mohon ditambah bandwidth-nya.',
            'Ruang kelas sudah cukup nyaman dan bersih, namun AC di ruang lantai 2 perlu perawatan rutin agar tetap dingin.',
            'Laboratorium komputer sudah sangat baik, mohon lisensi software dan tools praktikum diperbarui ke versi stabil terbaru.',
            'Fasilitas perpustakaan sangat tenang dan nyaman untuk belajar mandiri, koleksi e-book dan jurnal internasional mohon diperbanyak.',
            'Perbanyak titik colokan listrik (stopkontak) di area selasar dan gazebo tempat mahasiswa berdiskusi.',
            'Kebersihan toilet kampus sudah cukup terjaga, mohon ketersediaan sabun cuci tangan dan tisu tetap dipertahankan.',
            'Area parkir kendaraan mahasiswa sudah tertata rapi, semoga ke depan dapat dipasang kanopi pelindung panas/hujan.',
            'Secara umum fasilitas kampus sangat mendukung kegiatan belajar dan aktivitas praktikum mahasiswa.',
        ];

        $layananFeedbackPool = [
            'Pelayanan staf tata usaha dan loket akademik sangat ramah, cepat, dan jelas dalam memberikan informasi.',
            'Proses pengajuan surat izin observasi dan magang/PKL sangat mudah dan cepat selesai.',
            'Portal akademik online untuk pengisian KRS semester ini berjalan lancar tanpa ada server down.',
            'Informasi mengenai pembukaan beasiswa dan program magang kampus merdeka mohon disosialisasikan lebih awal.',
            'Pelayanan bimbingan akademik dengan dosen wali sangat komunikatif dan memberikan arahan studi yang bermanfaat.',
            'Staf administrasi sangat responsif dan membantu ketika mahasiswa mengalami kendala registrasi mata kuliah.',
            'Sistem informasi akademik sudah sangat baik, antarmuka pengguna mudah dipahami dan mobile-friendly.',
        ];

        // 6. Define Surveys Data
        $surveysData = [
            [
                'title' => 'Evaluasi Pembelajaran dan Kinerja Dosen Semester Genap',
                'category_id' => $catDosen->id,
                'description' => 'Survei evaluasi proses pembelajaran, penguasaan materi, dan metode pengajaran dosen untuk peningkatan mutu akademik.',
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(2),
                'feedback_pool' => $dosenFeedbackPool,
                'participation_count' => count($students), // 100% of students
                'questions' => [
                    [
                        'text' => 'Dosen menyampaikan silabus, rencana pembelajaran (RPS), dan kriteria penilaian secara transparan di awal perkuliahan.',
                        'type' => 'likert',
                        'scale_id' => $agreementScale->id,
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'text' => 'Dosen menguasai materi perkuliahan dengan baik dan mampu memberikan penjelasan secara jelas serta interaktif.',
                        'type' => 'likert',
                        'scale_id' => $agreementScale->id,
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'text' => 'Dosen memanfaatkan media pembelajaran digital (LMS, modul, video interaktif) secara optimal dalam perkuliahan.',
                        'type' => 'likert',
                        'scale_id' => $agreementScale->id,
                        'is_required' => true,
                        'order' => 3,
                    ],
                    [
                        'text' => 'Dosen memberikan umpan balik (feedback) dan evaluasi atas tugas/ujian mahasiswa secara tepat waktu.',
                        'type' => 'likert',
                        'scale_id' => $agreementScale->id,
                        'is_required' => true,
                        'order' => 4,
                    ],
                    [
                        'text' => 'Metode pembelajaran apa yang menurut Anda paling efektif dalam memahami materi perkuliahan?',
                        'type' => 'multiple_choice',
                        'scale_id' => null,
                        'is_required' => true,
                        'order' => 5,
                        'options' => [
                            'Ceramah Interaktif & Diskusi Kelas',
                            'Praktikum Terpandu di Laboratorium',
                            'Studi Kasus & Problem Based Learning (PBL)',
                            'Pengerjaan Tugas Proyek Kelompok (Project Based)',
                        ],
                    ],
                    [
                        'text' => 'Berikan kritik, saran, atau masukan Anda untuk peningkatan mutu proses pembelajaran dan pengajaran dosen.',
                        'type' => 'text',
                        'scale_id' => null,
                        'is_required' => false,
                        'order' => 6,
                    ],
                ],
            ],
            [
                'title' => 'Survei Kepuasan Fasilitas dan Infrastruktur Kampus',
                'category_id' => $catFasilitas->id,
                'description' => 'Survei penilaian mahasiswa terhadap kualitas fasilitas ruang kelas, laboratorium, perpustakaan, dan internet kampus.',
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(3),
                'feedback_pool' => $fasilitasFeedbackPool,
                'participation_count' => min(32, count($students)),
                'questions' => [
                    [
                        'text' => 'Tingkat kepuasan terhadap kebersihan, kenyamanan, pencahayaan, dan sirkulasi udara di ruang perkuliahan.',
                        'type' => 'likert',
                        'scale_id' => $satisfactionScale->id,
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'text' => 'Ketersediaan, kecepatan, dan kestabilan akses jaringan internet WiFi di lingkungan kampus.',
                        'type' => 'likert',
                        'scale_id' => $satisfactionScale->id,
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'text' => 'Kelayakan, kelengkapan alat, dan spesifikasi perangkat di laboratorium praktikum mahasiswa.',
                        'type' => 'likert',
                        'scale_id' => $satisfactionScale->id,
                        'is_required' => true,
                        'order' => 3,
                    ],
                    [
                        'text' => 'Kenyamanan fasilitas ruang perpustakaan serta kemudahan akses referensi buku dan jurnal ilmiah.',
                        'type' => 'likert',
                        'scale_id' => $satisfactionScale->id,
                        'is_required' => true,
                        'order' => 4,
                    ],
                    [
                        'text' => 'Fasilitas kampus manakah yang menurut Anda paling mendesak untuk ditingkatkan kinerjanya?',
                        'type' => 'multiple_choice',
                        'scale_id' => null,
                        'is_required' => true,
                        'order' => 5,
                        'options' => [
                            'Kecepatan & Kapasitas WiFi Kampus',
                            'Peremajaan Perangkat Laboratorium Komputer',
                            'Koleksi E-Book & Ruang Belajar Perpustakaan',
                            'Fasilitas Toilet & Area Istirahat Mahasiswa',
                        ],
                    ],
                    [
                        'text' => 'Tuliskan kritik atau saran Anda terkait pengembangan fasilitas sarana dan prasarana kampus.',
                        'type' => 'text',
                        'scale_id' => null,
                        'is_required' => false,
                        'order' => 6,
                    ],
                ],
            ],
            [
                'title' => 'Survei Kepuasan Layanan Akademik & Administrasi Mahasiswa',
                'category_id' => $catLayanan->id,
                'description' => 'Evaluasi mutu pelayanan staf akademik, kemudahan proses pengisian KRS, dan layanan informasi kemahasiswaan.',
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(1),
                'feedback_pool' => $layananFeedbackPool,
                'participation_count' => min(28, count($students)),
                'questions' => [
                    [
                        'text' => 'Keramahan, kesopanan, dan kecepatan staf dalam melayani administrasi akademik mahasiswa.',
                        'type' => 'likert',
                        'scale_id' => $satisfactionScale->id,
                        'is_required' => true,
                        'order' => 1,
                    ],
                    [
                        'text' => 'Kemudahan dan kestabilan sistem portal akademik online dalam proses pengisian KRS dan melihat nilai studi.',
                        'type' => 'likert',
                        'scale_id' => $satisfactionScale->id,
                        'is_required' => true,
                        'order' => 2,
                    ],
                    [
                        'text' => 'Kejelasan dan kecepatan informasi mengenai beasiswa, kompetisi, dan kegiatan kemahasiswaan.',
                        'type' => 'likert',
                        'scale_id' => $satisfactionScale->id,
                        'is_required' => true,
                        'order' => 3,
                    ],
                    [
                        'text' => 'Kanal komunikasi mana yang paling efektif bagi Anda untuk menerima pengumuman penting akademik?',
                        'type' => 'multiple_choice',
                        'scale_id' => null,
                        'is_required' => true,
                        'order' => 4,
                        'options' => [
                            'Website Portal Akademik Kampus',
                            'Grup WhatsApp / Telegram Angkatan',
                            'Akun Media Sosial Resmi Kampus',
                            'Email Resmi Mahasiswa',
                        ],
                    ],
                    [
                        'text' => 'Sampaikan masukan Anda untuk peningkatan mutu pelayanan administrasi dan kemahasiswaan.',
                        'type' => 'text',
                        'scale_id' => null,
                        'is_required' => false,
                        'order' => 5,
                    ],
                ],
            ],
        ];

        // Likert rating distribution template (mostly 4 and 5 with some 3 and 2 for authentic variation)
        $likertPattern = [5, 4, 5, 4, 3, 5, 4, 5, 4, 4, 5, 3, 4, 5, 4, 2, 5, 4, 5, 3, 4, 5, 5, 4, 3, 4, 5, 4, 5, 4, 5, 3, 4, 5, 4, 5];

        foreach ($surveysData as $surveyIndex => $sData) {
            $survey = Survey::query()->updateOrCreate([
                'title' => $sData['title'],
            ], [
                'category_id' => $sData['category_id'],
                'description' => $sData['description'],
                'start_date' => $sData['start_date'],
                'end_date' => $sData['end_date'],
                'is_active' => true,
                'is_anonymous' => false,
                'created_by' => $admin?->id,
            ]);

            // Create or update questions & options
            $createdQuestions = [];
            foreach ($sData['questions'] as $qData) {
                $question = Question::query()->updateOrCreate([
                    'survey_id' => $survey->id,
                    'question_text' => $qData['text'],
                ], [
                    'question_type' => $qData['type'],
                    'likert_scale_id' => $qData['scale_id'],
                    'is_required' => $qData['is_required'],
                    'order' => $qData['order'],
                ]);

                if ($qData['type'] === 'multiple_choice' && ! empty($qData['options'])) {
                    foreach ($qData['options'] as $optOrder => $optText) {
                        QuestionOption::query()->updateOrCreate([
                            'question_id' => $question->id,
                            'option_text' => $optText,
                        ], [
                            'order' => $optOrder + 1,
                        ]);
                    }
                }

                $createdQuestions[] = $question;
            }

            // 7. Seed Student Responses & Answers
            $participantStudents = $students->take($sData['participation_count']);
            $feedbackPool = $sData['feedback_pool'];

            foreach ($participantStudents as $studentIndex => $student) {
                $daysAgo = ($studentIndex % 20) + 1;
                $startedAt = now()->subDays($daysAgo)->subMinutes(($studentIndex * 7) % 45 + 10);
                $completedAt = (clone $startedAt)->addMinutes(($studentIndex % 15) + 5);

                $response = Response::query()->updateOrCreate([
                    'survey_id' => $survey->id,
                    'user_id' => $student->id,
                ], [
                    'respondent_name' => $student->name,
                    'started_at' => $startedAt,
                    'completed_at' => $completedAt,
                    'is_completed' => true,
                    'created_at' => $startedAt,
                    'updated_at' => $completedAt,
                ]);

                // Create answers for each question
                foreach ($createdQuestions as $qIndex => $question) {
                    $answer = Answer::query()->firstOrNew([
                        'response_id' => $response->id,
                        'question_id' => $question->id,
                    ]);

                    $answer->created_at = $completedAt;
                    $answer->updated_at = $completedAt;

                    if ($question->question_type === 'likert') {
                        $patternIndex = ($studentIndex + $qIndex * 3 + $surveyIndex * 5) % count($likertPattern);
                        $answer->likert_value = $likertPattern[$patternIndex];
                        $answer->text_value = null;
                        $answer->selected_option_id = null;
                    } elseif ($question->question_type === 'multiple_choice') {
                        $options = $question->options()->orderBy('order')->get();
                        if ($options->isNotEmpty()) {
                            $chosenOption = $options[($studentIndex + $surveyIndex) % $options->count()];
                            $answer->selected_option_id = $chosenOption->id;
                        }
                        $answer->likert_value = null;
                        $answer->text_value = null;
                    } elseif ($question->question_type === 'text') {
                        $feedbackIndex = ($studentIndex + $surveyIndex * 2) % count($feedbackPool);
                        $answer->text_value = $feedbackPool[$feedbackIndex];
                        $answer->likert_value = null;
                        $answer->selected_option_id = null;
                    }

                    $answer->save();
                }
            }
        }
    }
}
