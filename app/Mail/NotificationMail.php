<?php

namespace App\Mail;

use App\Models\Bonds\Bonds;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $full_name;
    public $receipt_number;
    public $receipt_date;
    public $amount;
    public $totalAmount;
    public $AmountPaid;
    public $RemainingAmount;
    public $PropertyNumber;
    public $bonds_id;

    public function __construct($title, $full_name, $receipt_number, $receipt_date, $amount, $totalAmount, $AmountPaid, $RemainingAmount, $PropertyNumber, $bonds_id)
    {
        $this->title = $title;
        $this->full_name = $full_name;
        $this->receipt_number = $receipt_number;
        $this->receipt_date = $receipt_date;
        $this->amount = $amount;
        $this->totalAmount = $totalAmount;
        $this->AmountPaid = $AmountPaid;
        $this->RemainingAmount = $RemainingAmount;
        $this->PropertyNumber = $PropertyNumber;
        $this->bonds_id = $bonds_id;
    }

    public function build()
    {
        $Bonds = Bonds::find($this->bonds_id);

        return $this->subject($this->title)
                    ->view('emails.notification')
                    ->with([
                        'title' => $this->title,
                        'fullName' => $this->full_name,
                        'receipt_number' => $this->receipt_number,
                        'receipt_date' => $this->receipt_date,
                        'amount' => $this->amount,
                        'totalAmount' => $this->totalAmount,
                        'AmountPaid' => $this->AmountPaid,
                        'RemainingAmount' => $this->RemainingAmount,
                        'PropertyNumber' => $this->PropertyNumber,
                        'Bonds' => $Bonds,
                    ]);
    }
}
