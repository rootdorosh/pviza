<?php

namespace App\Modules\Structure\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Structure\Services\StructureService;
use App\Modules\Structure\Services\Crud\BlockCrudService;
use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\Structure\Models\{
    Domain,
    Page
};
use App\Base\ExtArrHelper;
use Setting;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            'contact_footer'
        ] as $name) {
            $this->makeContentBlock($name);
        }
        
        $structureService = new StructureService;
        
        $domainData = factory(Domain::class)->make([
            'alias' => config('app.domain'),
            'is_active' => 1,
        ]);
        
        $domain = Domain::updateOrCreate(
            ['alias' => config('app.domain')], 
            ExtArrHelper::keyToItems($domainData->toArray(), 'translations', 'locale')
        );
        //index
        $indexPage = $structureService->makeDomainRootPage($domain);
        $this->attachBlock($indexPage, 'content1', [
            'widget_id' => 'Vacancy',
            'action' => 'homeSearchForm',
        ]);
        
        //jobs
        $jobsPage = $structureService->makePage(
            $indexPage, 
            ['alias' => 'jobs', 'seo_h1' => 'Jobs', 'seo_title' => 'Jobs',]
        );
        $this->attachContentBlockBackImage($jobsPage, 'content1', ['title' => 'Вакансії']);
        $this->attachBlock($jobsPage, 'content2', [
            'widget_id' => 'Vacancy',
            'action' => 'index',
        ]);
        $this->attachContentBlockFooterSeoText($jobsPage, 'content3', [
            'name' => 'jobs_foter_seo_text', 
            'title' => 'Вакансії', 
            'body' => '<p>Seo text example ... </p>',
        ]);
        
        // job location
        $jobLocationPage = $structureService->makePage(
            $jobsPage, 
            ['alias' => 'location', 'seo_title' => 'Location',]
        );
        $this->attachBlock($jobLocationPage, 'content1', [
            'widget_id' => 'Vacancy',
            'action' => 'location',
        ]); 
        
        // job category
        $jobCategoryPage = $structureService->makePage(
            $jobsPage, 
            ['alias' => 'category', 'seo_title' => 'Category',]
        );
        $this->attachBlock($jobCategoryPage, 'content1', [
            'widget_id' => 'Vacancy',
            'action' => 'category',
        ]); 
        
        // job type
        $jobTypePage = $structureService->makePage(
            $jobsPage, 
            ['alias' => 'type', 'seo_title' => 'Type',]
        );
        $this->attachBlock($jobTypePage, 'content1', [
            'widget_id' => 'Vacancy',
            'action' => 'type',
        ]);       
        
        // vacancy
        $vacancyPage = $structureService->makePage(
            $jobsPage, 
            ['alias' => 'vacancy', 'seo_title' => 'Vacancy',]
        );
        $this->attachBlock($vacancyPage, 'content1', [
            'widget_id' => 'Vacancy',
            'action' => 'view',
        ]);        
    }
        
    /*
     * @param string array $params
     * @return void
     */
	public function makeContentBlockBackImage(array $params)
    {
		$attrs = factory(ContentBlock::class)->make([
			'name' => $params['title'],
			'is_active' => 1,
			'is_hide_editor' => 0,            
        ])->getAttributes();
        
		foreach (config('translatable.locales') as $locale) {
			$attrs[$locale]	= [
				'title' => $params['title'],
				'body' => $params['title'],
			];
		}
		
        return resolve('App\Modules\ContentBlock\Services\Crud\ContentBlockCrudService')->store($attrs);
    }    
        
    /*
     * @param string array $params
     * @return void
     */
	public function makeContentBlockFooterSeoText(array $params)
    {
		$attrs = factory(ContentBlock::class)->make([
			'name' => $params['name'],
			'is_active' => 1,
			'is_hide_editor' => 0,            
        ])->getAttributes();
        
		foreach (config('translatable.locales') as $locale) {
			$attrs[$locale]	= [
				'title' => $params['title'],
				'body' => $params['body'],
			];
		}
		
        return resolve('App\Modules\ContentBlock\Services\Crud\ContentBlockCrudService')->store($attrs);
    }    
        
    /*
     * @param Page $page
     * @param string $alias
     * @param array $params
     * @return void
     */
	public function attachContentBlockBackImage(Page $page, string $alias, array $params)
    {
        if (!$this->hasBlock($page, $alias)) {
            $contentBlock = $this->makeContentBlockBackImage($params);
            
            (new BlockCrudService)->insert($page, [
                'widget_id' => 'ContentBlock',
                'alias' => $alias,
                'action' => 'index',
                'template' => 'background_image_title',
                'block_id' => $contentBlock->id,
            ]);
        }        
    }    
        
    /*
     * @param Page $page
     * @param string $alias
     * @param array $params
     * @return void
     */
	public function attachContentBlockFooterSeoText(Page $page, string $alias, array $params)
    {
        if (!$this->hasBlock($page, $alias)) {
            $contentBlock = $this->makeContentBlockFooterSeoText($params);
            
            (new BlockCrudService)->insert($page, [
                'widget_id' => 'ContentBlock',
                'alias' => $alias,
                'action' => 'index',
                'template' => 'footer_seo_text',
                'block_id' => $contentBlock->id,
            ]);
        }        
    }    
        
    /*
     * @param Page $page
     * @return string $alias
     * @return array $blockData
     * @return void
     */
	public function attachBlock(Page $page, string $alias, array $blockData)
    {
        if (!$this->hasBlock($page, $alias)) {
            $blockData['alias'] = $alias;
            (new BlockCrudService)->insert($page, $blockData);
        }        
    }    
        
    /*
     * @param Page $page
     * @return string $alias
     * @return bool
     */
	public function hasBlock(Page $page, string $alias): bool
    {
        return in_array($alias, $page->blocks()->pluck('alias')->toArray()) ? true : false;
    }    
        
    /*
     * @param string $name
     * @return ContentBlock
     */
	public function makeContentBlock($name): ContentBlock
	{
		$model = ContentBlock::where('name', $name)->first();
		if ($model !== null) {
			return $model;
		}
		
		$body = file_get_contents(resource_path() . '/content_blocks/' . $name . '.html');
		$attrs = [
			'name' => $name,
			'is_active' => 1,
			'is_hide_editor' => 1,
		];
		foreach (config('translatable.locales') as $locale) {
			$attrs[$locale]	= [
				'title' => $name,
				'body' => $body,
			];
		}
		
        return resolve('App\Modules\ContentBlock\Services\Crud\ContentBlockCrudService')->store($attrs);
	}
    
    /*
     * @param Page $page
     * @param string $alias
     * @param string $blockName
     * @param string $template
     * @return void
     */
	public function attachContentBlock(Page $page, string $alias, string $blockName, string $template = 'empty')
    {
        if (!$this->hasBlock($page, $alias)) {
            $contentBlock = $this->makeContentBlock($blockName);
            
            (new BlockCrudService)->insert($page, [
                'widget_id' => 'ContentBlock',
                'alias' => $alias,
                'action' => 'index',
                'template' => $template,
                'block_id' => $contentBlock->id,
            ]);
        }        
    }    
    

    /*
     * @param string $name
     * @return ContentBlock
     */
	public function getModel($name): Model
	{
		$model = $name::where('is_active', 1)->inRandomOrder()->first();
		if ($model !== null) {
			return $model;
		}
		
        return factory($name)->create();
	}
}
