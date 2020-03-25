<?php

namespace App\Modules\Structure\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use App\Modules\Structure\Services\Fetch\PageFetchService;
use App\Modules\Structure\Services\Fetch\DomainFetchService;
use App\Modules\Structure\Services\Fetch\BlockFetchService;
use App\Modules\Structure\Models\{
    Domain,
    Page,
    Block
};
use App\Base\ScmsHelper;
use FrontPage;

class StructureService
{
    const TEMPLATES = [
        [
            'id' => 1,
            'title' => 'Главная',
            'alias' => 'home',
            'layout' => 'main',
        ],
        /*
		[
            'id' => 2,
            'title' => 'Left',
            'alias' => 'left',
            'layout' => 'main',
		],
        [
            'id' => 3,
            'title' => 'Right',
            'alias' => 'right',
            'layout' => 'main',
	    ],
        */
    ];

    public static $storage = [];

    /**
     * Длинна ID одной страницы в блоке ID
     */
    const ID_PART_LEN = 6;

    /**
     * Разделитель пейджей в пути, в векторе пейджей
     */
    const PATH_DELIMITER = '/';

    /**
     * Шаблон для названия ссылки на просмотра страницы
     */
    const PAGE_TEMPLATE = '%d';

    /**
     * Шаблон блока вставки
     */
    const EMBED_TEMPLATE = '<!--@%s-->';

    /*
     * @return array
     */
    public static function getTemplatesList(): array
    {
        $data = [];
        foreach (self::TEMPLATES as $templateId => $templateData) {
            $data[$templateId] = sprintf('%s: %s[%s]', 
                $templateData['title'], 
                $templateData['alias'], 
                $templateData['layout']
            );
        }
        
        return $data;
    }
    
    public static function getTemplateTitle($template_id)
    {
        $list = self::getTemplatesList();

        if (isset($list[$template_id])) {
            return $list[$template_id];
        } else {
            return false;
        }
    }
    
    /*
     * @param Domain $domain
     * @return Page|null
     */
    public function getDomainRootPage(Domain $domain): ?Page
    {
        return Page::where(['domain_id' => $domain->id])
                    ->whereRaw('LENGTH(`structure_id`) = ' . self::ID_PART_LEN)
                    ->first();
    }
    
    /*
     * @param array $params
     * @param Domain $domain
     * @return Page
     */
    public function makeDomainRootPage(Domain $domain, array $params = []): Page
    {
        if ($rootPage = $this->getDomainRootPage($domain)) {
            return $rootPage;
        }
        
        $title = 'Главная - ' . $domain->alias;
        
        $attributes = [
            'structure_id' => self::buildNewPageStructureId(), //строим "следующий" не занятый структурный айди
            'template_id' => 1,
            'alias' => 'index',
            'domain_id' => $domain->id,
        ];
        foreach ($params as $key => $value) {
            $attributes[$key] = $value;
        }
        
        foreach (config('translatable.locales') as $locale) {
            $attributes[$locale]['seo_title'] = $title;
        }
        
        return Page::create($attributes);
    }
    
    /*
     * @param Page $page
     * @param string $alias
     * @return Page|null
     */
    public function getChildByAlias(Page $page, string $alias): ?Page
    {
        return Page::where(['domain_id' => $page->domain_id])
                    ->where('alias', $alias)
                    ->whereRaw('LENGTH(structure_id) = ' . (strlen($page->structure_id) + self::ID_PART_LEN))
                    ->whereRaw('structure_id LIKE "' . $page->structure_id . '%"')
                    ->first();        
    }
    
    /*
     * @param Page $parentPage
     * @param array $attributes
     * @return Page
     */
    public function makePage(Page $parentPage, array $attributes): Page
    {
        if ($page = $this->getChildByAlias($parentPage, $attributes['alias'])) {
            return $page;
        }
        
        $attributes['structure_id'] = self::buildNewPageStructureId($parentPage->id);
        $attributes['domain_id'] = $parentPage->domain_id;
        
        return Page::create($attributes);        
    }
    
