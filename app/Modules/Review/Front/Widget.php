<?php

namespace App\Modules\Review\Front;

use Illuminate\Support\Str;
use App\Base\WidgetBase;
use App\Modules\Review\Models\Review;
use FrontPage;
use App\Modules\Structure\Http\Requests\Block\InsertRequest;

class Widget extends WidgetBase
{
    const LIMIT = 9;

    /*
     * @var array
     */
    protected static $dependencies = [
        'reviewFetchService' => 'App\Modules\Review\Services\Fetch\ReviewFetchService',
    ];

    /*
     * @return array
     */
    public function getActions(): array
    {
        $actions = [];
        foreach ([
            'index',
        ] as $action) {
            $actions[$action] = __('review::widget.actions.' . Str::snake($action));
        }

        return $actions;
    }

    /*
     * @return string
     */
    public function getName(): string
    {
        return __('review::widget.name');
    }

    public function actionIndex()
    {
        $page = FrontPage::getVar('page', 1);
        $limit = self::LIMIT;

        $items = $this->reviewFetchService->getItems([
            'page' => $page,
            'limit' => $limit,
        ]);

        $count = $this->reviewFetchService->getCountItems();

        return $this->view('index', compact('items', 'count', 'limit'));
    }
}
