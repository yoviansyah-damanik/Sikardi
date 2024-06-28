<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WaHelper
{
    const SEND_URL = "https://api.fonnte.com/send";

    private string $token;
    private string $delay;
    private string $countryCode;

    private function getToken()
    {
        return $this->token;
    }

    private function getDelay()
    {
        return $this->delay;
    }

    private function getCountryCode()
    {
        return $this->countryCode;
    }

    public function __construct()
    {
        $this->token = env('WA_TOKEN');
        $this->delay = env('WA_DELAY');
        $this->countryCode = env('WA_COUNTRY_CODE');
    }

    public static function sendMessage(string $text, string | array $dest, ?string $url = null)
    {
        $values = new WaHelper();
        $token = $values->getToken();
        $delay = $values->getDelay();
        $countryCode = $values->getCountryCode();

        if (is_array($dest)) {
            $dest = collect($dest)->join(', ');
        }

        $payload = [
            'target' => $dest,
            'message' => $text,
            'delay' => $delay,
            'countryCode' => $countryCode,
        ];

        $response = Http::withHeaders([
            "Authorization" => $token
        ])->post(self::SEND_URL, $payload);

        return $response->json();
    }

    public static function getTemplate(string $whatTemplate, String | array $payload)
    {
        $template = '';
        if ($whatTemplate == 'create_user') {
            $template = "Akun kamu telah berhasil didaftarkan.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "Tipe : *" . $payload['type'] . "*\n\n"
                . "ID : *" . $payload['id'] . "*\n"
                . "Kata Sandi : *" . $payload['id'] . "*\n\n"
                . "Kamu dapat _login_ melalui link di bawah ini.\n"
                . route('login');
        } else if ($whatTemplate == 'student_registration') {
            $template = "Akun kamu telah berhasil ditambahkan.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Token : *" . $payload['token'] . "*\n\n"
                . "Silahkan melakukan pendaftaran lebih lanjut melalui link di bawah ini.\n"
                . route('register');
        } else if ($whatTemplate == 'successful_registration') {
            $template = "Pendaftaran berhasil dilakukan.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Kata Sandi : *" . $payload['password'] . "*\n\n"
                . "Data pribadi merupakan tanggung jawab pribadi. Harap mengganti kata sandi setelah kamu berhasil _login_.\n\n"
                . "Kamu dapat _login_ melalui link di bawah ini.\n"
                . route('login');
        } else if ($whatTemplate == 'successful_registration_staff') {
            $template =  "Seorang Mahasiswa telah berhasil melakukan pendaftaran.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "NPM : *" . $payload['npm'] . "*\n\n"
                . "Silahkan tetapkan Dosen Pembimbing agar Mahasiswa tersebut dapat melakukan proses bimbingan.\n"
                . route('staff.student', ['search' => $payload['npm']]);
        } else if ($whatTemplate == 'forgot_password') {
            $template = "Proses lupa kata sandi berhasil. Berikut data akun terbaru kamu.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "ID : *" . $payload['id'] . "*\n"
                . "Kata Sandi Baru : *" . $payload['new_password'] . "*\n\n"
                . "Data pribadi merupakan tanggung jawab pribadi. Harap mengganti kata sandi setelah kamu berhasil _login_.\n\n"
                . "Kamu dapat _login_ melalui link di bawah ini.\n"
                . route('login');
        } else if ($whatTemplate == 'assign_supervisor') {
            $template = "*" . $payload['lecturer_name'] . " (NIDN. " . $payload['lecturer_id'] . ")* telah ditetapkan sebagai *" . $payload['as'] . "* pada Mahasiswa berikut.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n\n"
                . "Mohon kerjasama untuk membimbing Mahasiswa tersebut.\n\n"
                . "Kamu dapat melihat Mahasiswa Bimbingan dengan mengklik tautan berikut ini.\n"
                . route('lecturer.student');
        } else if ($whatTemplate == 'create_submission') {
            $template =  "Mahasiswa bimbingan kamu telah mengirimkan pengajuan Kartu Rencana Studi (KRS).\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "Semester : *" . $payload['semester'] . "*\n"
                . "Total SKS : *" . $payload['cc'] . "*\n\n"
                . "Waktu Pengajuan : *" . $payload['time'] . "*\n\n"
                . "Silahkan konfirmasi pengajuan Mahasiswa yang bersangkutan melalui link di bawah ini.\n"
                . route('lecturer.student-submission.approval', ['student' => $payload['npm']]);
        } else if ($whatTemplate == 'student_passed') {
            $template =  "Selamat! Kamu telah dinyatakan lulus. Berikut informasi yang kamu peroleh.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "IPK : *" . $payload['gpa'] . "*\n"
                . "Status : *" . $payload['status'] . "*\n\n"
                . "Segenap Dosen Pengajar dan seluruh Staf yang bertugas mengucapkan selamat atas *KELULUSAN* kamu.";
        } else if ($whatTemplate == 'student_passed_change') {
            $template =  "Mohon maaf, terjadi kesalahan pada saat kami melakukan perubahan kelulusan. Informasi kelulusan kamu telah diubah.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "Status : *" . $payload['status'] . "*";
        } else if ($whatTemplate == 'approval_confirmation') {
            $template = "Dosen Pembimbing kamu *" . $payload['lecturer'] . " (NIDN. " . $payload['nidn'] . ")* telah melakukan konfirmasi pengajuan Kartu Rencana Studi (KRS) kamu.\n\n"
                . "Status : *" . $payload['status'] . "*\n"
                . "Waktu : *" . $payload['time'] . "*\n"
                . "Pesan : *" . $payload['message'] . "*\n\n"
                . "Silahkan periksa kembali Kartu Rencana Studi yang telah kamu ajukan. Jika ada revisi, harap segera merubahnya dan mengirimkan Kartu Rencana Studi (KRS) kembali.\n"
                . route('student.submission');
        } else if ($whatTemplate == 'create_payment') {
            $template =  "Seorang Mahasiswa mengirimkan bukti pembayaran.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "Semester : *" . $payload['semester'] . "*\n\n"
                . "Silahkan konfirmasi pembayaran Mahasiswa yang bersangkutan melalui link di bawah ini.\n"
                . route('staff.payment', ['search' => $payload['npm']]);
        } else if ($whatTemplate == 'payment_confirm') {
            $template =  "Pembayaran kamu telah dikonfirmasi.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "Semester : *" . $payload['semester'] . "*\n"
                . "Status : *" . $payload['status'] . "*\n"
                . "Harap periksa status pembayaran kamu. Apabila ada kesalahan, kamu dapat menghubungi Administrator.\n"
                . route('home');
        }

        $footer = "\n\n\n_Pesan ini dikirimkan secara otomatis oleh Bot WA " . GeneralHelper::appName() . " Prodi Ilmu Komputer UGN. Mohon untuk tidak membalas pesan ini._";

        return $template . $footer;
    }
}