    /*
     * @param Page $page
     * @return void
     */
    public function removePage(Page $page): void
    {
        $page->delete();
        // remove all children
        $items = Page::where('structure_id', 'like', "{$page->structure_id}%")->get();
        foreach ($items as $item) {
            $item->delete();
        }
    }
    
    /*
     * @param Page $page
     * @return Page
     */
    public function copyPage(Page $page): Page
    {
        $parent = self::getPageByStructureId(substr($page->structure_id, 0, 0 - self::ID_PART_LEN));
        
        $attributes = array_filter($page->toArray(), function($key) {
            return !in_array($key, ['id', 'translations']);
        }, ARRAY_FILTER_USE_KEY);        
        
        $attributes['structure_id'] = self::buildNewPageStructureId($parent->id);
        $attributes['alias'] =  self::buildNewPageAlias($parent->structure_id, $page->alias . '-1');
        
        foreach ($page->translations as $translation) {
            foreach ($page->translatedAttributes as $attr) {
                $attributes[$translation->locale][$attr] = $translation->$attr;
            }
        }
        
        $newPage = Page::create($attributes);
        
        foreach ($page->blocks as $block) {
            $attrs = array_filter($block->toArray(), function($key) {
                return !in_array($key, ['id']);
            }, ARRAY_FILTER_USE_KEY);        
            
            $newPage->blocks()->save(new Block($attrs));
        }
        
        return $newPage;
        
    }
    
    /*
     * @param string $structureId
     * @param string $alias
     * @return string
     */
    public static function buildNewPageAlias(string $structureId, string $alias): string
    {
        $where = "alias = '{$alias}' AND structure_id LIKE '{$structureId}%' AND structure_id <> '{$structureId}'";
        $page = Page::whereRaw($where)->first();

        if (!empty($model)) {
            $expl = explode('-', $alias);
            $num = end($expl);
            $len = 0 - strlen($num);
            $alias = substr($alias, 0, $len);
            $num++;

            return self::buildNewPageAlias($structureId, $alias . $num);
        }

        return $alias;
    }
    
    /*
     * @param Page $page
     * @param int $parentId
     * @return Page
     */
    public function movePage(Page $page, $parentId): Page
    {
        $structureId = $page->structure_id;

        $page->structure_id = self::buildNewPageStructureId($page->parent_id);
        $page->save();
        
        //Archive::add(); //TODO

        //изменяем structure_id у всех дочерних страниц
        $children = Page::whereRaw("structure_id LIKE  '{$structureId}%' AND id <> {$page->id}")->get();
        foreach ($children as $child) {
            $child->structure_id = preg_replace('~^(?<!' . $structureId . ')(' . $structureId . ')~', $page->structure_id, $child->structure_id);
            $child->save();
        }
        
        return $page;
    }
    
    /**
     * Формируем structure_id под новую страницу, в записимости от parentId
     * 
     * @param integer $parentId -- порядковый номер страницы-родителя
     * @return string $structureId -- структурный порядковый номер
     */
    public static function buildNewPageStructureId($parentId = null): string
    {
        $model = null;
        $where = '';

        //если указан номер родительской страницы, то формируем структурный айди на основе структурного айди родителя
        if (!empty($parentId)) {

            $parentPage = (new PageFetchService())->byId($parentId);
            if (!empty($parentPage)) {

                //берем максимальную айдишку вложенной страницы
                $where = 'SUBSTRING(`structure_id`, 1, ' . strlen($parentPage->structure_id) . ') = ' . 
                    $parentPage->structure_id . ' AND LENGTH(`structure_id`) = ' . 
                    strlen($parentPage->structure_id) . '+' . self::ID_PART_LEN;
            }
        } else {
            $where = 'LENGTH(`structure_id`) = ' . self::ID_PART_LEN;
        }

        $id = null;
        
        //пытаемся получить страницу по указанным критериям
        $page = Page::select(['structure_id'])->whereRaw($where)->orderBy('structure_id', 'DESC')->first();
        
        if (!empty($page)) {
            //если есть страница, то работаем с её структурным айди
            $id = $page->structure_id;
        } else {

            //если нет страницы, то формируем новый
            if (!empty($parentPage)) {
                $id = sprintf("%s000000", $parentPage->structure_id);
            } else {
                $id = '000000';
            }
        }
        
        $c = (int) ltrim(substr($id, strlen($id) - self::ID_PART_LEN, self::ID_PART_LEN), 0);
        
        //обрабатываем и приплюсовываем 1
        $structureId = sprintf("%s%06d", substr($id, 0, strlen($id) - self::ID_PART_LEN), ($c + 1));

        return $structureId;
    }
    
