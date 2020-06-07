<?php 

declare( strict_types = 1 );

namespace App\Modules\Review\Services\Crud;

use App\Modules\Review\Models\Review;

/**
 * Class ReviewCrudService
 */
class ReviewCrudService
{

    /*
     *      
     * @param    array $data
     * @return  Review
     */
    public function store(array $data): Review
    {         $review = Review::create($data);
                
        return $review;
	}

    /*
     *      
     * @param    Review $review
     * @param    Review $data
     * @return  Review
     */
    public function update(Review $review, array $data): Review
    {         $review->update($data);
                
        return $review;
    }

    /*
     * @param    Review $review
     * @return  void
     */
    public function destroy(Review $review): void
    {
        $review->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Review::destroy($ids);
    }    
  

    
}