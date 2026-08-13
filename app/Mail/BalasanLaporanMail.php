<?php

namespace App\Mail;

use App\Models\Laporan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BalasanLaporanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $laporan;
    public $pesanBalasan;

    public function __construct(Laporan $laporan, $pesanBalasan)
    {
        $this->laporan = $laporan;
        $this->pesanBalasan = $pesanBalasan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ' Tanggapan Laporan: ' . $this->laporan->judul,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "
                <div style='font-family: \"Inter\", Helvetica, Arial, sans-serif; background-color: #000000; padding: 40px 30px; border-radius: 4px; max-width: 500px; margin: 0 auto; color: #FFFFFF; text-align: center;'>
                    
                    <h2 style='margin-top: 0; margin-bottom: 20px; font-size: 22px; font-weight: bold;'>Status Laporan: Selesai</h2>
                    
                    <p style='font-size: 14px; line-height: 1.6; color: #E0E0E0; margin-bottom: 30px;'>
                        Halo <strong>{$this->laporan->user->name}</strong>,<br><br>
                        Laporan Anda mengenai masalah <strong>\"{$this->laporan->judul}\"</strong> telah ditinjau dan diselesaikan oleh Admin. Berikut adalah tanggapan untuk Anda:
                    </p>
                    
                    <!-- KOTAK PESAN BALASAN (MIRIP KOTAK OTP) -->
                    <div style='background-color: #1A1A1A; border-radius: 12px; padding: 24px; margin-bottom: 30px;'>
                        <p style='margin: 0; font-size: 15px; font-weight: 500; color: #FFFFFF; letter-spacing: 0.5px; line-height: 1.5;'>
                            \"{$this->pesanBalasan}\"
                        </p>
                    </div>

                    <p style='font-size: 12px; color: #888888; margin: 0; line-height: 1.5;'>
                        Terima kasih telah membantu kami menjaga kenyamanan sistem.<br>
                        Jangan ragu untuk melapor kembali jika Anda menemukan kendala.
                    </p>
                    
                </div>
            "
        );
    }
}
