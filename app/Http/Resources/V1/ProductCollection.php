<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public $collects = ProductResource::class;
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => 'metadata',
        ];
    }
}
