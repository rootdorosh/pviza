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
            'privacy-policy' => 'Privacy policy',
            'work-in-poland' => 'Робота в Польщі',
            'searching' => 'Шукати',
            'кeywords' => 'Ключові слова',
            'city' => 'Місто',
            'categories-of-vacancies' => 'Категорії вакансій',
            'types-of-jobs' => 'Типи робіт',
            'locations-of-jobs' => 'Місце роботи',
            'search-by-vacancies' => 'Пошук по вакансіях',
            'vacancy.list.empty' => 'За вашим запитом не знайдено вакансій ...',
            'salary' => 'Заробітна плата:',
            'work-schedule' => 'Графік роботи:',
            'contract-type' => 'Тип договору:',
            'all-cities' => 'Всі міста',
            'related-vacancies-title' => 'Схожі вакансії з цієї ж категорії',
            '' => '',
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
