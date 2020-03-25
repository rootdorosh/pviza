<?php

namespace App\Base;

class ImportHelper
{
    /*
     * @param string $modelNamespace
     * @param array $data
     * @return void
     */
    public function run(string $modelNamespace, array $data)
    {
        foreach ($data as $item) {
            $modelNamespace::create(
                $this->normalizeData($modelNamespace, $item)
            );
        }
    }
    
    /*
     * @param string $modelNamespace
     * @param array $item
     * @return array
     */
    public function normalizeData(string $modelNamespace, array $item): array
    {
        $data = $item;
        $instance = new $modelNamespace;
        if (property_exists($instance, 'translatedAttributes')) {
            foreach ($instance->translatedAttributes as $translateAttr) {
                if (!empty($item[$translateAttr])) {
                    foreach (config('translatable.locales') as $locale) {
                        $data[$locale][$translateAttr] = $item[$translateAttr];
                    }
                    unset($data[$translateAttr]);
                }
            }
        }
        return $data;
    }
}
