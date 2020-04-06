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
        Domain::where('alias', config('app.domain'));
        
        $domainData = factory(Domain::class)->make([
            'alias' => config('app.domain'),
            'is_active' => 1,
        ]);
        
        $domain = Domain::updateOrCreate(
            ['alias' => config('app.domain')], 
            ExtArrHelper::keyToItems($domainData->toArray(), 'translations', 'locale')
        );
        
        // index
        $indexPage = $structureService->makeDomainRootPage($domain);
        
        /*
        $this->attachContentBlock($indexPage, 'content1', 'promo');
        $this->attachBlock($indexPage, 'content2', [
            'widget_id' => 'Advantage',
            'action' => 'index',
            'template' => 'with_icons',
            'category_id' => $this->getModel('App\Modules\Advantage\Models\Category')->id,
        ]);
        $this->attachBlock($indexPage, 'content3', [
            'widget_id' => 'Advantage',
            'action' => 'index',
            'template' => 'bulleted_list',
            'category_id' => $this->getModel('App\Modules\Advantage\Models\Category')->id,
        ]);
        */
        
        //contact
        $contactPage = $structureService->makePage(
            $indexPage, 
            ExtArrHelper::keyToItems(factory(Page::class)->make(['alias' => 'contact'])->toArray(), 'translations', 'locale')
        );        
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
