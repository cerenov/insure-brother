<?php

namespace App\Mail;

use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    protected $id;
    protected $phone;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Response $data)
    {
        $this->name = $data['name'];
        $this->id = $data['id'];
        $this->phone = $data['phone'];
        $this->email = $data['mail'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notification', [
            'name' => $this->name,
            'id' => $this->id,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);
    }
}
