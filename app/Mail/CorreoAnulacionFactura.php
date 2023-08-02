<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoAnulacionFactura extends Mailable
{
    use Queueable, SerializesModels;
    public $nombre;
    public $numero;
    public $fecha;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $numero, $fecha)
    {
        $this->nombre   = $nombre;
        $this->numero   = $numero;
        $this->fecha    = $fecha;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name       = $this->nombre;
        $date       = $this->fecha;
        $number     = $this->numero;
        return $this->view('mail.correoAnulacion')->with(compact('name', 'date', 'number'));
    }
}
