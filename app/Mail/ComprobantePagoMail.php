<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class ComprobantePagoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pago;

    public function __construct($pago)
    {
        $this->pago = $pago;
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.comprobante-pago', // Crea esta vista simple en HTML
            with: [
                'paymentData' => $this->pago
            ]
        );
    }

    public function attachments(): array
    {
        // Generamos el PDF en memoria
        $pdf = Pdf::loadView('pdf.comprobante-pago', ['paymentData' => $this->pago]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'comprobante_pago.pdf')
                ->withMime('application/pdf'),
        ];
    }
    // public function build(){
    //     return $this->view('mail.comprobante-pago', [
    //         'paymentData' => $this->pago,
    //     ]);
    // }
}