    /**
     * @param Domain $domain
     * @param string $attrKey
     * @return array
     */
    public static function getDomainTree(Domain $domain, string $attrKey = 'alias'): array
    {
		return self::toTree($domain->pages, $attrKey); 
		/*
        return [
			'name' => $domain->alias,
			'children' => $tree,
		];
		*/
    }
    

    /**
     * Приводим данные о страницах сайта из плоского списка в дерево,
     * удобное для последующего маппинга при поиске данных востребованной страницы
     * @param $pages -- вектор со страницами
     * @param string $attrKey
     * @param boolean $swap -- переключатель айди/алиас страницы в качестве ключа вектора
     * @return array
     */
    public static function toTree($pages, string $attrKey = 'alias')
    {
        $result = [];
        //идем по списку пейджей, собирая их параметры
        foreach ($pages as $data) {

            $blocks = [];

            //d($data);

            $settings = [
                'id' => $data->id,
                'structure_id' => $data->structure_id,
                'template_id' => $data->template_id,
                'alias' => $data->alias,
                'title' => $data->seo_title,
                'blocks' => $blocks,
            ];

            $result = self::_findBranch($result, $data->structure_id, $settings);
        }

        $data = self::swapIdsToPagesNames($result, $attrKey);

        return $data;
    }

    /**
     * Рекурсивно строим дерево пейджей
     * @param array $tree - ветка
     * @param string $id - айдишка обрабатываемого элемента
     * @param array $data - данные обрабатываемого элемента
     * @return array - возвращаем обработанную ветку 
     */
    private static function _findBranch($tree = [], $structureId, $data = [])
    {
        if (strlen($structureId) == self::ID_PART_LEN) {

            $tree[$structureId] = $data;
        } else {

            $f = substr($structureId, 0, self::ID_PART_LEN);
            if (!isset($tree[$f])) {
                $tree[$f] = $data;
            }

            $embeddedPages = [];
            if (isset($tree[$f]['children'])) {
                $embeddedPages = $tree[$f]['children'];
            }

            $tree[$f]['children'] = self::_findBranch($embeddedPages, substr($structureId, self::ID_PART_LEN), $data);
        }
        
        return $tree;
    }

    /**
     * Идем по дереву пейджей, переключаемся между ключем-айди на ключ-имя пейджи
     * для удобства последующего маппинга при поиске данных восстребованной страницы
     * @param array $tree
     * @param string $attrKey
     * @return array
     */
    private static function swapIdsToPagesNames($tree = [], string $attrKey = 'alias')
    {
        if (is_array($tree) && count($tree)) {
            foreach ($tree as $id => $data) {

                $embeddedPages = [];
                if (isset($data['children'])) {
                    $embeddedPages = $data['children'];
                }
                $data['children'] = self::swapIdsToPagesNames($embeddedPages, $attrKey);

                $tree[$data[$attrKey]] = $data;
                if ($data[$attrKey] != $id) {
                    unset($tree[$id]);
                }
            }
        }
        return $tree;
    }
    
    /*
     * @param string string $structureId
     * @return Page
     */
    public static function getPageByStructureId(string $structureId): Page
    {
        return self::getAllPages()->reject(function ($item) use ($structureId) {
            return $item->structure_id !== $structureId;
        })->first();
    }
    
