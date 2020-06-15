<?php

namespace App\Modules\Feedback\Front;

use App\Base\WidgetBase;
use App\Modules\Structure\Http\Requests\Block\InsertRequest;
use Illuminate\Support\Str;

class Widget extends WidgetBase
{
    /*
     * @return array
     */
    public function getActions(): array
    {
        $actions = [];
        foreach ([
            'index',
        ] as $action) {
            $actions[$action] = __('feedback::widget.actions.' . Str::snake($action));
        }

        return $actions;
    }

    /*
     * @return string
     */
    public function getName(): string
    {
        return __('feedback::widget.name');
    }

    public function actionIndex()
    {
       return $this->view('index');
    }

    public function actionCategory()
    {
        $category = $this->categoryFetchService->getByAlias(FrontPage::getVar('alias'));
        if ($category === null) {
            $this->render404();
        }

        FrontPage::setTitle(!empty($category->seo_title) ? $category->seo_title : $category->title)
            ->setDescription(!empty($category->seo_description) ? $category->seo_description : $category->title)
            ->setH1(!empty($category->seo_h1) ? $category->seo_h1 : $category->title)
            ->setLangLinksMap($this->categoryFetchService->getLangMapLinks($category->id));

        $page = FrontPage::getVar('page', 1);
        $limit = self::LIMIT;

        $items = $this->feedbackFetchService->getItems([
            'q' => request()->input('q'),
            'category_id' => $category->id,
            'page' => $page,
            'limit' => $limit,
        ]);

        $count = $this->feedbackFetchService->getCountItems([
            'q' => request()->input('q'),
            'category_id' => $category->id,
        ]);
        return $this->view('category', compact('category', 'items', 'count', 'limit'));
    }

    public function actionView()
    {
        $feedback = $this->feedbackFetchService->getByAlias(FrontPage::getVar('alias'));
        if ($feedback === null) {
            $this->render404();
        }

        FrontPage::setTitle(!empty($feedback->seo_title) ? $feedback->seo_title : $feedback->title)
            ->setDescription(!empty($feedback->seo_description) ? $feedback->seo_description : $feedback->title)
            ->setH1(!empty($feedback->seo_h1) ? $feedback->seo_h1 : $feedback->title)
            ->setLangLinksMap($this->feedbackFetchService->getLangMapLinks($feedback->id));

        $latests = $this->feedbackFetchService->getLatest(3);
        $related = $this->feedbackFetchService->getRelated($feedback->category_id, 2);
        $categories = $this->feedbackFetchService->getCategories();

        return $this->view('view', compact('feedback', 'latests', 'categories', 'related'));
    }
}
