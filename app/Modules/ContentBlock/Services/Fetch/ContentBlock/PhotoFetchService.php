<?php 

namespace App\Modules\ContentBlock\Services\Fetch\ContentBlock;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\ContentBlock\Models\ContentBlock\Photo;

/**
 * Class PhotoFetchService
 */
class PhotoFetchService
{    


    /**
     * @param  ContentBlock $contentBlock
     * @return  Collection
     */
    public static function getData(ContentBlock $contentBlock): Collection
    {
        return $contentBlock->photos()->orderBy('rank')->get();
    } 
    
    /**
     * @param  ContentBlock $contentBlock
     * @return  int
     */
    public static function getDefaultRank(ContentBlock $contentBlock): int
    {
        return (int) Photo::where('content_block_id', $contentBlock->id)->max('rank') + 1;
    }   
    
}