    /*
     * @param string int $id
     * @return Page
     */
    public static function getPageById(int $id): Page
    {
        return self::getAllPages()->reject(function ($item) use ($id) {
            return $item->id !== $id;
        })->first();
    }
    
    
    /**
     * Рекурсивно приводим дерево пейджей к удобоваримому виду для класса CTreeView
     * @param array $treePages
     * @return array
     */
    public static function build($currentDomain = '', array $treePages, $activePage = 0)
    {
        $pages = [];

        $expanded = self::DEFAULT_EXPANDED_STATUS;

        if (count($treePages)) {
            foreach ($treePages as $index => $descr) {

                //если ключ данных подходим под параметры, вырезаем название домена
                if (preg_match('/^(.+?)\_index$/', $index, $match)) {
                    $currentDomain = $match[1];
                }

                $descr['domain'] = $currentDomain;

                $title = self::buildTitle($descr, $activePage);

                if (is_array($descr) && count($descr) && isset($descr['children']) && count($descr['children'])) {

                    $pages[] = array(
                        'structure_id' => $descr['structure_id'],
                        'id' => $descr['id'],
                        'text' => $title,
                        'expanded' => $expanded,
                        'children' => self::build($currentDomain, $descr['children'], $activePage),
                    );
                } else {

                    $pages[] = array('text' => $title,);
                }
                if ($expanded) {
                    $expanded = false;
                }
            }
        }

        return $pages;
    }
        
    /**
     * Строим домены
     * @return array
     */
    protected static function buildDomainPage($domain)
    {
        $page = new Page();
        $page->attributes = [
            'structure_id' => self::buildNewPageStructureId(), //строим "следующий" не занятый структурный айди
            'template_id' => $domain['template_id'],
            'alias' => 'index',
            'in_search' => 1,
            'title' => 'Главная - ' . $domain['alias'],
            'domain_id' => $domain['id'],
        ];
        $page->save();

        $data = $page->attributes;

        $query = new Query;
        $langs = $query->select('*')
            ->from('structure_page_lang')
            ->where(['owner_id' => $page->id])
            ->all();

        foreach ($langs as $item) {
            foreach (Page::getI18nAttributes() as $attribute) {
                $data['langs'][$item['lang']][$attribute] = $item[$attribute];
            }
        }

        return $data;
    }
    
    /*
     * @return Domain|null
     */
    public static function resolveDomain(): ?Domain
    {
        $host = request()->getHttpHost();
        
        return (new DomainFetchService)->byAlias($host);
    }
    
    /**
     * Определяем язык
     * @param Domain $domain
     * @param string $url
     * @return string -- урл без языкового параметра
     */
    public function resolveLanguage(Domain $domain, string $url): string
    {
        //разбиваем урл на элеметы
        $uriParts = explode('/', trim($url, '/'));
        //забираем языковый параметр, который всегда первый и устанавливаем язык пользователя
        
        if (in_array($uriParts[0], $domain->site_langs)) {
            app()->setLocale(array_shift($uriParts));
        } else {
            app()->setLocale($domain->site_lang);
        }

        //опять собираем урл
        return trim(implode('/', $uriParts), '/');
    }
    
    /**
     * Вернуть параметры затребованной пейджи
     * @param string $uri -- путь к странице
     * @return Page|null
     */
    public static function fetchPage(Domain $domain, string $uri): ?Page
    {
        $urls = self::buildUrls($domain);
        $uriPath = [];

        //разбиваем ури на элементы и проверяем каждый на существование в списке пейджей
        $parts = explode('/', ltrim($uri));
        foreach ($parts as $part) {

            //создаем цепочку пейджей
            $uriPath[] = $part;
          
            //если пейджи с указанной цепочкой не существует - прерываемся
            if (!isset($urls[implode(self::PATH_DELIMITER, $uriPath)])) {
                return null;
            }
        }

        $pageData = null;
        if (!empty($urls) && isset($urls[implode(self::PATH_DELIMITER, $uriPath)])) {

            //получаем параметры страницы по затребованному урлу
            $pageData = &$urls[implode(self::PATH_DELIMITER, $uriPath)];
        }
        
        return isset($pageData['id']) ? self::getPageById($pageData['id']) : null;        
    }
    
