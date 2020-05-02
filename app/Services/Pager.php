<?php
declare( strict_types = 1 );

namespace App\Services;

use Illuminate\Support\Str;
use FrontPage;

/**
 * Class Pager
 * @package App\Service
 */
class Pager 
{
    public $add_get_params = '';
    public $id_update = 'list_update';
    public $page = null;
    public $count = 0;
    public $limit = 10;
    
    /*
     * 
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }
    
	public function run()
    {
		$countPage = (int) ($this->count / $this->limit);
		if ($this->count % $this->limit != 0)
		{
			$countPage++;
		}    
		
        if (isset($_GET['t'])) {
            dump($this->count);
            dump($this->limit);
            dd($countPage);
        }
        
		$html = '';

		$activePage = $this->getPage();		
		
		if ($countPage > 1 && $activePage <= $countPage)
		{
			$html .= '<div class="pagination">';
				
				$startPage = ($activePage > 2)?$activePage - 2:1;
				$endPage = $startPage + 4;
				if ($endPage - $countPage > 0) {$startPage = $startPage - ($endPage - $countPage);}
	
				if ($activePage > 1)
				{				
					$html .= $this->createButton('page-item-control', 'pagination__arrow-first', 1, '<<');
					$html .= $this->createButton('page-item-control', '', $activePage-1, '<');
				} else {
					$html .= $this->createButton('page-item-control disabled', 'pagination__arrow-first', 1, '<<');
					$html .= $this->createButton('page-item-control disabled', '', $activePage-1, '<');					
				}
				
				for($i=1; $i<=$countPage; $i++)
				{
					if (($i >= $startPage && $i <= $endPage) || $activePage==$i)
					{
						$li_class = '';
						$a_class = '';
                        if ($i == $activePage) {
                            $html .= $this->createButton($li_class, $a_class, $i, $i, false);
                        } else {
                            $html .= $this->createButton($li_class, $a_class, $i, $i);
                        }
					}
				}
												
				if ($activePage < $countPage)
				{
					$html .= $this->createButton('page-item-control', 'pagination__btn', $activePage+1, '>');
					$html .= $this->createButton('page-item-control', 'pagination__btn', $countPage, '>>');
				} else {
					$html .= $this->createButton('page-item-control', 'pagination__btn', $activePage+1, '>');
					$html .= $this->createButton('page-item-control', 'pagination__btn', $countPage, '>>');					
				}
				
			$html .=  '</div>';
		}
		
		return $html;
    }	
	
	function createButton($li_class, $link_class, $page, $label, $is_url=true)
	{
        $url = '/' . ltrim(request()->path(), '/');
        $activePage = $this->getPage();
		$expl = explode('page-', $url);
		$url  = $expl[0] . '/page-' . $page . '/';
		$url  = str_replace('/page--1/', '/', $url);
		$url  = str_replace('/page-1/', '/', $url);
		$url  = str_replace('//', '/', $url);
	    
		$html = '';
		if ($is_url) {
			$html = '<div class="page-item"><a class="page-link" href="'. $url .'">' . $label . '</a></div>';				
		} else {
			$html = '<div class="page-item active"><span class="page-link">' . $label . '</span></div>';							
		}
		
		return $html;
	}
	
	private function getPage()
	{
		return is_null($this->page) ? FrontPage::getVar('page') : $this->page;
	}    
}
