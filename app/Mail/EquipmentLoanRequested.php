<?php

namespace App\Mail;

use App\Models\EquipmentLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EquipmentLoanRequested extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    public function __construct(EquipmentLoan $loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->markdown('emails.equipment.loan-requested')
            ->subject('Nueva solicitud de préstamo de equipo');
    }
}