    /**
     * Поиск подходящих параметров в настройках алиасов
     * 
     * @param string $url -- запрашиваемый путь
     * @return array - данные для работы
     */
    public function aliasesUrlParser(string $url): ?array
    {
        $results = null;
        
        foreach (ScmsHelper::getFrontRoutes() as $rule) {

            //если находим правило для преобразования - то инициализируем переменные и определяем путь к странице
            if (preg_match($rule['key'], $url, $match)) {

                $replacements = [];
                $index = 1;
                foreach (explode(',', preg_replace('/\s+/', '', $rule['vars'])) as $key) {
                    $replacements[sprintf('/\{%s\}/', $key)] = $match[$index];
                    $index++;
                }

                $results['path'] = preg_replace(array_keys($replacements), $replacements, $rule['path']);
                if (isset($rule['vars'])) {
                    $results['vars'] = self::initializeVariables($url, $match, $rule['vars']);
                }
        
                break;
            }
        }
        
        return $results;
    }
    
    /*
     * @param string $uri
     * @throw Exception
     */
    public function renderPage(string $uri)
    {
        $domain = $this->resolveDomain();
        $uri = trim($uri, '/');
        //определяем текущий язык
        $uri = $this->resolveLanguage($domain, $uri);
        
        $uriToFetch = empty($uri) ? 'index' : 'index/' . $uri;
        
        $page = $this->fetchPage($domain, $uriToFetch);
        
        $aliasResult = null;
        if ($page === null) {
            $aliasResult = $this->aliasesUrlParser($uri);
            if ($aliasResult !== null) {
                $page = $this->fetchPage($domain, 'index/' . $aliasResult['path']);
            }
        }

        if ($page === null) {
            $page = $this->fetchPage($domain, 'index/404');
        }
        
        if ($page !== null) {
            FrontPage::setDomain($domain)
                ->setPage($page);
                        
            if (!empty($aliasResult['vars'])) {
                FrontPage::setVars($aliasResult['vars']);
            }

            $widgets = [];
            foreach ((new BlockFetchService)->itemsByPage($page->id) as $block) {
                $widgets[$block->alias] = unserialize($block->content)->run($block->alias);
            }
            
            // replacing area widgets
            $content = (string)view('templates.' . self::getTemplateAttrById($page->template_id, 'alias'));
            foreach ($widgets as $w_alias => $w_content) {
                $content = str_replace(
                    sprintf(self::EMBED_TEMPLATE, $w_alias), 
                    $w_content, 
                    $content
                );
            }
            //replacing empty area
            $content = preg_replace('/<!--@(.+?)-->/', '', $content);
            
            return view('layouts.' . self::getTemplateAttrById($page->template_id, 'layout'), compact('content'));
        } else {    
            throw new \Exception('404 page not foud');
        }
    }
    
    /*
     * @param Page $page
     * @return array
     */
    public function getPageBlocksData(Page $page): array
    {
        $data = [];
        foreach ((new BlockFetchService)->itemsByPage($page->id) as $block) {
            $blockModel = unserialize($block->content);
            
            $data[$block->alias] = [
                'widget_id' => $blockModel->widget_id,
                'action' => $blockModel->action,
            ];
        }
        return $data;
    }
	
    /**
     * @param string $attr
     * @return string|null
     */
	public static function getTemplateAttrById(int $id, string $attr): ?string
	{
		$data = Arr::pluck(self::TEMPLATES, $attr, 'id');
		return !empty($data[$id]) ? $data[$id] : null;
	}
	
    
    /**
     * Инициализируем переменные
     * @param string $url
     * @param array $match
     * @param string $vars
     * @return array
     */
    public static function initializeVariables(string $url, array $match, string $vars): array
    {
        $result = [];
        unset($match[0]);

        foreach (explode(',', $vars) as $pos => $varName) {
            $pos++;

            $parts = explode(':', $varName);
            $varName = array_shift($parts);
            $defPos = 0;
            if (count($parts)) {
                $defPos = array_shift($parts);
            }

            if ($defPos) {
                $pos = $defPos;
            }

            $result[trim($varName)] = !empty($match[$pos]) ? urldecode($match[$pos]) : null;
        }
        
        return $result;
    }
 
