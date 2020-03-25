<?php

namespace App\Modules\Event\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Modules\Event\Models\Queue;

class EventMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Queue instance.
     *
     * @var Queue
     */
    protected $queueModel;

    /**
     * Create a new message instance.
     *
     * @param Queue $queue
     * @return void
     */
    public function __construct(Queue $queueModel)
    {
        $this->queueModel = $queueModel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->html($this->queueModel->body)->subject($this->queueModel->subject);
    }
}