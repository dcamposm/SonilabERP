<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\RegistreEntrada;

class RegistreEntradaCreat extends Mailable
{
    use Queueable, SerializesModels;

    public $registreEntrada;
    
    public function __construct(RegistreEntrada $registreEntrada)
    {
        $this->registreEntrada = $registreEntrada;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('registre_entrada.email');
    }
}