    /**
     * Строим вектор урлов в качестве ключей и сетапов страниц, в качестве значений
     * 
     * @param Domain $domain
     * @return array -- вектор урлов/настроек страниц
     */
    public static function buildUrls(Domain $domain): array
    {
        //вектор с картой урлов сайта
        $urlsMap = [];

        $pages = self::getDomainPages($domain)->sortBy('structure_id');
        
        //работаем, если имеются страницы
        if (!empty($pages)) {
     
            $depth = 0;

            $previousIdLenth = 6;

            $uri = [];
            $uriId = [];

            $breadcrumbs = [];

            foreach ($pages as $page) {
                
                if ($previousIdLenth == strlen($page->structure_id)) {

                    $depth = $depth > 0 ? $depth - 1 : 0;
                } else if (strlen($page->structure_id) < $previousIdLenth) {

                    for ($a = 0, $b = ($previousIdLenth - strlen($page->structure_id)) / 6; $a <= $b; $a ++) {
                        unset($uri[$depth --]);
                    }
                }

                //запоминаем ширину структурного айди страницы
                $previousIdLenth = strlen($page->structure_id);

                $uri[$depth ++] = $page->alias;
                $uriId[$page['alias']] = $page->structure_id;

                $urlsMap[implode(self::PATH_DELIMITER, $uri)] = [
                    'id' => $page['id'],
                    'structure_id' => $page['structure_id'],
                ];
            }
        }

        return $urlsMap;
    }
    
    /*
     * @param string $structureId
     * @return Domain|null
     */
    protected static function getDomainByStructure(string $structureId): ?Domain
    {
        //$root_id = substr($structureId, 0, self::ID_PART_LEN);
        $root = self::getPageByStructureId($structureId);
        if ($root != null) {
            return Domain::getAliasById($root->domain_id);
        } 
        
        return null;
    }

    /*
     * @return Collection
     */
    public static function getAllPages(): Collection
    {
        return (new PageFetchService)->all();
    }
    
    /*
     * @param Domain $domain
     * @return Collection
     */
    public static function getDomainPages(Domain $domain): Collection
    {        
        return self::getAllPages()->reject(function ($item) use ($domain) {
            return $item->domain_id !== $domain->id;
        });
    }
    
    /*
     * @param Domain $domain
     * @param Page $page
     */
    public static function getBreadcrumbs(Domain $domain, Page $page)
    {
        // search page path
        $pagaData = Arr::where(self::buildUrls($domain), function ($value, $key) use ($page) {
            return $value['id'] == $page->id;
        });
        $path = array_keys($pagaData)[0];
        
        $breadcrumbs = [];

        $paths = explode(self::PATH_DELIMITER, $path);
        $size = strlen($page->structure_id);
        $k = 0;
        for ($i = self::ID_PART_LEN; $i < $size + 1;) {
            $structure_id = substr($page->structure_id, 0, $i);
            $i = $i + self::ID_PART_LEN;

            $url = '';
            for ($j = 0; $j <= $k; $j++) {
                $url .= '/' . $paths[$j];
            }

            $url = d_l(str_replace('index', app()->getLocale(), $url));

            $pageBread = self::getPageByStructureId($structure_id);
            if ($pageBread->is_breadcrumbs) {
                $urlParts = explode('/', $url);
                $breadcrumbs[end($urlParts)] = [ 
                    'title' => !empty($pageBread->breacrumbs_title) ? 
                        $pageBread->breacrumbs_title : $pageBread->seo_title,
                    'url' => $url,
                ];
                $k++;
            }
        }
		
	   return $breadcrumbs;
    }
    
    /*
     * @param Domain $domain
     * @param  int $pageId
     * @return  string
     */
    public function getPageUrlById(Domain $domain, int $pageId): string
    {
        $pages = self::getAllPages();
        $structureAlias = Arr::pluck($pages, 'alias', 'structure_id');
        
        $structure_id = self::getPageById($pageId)->structure_id;

        $items = str_split($structure_id, self::ID_PART_LEN);

        $string = '';
        $s_ids = [];
        foreach ($items as $item) {
            $string.= $item;
            $s_ids[] = $string;
        }

        $paths = [];
        foreach ($s_ids as $s_id) {
            if (isset($structureAlias[$s_id])) {
                $paths[] = $structureAlias[$s_id];
            }
        }

        $link = '';
        unset($paths[0]);
        if (!empty($paths)) {
            $link = '/' . implode('/', $paths) . '/';
        } else {
            $link = '/';
        }

        return d_l($link);
    }    
}
