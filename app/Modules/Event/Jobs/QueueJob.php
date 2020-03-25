<?php

namespace App\Modules\Event\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Event\Models\Queue;
use App\Modules\Event\Mail\EventMail;
use Illuminate\Support\Facades\Mail;

/**
 * Class QueueJob
 * @package App\Modules\Event
 */
class QueueJob implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     *
     * @var Queue
     */
    protected $queueModel;

    /**
     * Create a new job instance.
     *
     * @param Queue $queueModel
     * @return void
     */
    public function __construct(Queue $queueModel)
    {
        $this->queueModel = $queueModel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->queueModel->email_to)->send(new EventMail($this->queueModel));

        $this->queueModel->status = Queue::STATUS_SEND;
        $this->queueModel->save();
    }
}
