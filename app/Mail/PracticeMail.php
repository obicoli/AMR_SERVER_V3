<?php

namespace App\Mail;

use App\Models\Practice\Practice;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PracticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $practice;

    public $model;

    public $subject;

    public $other_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Practice $practice, $model = false, $subject, $other_data = array())
    {
        $this->practice = $practice;
        $this->model = $model;
        $this->subject = $subject;
        $this->other_data = $other_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->subject){

            case Practice::AC_VERIFICATION:
                return $this->view('mails.practice.activation');
                break;
            case 'Password Reset':
                return $this->view('mails.auth.reset');
                break;

            case 'Invitation':
                $this->subject = $this->subject.' to '.$this->other_data['name'];
                return $this->view('mails.invite.invite');
                break;

            default: //default will always be an email verification
                return $this->view('mails.auth.verify');
                break;
        }
    }
}
