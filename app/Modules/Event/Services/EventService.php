<?php

namespace App\Modules\Event\Services;

use Illuminate\Support\Arr;
use App\Modules\Event\Models\Queue;
use App\Modules\Event\Services\Fetch\EventFetchService;
use App\Modules\Event\Jobs\QueueJob;
use App\Base\ScmsHelper;
use Setting;

/**
 * Class EventService
 */
class EventService
{    
    /**
     * @param string $params
     * 
     * @return string
     */
    public static function normalizeVars(string $params): string
    {
        $vars = explode(',', $params);

        $items = [];
        foreach ($vars as $var) {
            $var = trim($var);
            $items[] = "[{$var}]";
        }

        return implode(', ', $items);
    }   

    /**
     * @return array
     */
    public static function getEvents(): array
    {
        $events = [];
        
        foreach (ScmsHelper::getModules() as $module) {
            $eventsFile = app_path() . '/Modules/' . $module . '/Config/events.php';
            if (is_file($eventsFile)) {
                $items = include $eventsFile;
              
                foreach ($items as $item) {
                    $events[] = $item;
                }
            }
        }
        
        return $events;
    }
    
    /**
     * @return array
     */
    public static function getEventsList(): array
    {
        $list = [];
        
        foreach (self::getEvents() as $item) {
           $list[$item['event_id']] = __($item['subject']);
        }
        
        return $list;
    }

    /**
     * @param   string $eventId
     * @return  string
     */
    public static function getVars(string $eventId): string
    {
        $event = self::getEventConfByEventId($eventId);
        
        return self::normalizeVars($event['vars']);
    }

    
    /**
     * @param   string $eventId
     * @return  array|null
     */
    public static function getEventConfByEventId(string $eventId): ?array
    {
        $events = self::getEvents();
        $data = [];
        foreach ($events as $event) {
            if ($event['event_id'] === $eventId) {
                return $event;
            }
        }
        
        return null;
    }
    
    /**
     * @param string    $eventId
     * @param array     $params
     * @param array     $files
     * 
     * @return array
     */
    public static function addToQueue(string $eventId, array $params, array $files = []): array
    {
        $event = EventFetchService::getByEventId($eventId);
        $eventConf = self::getEventConfByEventId($eventId);
        
        if ($event && $eventConf) {
            $emails = [];
            if (!empty($params['email'])) {
                $emails[] = $params['email'];
            }
            // fetch emails from users
            foreach ($event->users as $user) {
                $emails[] = $user->email;
            }
            
            $vars = array_map('trim', explode(',', $eventConf['vars']));
            
            if (!empty($emails)) {
                 foreach ($vars as $var) {
                    if (isset($params[$var])) {
                        $event->subject = str_replace("[{$var}]", $params[$var], $event->subject);
                        $event->body = str_replace("[{$var}]", $params[$var], $event->body);
                    }
                }

                foreach ($emails as $email) {
                    $queue = new Queue;
                    $queue->event_id = $event->id;
                    $queue->subject = $event->subject;
                    $queue->body = $event->body;
                    $queue->from_email = !empty($event->from_email) 
                        ? $event->from_email 
                        : Setting::get('event_email_from');
                    $queue->from_name = !empty($event->from_name) 
                        ? $event->from_name 
                        : Setting::get('event_name_from');
                    $queue->email_to = $email;
                    $queue->status = Queue::STATUS_AWAIT;
                    $queue->created_time = time();
                    $queue->save();

                    QueueJob::dispatch($queue);
                }
            }
        }
        
        return $emails;
    }   
}
