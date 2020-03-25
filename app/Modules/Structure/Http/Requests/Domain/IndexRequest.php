<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Domain;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\Structure\Models\Domain;

/**
 * Class IndexRequest
 * 
 * @package App\Modules\Structure
 *
 * @bodyParam page             integer  optional page
 * @bodyParam per_page         integer  optional per page
 * @bodyParam sort_dir         string   optional sorting dir
 * @bodyParam sort_attr        string   optional sorting attribute
 * @bodyParam id               integer  optional id
 * @bodyParam alias            string   optional Alias.
 * @bodyParam is_active        integer  optional Active. Value: 0, 1
 * @bodyParam site_lang        string   optional Domain default language
 * @bodyParam copyright        string   optional Domain copyright
 */
class IndexRequest extends BaseIndexRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.domain.index');
    }

    /*
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'id',
                    'is_active',
                    'alias',
                    'site_lang',
                    'copyright',
                ]),
            ],
            'id' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'is_active' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'alias' => [
                'nullable',
                'string',
            ],
            'copyright' => [
                'nullable',
                'string',
            ],
            'site_lang' => [
                'nullable',
                'string',
            ],
        ];
        
        return $rules;
    }
        
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Structure', 'Domain') + parent::attributes();
    }
    
    /*
     * @return Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = Domain::select([
                'structure_domains.*',
                'structure_domains_lang.copyright AS copyright',
            ])
            ->leftJoin('structure_domains_lang', 'structure_domains_lang.domain_id', 'structure_domains.id')
            ->where('structure_domains_lang.locale', app()->getLocale());
        
        if ($this->id !== null) {
            $query->where('id', 'like', "%{$this->id}%");
        }
        if ($this->alias !== null) {
            $query->where('alias', 'like', "%{$this->alias}%");
        }
        if ($this->is_active !== null) {
            $query->where('is_active', $this->is_active);
        }
        if ($this->site_lang !== null) {
            $query->where('site_lang', $this->site_lang);
        }
        if ($this->copyright !== null) {
            $query->where('copyright', $this->copyright);
        }
         
        return $query;
    }

    public function paginate()
    {
        $query = $this->getQueryBuilder();

        $sortDir = $this->attr('sort_dir');
        $sortAttr = $this->attr('sort_attr');
        if ($sortDir && $sortAttr) {
            $query->orderBy($sortAttr, $sortDir);
        }

        $perPage = $this->attr('per_page', self::PER_PAGE);
        $page = $this->attr('page', self::PAGE);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}