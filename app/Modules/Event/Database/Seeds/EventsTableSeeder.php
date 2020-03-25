<?php

namespace App\Modules\Event\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Services\EventService;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add Event Items
         *
         */
        foreach (EventService::getEvents() as $eventItem) {
            $attrs = [
                'event_id' => $eventItem['event_id'],
            ];
          
            $item = Event::where('event_id', '=', $eventItem['event_id'])->first();
            if ($item === null) {
                $item = new Event;
                
                $attrs['is_active'] = 1;
                $attrs['content_type'] = Event::CONTENT_TYPE_TEXT_PLAIN;
                foreach (config('translatable.locales') as $locale) {
                    $attrs[$locale] = [
                        'subject' => __($eventItem['subject'], [], $locale),
                        'body' => EventService::normalizeVars($eventItem['vars']),
                    ];
                }
                
                $item->fill($attrs);
                $item->save();
            
                echo "Add event: " . $eventItem['event_id'] . "\n";
            }
        }       
    }
}
