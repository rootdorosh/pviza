<?php

declare( strict_types = 1 );

namespace App\Modules\Feedback\Services\Crud;

use App\Modules\Feedback\Models\Feedback;
use App\Modules\Event\Services\EventService;

/**
 * Class FeedbackCrudService
 */
class FeedbackCrudService
{
    /*
     * @var EventService
     */
    private $eventService;

    /*
     * @param EventService $authService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /*
     *
     * @param    array $data
     * @return  Feedback
     */
    public function store(array $data): Feedback
    {
        $data['created_at'] = time();

        $feedback = Feedback::create($data);
        $feedback->refresh();

        $this->eventService->addToQueue('feedback.send', [
            'uemail' => $feedback->email,
            'name' => $feedback->name,
            'phone' => $feedback->phone,
            'message' => $feedback->message,
        ]);
        return $feedback;
	}

    /*
     *
     * @param    Feedback $feedback
     * @param    Feedback $data
     * @return  Feedback
     */
    public function update(Feedback $feedback, array $data): Feedback
    {         $feedback->update($data);

        return $feedback;
    }

    /*
     * @param    Feedback $feedback
     * @return  void
     */
    public function destroy(Feedback $feedback): void
    {
        $feedback->delete();
    }

    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Feedback::destroy($ids);
    }



}
