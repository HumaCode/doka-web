<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    protected $resourceClass;

    public function __construct($resource, $resourceClass = null)
    {
        parent::__construct($resource);
        $this->resourceClass = $resourceClass;
    }

    public static function make(...$parameters)
    {
        return new self(...$parameters);
    }

    public function toArray(Request $request): array
    {
        // AMBIL COLLECTION DARI PAGINATOR
        $collection = $this->getCollection();

        return [
            'data' => $this->resourceClass
                ? $this->resourceClass::collection($collection)
                : $collection,

            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
        ];
    }
}
