<?php

namespace App\Modules\Log\Transformers;

use App\Modules\Log\Models\Log;
use App\Base\AbstractTransformer;

/**
 * Class LogTransformer.
 */
class LogTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param Log $event
     * @return array
     */
    public function transform(Log $log) : array
    {
        return [
            'id' => $log->id,
            'logable_id' => $log->logable_id,
            'logable_type' => $log->logable_type,
            'action' => $log->action,
            'user_id' => $log->user_id,
            'properties' => $log->properties,
            'created_at' => $log->created_at,
        ];
    }   
}