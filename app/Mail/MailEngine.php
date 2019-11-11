<?php

namespace App\Mail;

use App\Models\Application\Settings;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class MailEngine extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $subject;

    public $other_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $subject, $other_data = array())
    {
        //
        $this->user = $user;
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
        //config('')
        switch ($this->subject){

            case 'Consult Confirmation':

                break;
            case 'Password Reset':
                return $this->view('mails.auth.reset');
                break;

            case 'Invitation':
                $this->subject = $this->subject.' to '.Config('settings.application.name');
                return $this->view('mails.invite.invite');
                break;

            case Settings::MAKE_MASTER_ADMIN: //Invite user to be master admin
                $this->subject = $this->other_data['practice_name'].": ".Settings::MAKE_MASTER_ADMIN;
                return $this->view('mails.invite.master');
                break;

            case Settings::MASTER_FACILITY_ADMIN: //Decline master admin role
                $this->subject = $this->other_data['practice_name'].": ".Settings::MASTER_FACILITY_ADMIN;
                return $this->view('mails.invite.master_action');
                break;

            default: //default will always be an email verification
                return $this->view('mails.auth.verify');
                break;
        }
    }
}
