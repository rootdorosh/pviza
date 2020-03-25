<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Models\Lang;

use Illuminate\Database\Eloquent\Model;

class VacancyLang extends Model
{
    /**
     * primary key.
     *
     * @var  string
     */
    protected $primaryKey = 'translation_id';
       
    /**
     * table name.
     *
     * @var  string
     */
    protected $table = 'vacancy_lang';

    /**
     * @var  bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'title',
        'alias',
        'salary',
        'work_schedule',
        'contract_type',
        'description',
        'seo_h1',
        'seo_title',
        'seo_description', 
    ];
}
