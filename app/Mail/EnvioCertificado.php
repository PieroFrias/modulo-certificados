<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioCertificado extends Mailable
{
    use Queueable, SerializesModels;

    public $alumno;
    public $certificadoPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alumno, $certificadoPath)
    {
        $this->alumno = $alumno;
        $this->certificadoPath = $certificadoPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Certificado del Evento/curso')
                    ->view('emails.enviocert')
                    ->attach($this->certificadoPath, [
                        'as' => "{$this->alumno->nombre}_certificado.pdf",
                        'mime' => 'application/pdf',
                    ]);
    }
}
