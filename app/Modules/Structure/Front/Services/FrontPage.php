<?php
declare(strict_types=1);

namespace App\Modules\Structure\Front\Services;

use App\Modules\Structure\Models\{
    Domain,
    Page
};
use App\Modules\Structure\Services\StructureService;

class FrontPage
{
    /*
     * @var Domain
     */
    private $domain;

    /*
     * @var Page
     */
    private $page;

    /*
     * @var string
     */
    private $title;
    
    /*
     * @var string
     */
    private $h1;
        
    /*
     * @var string
     */
    private $description;
    
    /*
     * @var array
     */
    private $vars;
    
    /*
     * @var array
     */
    private $breadcrumbsParams = [];
    
    /*
     * @return self
     */
    public function getInstance(): self
    {
        return $this;
    }

    /*
     * @param Domain $domain
     * @return self
     */
    public function setDomain(Domain $domain): self
    {
        $this->domain = $domain;        
        return $this;
    }
    
    /*
     * @return Domain|null
     */
    public function getDomain(): ?Domain
    {
        return $this->domain;
    }
    
    /*
     * @param Page $page
     * @return self
     */
    public function setPage(Page $page): self
    {
        $this->page = $page;
        return $this;
    }
    
    /*
     * @return Page|null
     */
    public function getPage(): ?Page
    {
        return $this->page;
    }

    /*
     * @return bool
     */
    public function hasPage(): bool
    {
        return !empty($this->page);
    }
    
    /*
     * @param array $vars
     * @return self
     */
    public function setVars(array $vars): self
    {
        $this->vars = $vars;
        return $this;
    }
    
    /*
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return !empty($this->title) ? $this->title : $this->page->seo_title;
    }
    
    /*
     * @param string $value
     * @return self
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;
        return $this;
    }
    
    /*
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return !empty($this->description) ? $this->description : $this->page->seo_description;
    }
    
    /*
     * @param string $value
     * @return self
     */
    public function setDescription(string $value): self
    {
        $this->description = $value;
        return $this;
    }
    

    /*
     * @return string|null
     */
    public function getH1(): ?string
    {
        return !empty($this->h1) ? $this->h1 : $this->page->seo_h1;
    }

    /*
     * @return string|null
     */
    public function getBodyClass(): ?string
    {
        return $this->page->body_class;
    }

    /*
     * @return string|null
     */
    public function getLayout(): ?string
    {        
        return 'layouts.' . StructureService::TEMPLATES[$this->page->template_id]['layout'];
    }

    /*
     * @param string $name
     * @return mixed
     */
    public function getVar(string $name)
    {
        return isset($this->vars[$name]) ? $this->vars[$name] : null;
    }
    
    /*
     * @param array $params
     * @return self
     */
    public function setBreadcrumbs(array$params): self
    {
        $this->breadcrumbsParams = $params;
        return $this;
    }
    
    /*
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        $items = StructureService::getBreadcrumbs($this->getDomain(), $this->getPage());
        
        foreach ($this->breadcrumbsParams as $k => $v) {
            $items[$k] = $v;
        }
        
        return $items;
    }
}