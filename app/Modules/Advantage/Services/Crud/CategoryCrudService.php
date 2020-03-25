<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Services\Crud;

use App\Modules\Advantage\Models\Category;

/**
 * Class CategoryCrudService
 */
class CategoryCrudService
{

    /*
     * @param    array $data
     * @return  Category
     */
    public function store(array $data): Category
    {        $category = Category::create($data);
        
        return $category;
    }

    /*
     * @param    Advantage $category
     * @param    Category $data
     * @return  Category
     */
    public function update(Category $category, array $data): Category
    {        $category->update($data);
        
        return $category;
    }

    /*
     * @param    Category $category
     * @return  void
     */
    public function destroy(Category $category): void
    {
        $category->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Category::destroy($ids);
    }    
    
    
}
