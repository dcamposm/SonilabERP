<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\RegistreEntrada;

class RegistreEntradaUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $registreEntrada;
    public $request;
    
    public function __construct(RegistreEntrada $registreEntrada, RegistreEntrada $request)
    {
        $this->registreEntrada = $registreEntrada;
        $this->request = $request;
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
