<?php

declare( strict_types = 1 );

namespace App\Modules\Settings\Services;

use App\Modules\Settings\Models\Settings;
use App\Modules\Menu\Services\Fetch\MenuFetchService;
use App\Modules\ContentBlock\Services\Fetch\ContentBlockFetchService;
use App\Base\ExtArrHelper;
use Setting;

/**
 * Class SettingsService
 */
class SettingsService
{
    /*
     * @var MenuFetchService
     */
    private $menuFetchService;

    /*
     * @var ContentBlockFetchService
     */
    private $contentBlockFetchService;

    /*
    * @param  MenuFetchService $menuFetchService
    * @param  ContentBlockFetchService $contentBlockFetchService
    */
    public function __construct(MenuFetchService $menuFetchService, ContentBlockFetchService $contentBlockFetchService)
    {
        $this->menuFetchService = $menuFetchService;
        $this->contentBlockFetchService = $contentBlockFetchService;
    }

    /*
     * @return  array
     */
    public function getMeta(): array
    {
        $texts = __('settings::settings');

        $data = [
            'labels' => $texts,
            'tabs' =>  [
                'menu' => [
                    'title' => $texts['tabs']['menu'],
                    'fields' => [
                        'menu_header_id' => [
                            'type' => 'select',
                            'options' => ExtArrHelper::valueTextFromList($this->menuFetchService->getList()),
                            'value' => Setting::get('menu_header_id'),
                        ],
                        'menu_footer_id' => [
                            'type' => 'select',
                            'options' => ExtArrHelper::valueTextFromList($this->menuFetchService->getList()),
                            'value' => Setting::get('menu_footer_id'),
                        ],
                    ],
                ],
                'event' => [
                    'title' => $texts['tabs']['event'],
                    'fields' => [
                        'event_email_from' => [
                            'type' => 'text',
                            'value' => Setting::get('event_email_from'),
                        ],
                        'event_name_from' => [
                            'type' => 'text',
                            'value' => Setting::get('event_name_from'),
                        ],
                    ],
                ],
                'social' => [
                    'title' => $texts['tabs']['social'],
                    'fields' => [
                        'social_facebook' => [
                            'type' => 'text',
                            'value' => Setting::get('social_facebook'),
                        ],
                        'social_twitter' => [
                            'type' => 'text',
                            'value' => Setting::get('social_twitter'),
                        ],
                        'social_instagram' => [
                            'type' => 'text',
                            'value' => Setting::get('social_instagram'),
                        ],
                    ],
                ],
                'contact' => [
                    'title' => $texts['tabs']['contacts'],
                    'fields' => [
                        'contact_phone' => [
                            'type' => 'text',
                            'value' => Setting::get('contact_phone'),
                        ],
                        'contact_email' => [
                            'type' => 'text',
                            'value' => Setting::get('contact_email'),
                        ],
                        'contact_viber' => [
                            'type' => 'text',
                            'value' => Setting::get('contact_viber'),
                        ],
                        'contact_telegram' => [
                            'type' => 'text',
                            'value' => Setting::get('contact_telegram'),
                        ],
                        'contact_whatsapp' => [
                            'type' => 'text',
                            'value' => Setting::get('contact_whatsapp'),
                        ],
                    ],
                ],
                'cb' => [
                    'title' => $texts['tabs']['cb'],
                    'fields' => [
                        'cb_contact_footer' => [
                            'type' => 'select',
                            'options' => ExtArrHelper::valueTextFromList($this->contentBlockFetchService->getList()),
                            'value' => Setting::get('cb_contact_footer'),
                        ],
                        'cb_page_contact_header' => [
                            'type' => 'select',
                            'options' => ExtArrHelper::valueTextFromList($this->contentBlockFetchService->getList()),
                            'value' => Setting::get('cb_page_contact_header'),
                        ],
                        'cb_page_contact_footer' => [
                            'type' => 'select',
                            'options' => ExtArrHelper::valueTextFromList($this->contentBlockFetchService->getList()),
                            'value' => Setting::get('cb_page_contact_footer'),
                        ],
                    ],
                ],
            ],
        ];

        return $data;
	}

    /*
     * @param    array $data
     * @return  void
     */
    public function store(array $data)
    {
        Settings::getQuery()->delete();

        $setting = resolve('App\Modules\Settings\Container\Setting');
        foreach ($data as $key => $value) {
            $setting->set($key, $value);
        }
	}
}
