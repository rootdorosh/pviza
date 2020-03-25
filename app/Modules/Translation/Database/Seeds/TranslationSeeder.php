<?php

namespace App\Modules\Translation\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Translation\Models\Translation;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            'order' => 'Order',
            'order_cloud_server' => 'Order Cloud Server',
            'message' => 'Message',
            'message_sent' => 'Message sent',
            'mobile' => 'Mobile',
            'name' => 'Name',
            'email' => 'E-mail',
            'your_email' => 'Your e-mail',
            'tariff_required' => 'Please choose a tariff',
            'form_order_success_sent' => 'You order success sent',
            'tariffs' => 'Tariffs',
            'tariff' => 'Tariff',
        ];
        
        foreach ($items as $slug => $value) {
            
            if (empty($value)) {
                continue;
            }
            
            if (Translation::where('slug', '=', $slug)->first() === null) {
                $attrs = compact('slug');
                foreach (config('translatable.locales') as $locale) {
                    $attrs[$locale]['value'] = $value;
                }
                
                preg_match_all('/(\[(.*?)\])/', $value, $matches);
                if (!empty($matches[2])) {
                    $attrs['params'] = $matches[2];
                }
                
                $translation = Translation::create($attrs);
                echo "\t Add translation: $translation->slug \n";
            }
        }        
    }
}
