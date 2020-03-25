<?php

namespace App\Base\Requests;
 
use Illuminate\Foundation\Http\FormRequest as FormRequest;
use Illuminate\Support\Str;

/**
 * Class BaseRequest
 * @package App\Http\Requests
 */
class BaseRequest extends FormRequest
{
    /*
     * @param  string $module
     * @param  string $model
     * @param  bool   $translated
     * @return array
     */
    public function getAttributesLabels(string $module, string $model, bool $translated = false): array
    {
        $labels = __(Str::camel($module) . '::' . Str::snake(str_replace('.', '', $model)));
        if (!empty($labels['fields']) && is_array($labels['fields'])) {
            $labels = $labels['fields'];
        }
        
        if ($translated) {
            $modelName = "\App\Modules\\{$module}\Models\\" . str_replace('.', '\\', $model);
            $translatedAttributes = (new $modelName)->translatedAttributes;
            foreach (config('translatable.locales') as $locale) {
                foreach ($translatedAttributes as $transAttr) {
                    $labels[$locale . '.' . $transAttr] = $labels[$transAttr] . " ({$locale})";
                }                
            }
        }
        
        return $labels;
    }
}
