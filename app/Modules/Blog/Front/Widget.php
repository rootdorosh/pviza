<?php

namespace App\Modules\Blog\Front;

use Illuminate\Support\Str;
use App\Base\WidgetBase;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\Category;
use FrontPage;
use App\Modules\Structure\Http\Requests\Block\InsertRequest;

class Widget extends WidgetBase
{
    const LIMIT = 6;

    /*
     * @var array
     */
    protected static $dependencies = [
        'blogFetchService' => 'App\Modules\Blog\Services\Fetch\BlogFetchService',
        'categoryFetchService' => 'App\Modules\Blog\Services\Fetch\CategoryFetchService',
    ];

    /*
     * @return array
     */
    public function getActions(): array
    {
        $actions = [];
        foreach ([
            'index',
            'category',
            'view'
        ] as $action) {
            $actions[$action] = __('blog::widget.actions.' . Str::snake($action));
        }

        return $actions;
    }

    /*
     * @return string
     */
    public function getName(): string
    {
        return __('blog::widget.name');
    }

    public function actionIndex()
    {
        $page = FrontPage::getVar('page', 1);
        $limit = self::LIMIT;

        $items = $this->blogFetchService->getItems([
            'q' => request()->input('q'),
            'page' => $page,
            'limit' => $limit,
        ]);

        $count = $this->blogFetchService->getCountItems([
            'q' => request()->input('q'),
        ]);

        return $this->view('index', compact('items', 'count', 'limit'));
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

        $items = $this->blogFetchService->getItems([
            'q' => request()->input('q'),
            'category_id' => $category->id,
            'page' => $page,
            'limit' => $limit,
        ]);

        $count = $this->blogFetchService->getCountItems([
            'q' => request()->input('q'),
            'category_id' => $category->id,
        ]);
        return $this->view('category', compact('category', 'items', 'count', 'limit'));
    }

    public function actionView()
    {
        $blog = $this->blogFetchService->getByAlias(FrontPage::getVar('alias'));
        if ($blog === null) {
            $this->render404();
        }

        FrontPage::setTitle(!empty($blog->seo_title) ? $blog->seo_title : $blog->title)
            ->setDescription(!empty($blog->seo_description) ? $blog->seo_description : $blog->title)
            ->setH1(!empty($blog->seo_h1) ? $blog->seo_h1 : $blog->title)
            ->setLangLinksMap($this->blogFetchService->getLangMapLinks($blog->id));

        $latests = $this->blogFetchService->getLatest(3);
        $related = $this->blogFetchService->getRelated($blog->category_id, 2);
        $categories = $this->blogFetchService->getCategories();

        return $this->view('view', compact('blog', 'latests', 'categories', 'related'));
    }
}
