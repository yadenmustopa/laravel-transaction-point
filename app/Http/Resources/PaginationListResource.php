<?php
namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


/**
 * Summary of PaginationListResource
 * @author Yaden Mustopa
 * @copyright (c) 2023
 */
class PaginationListResource extends ResourceCollection
{

    protected $collections;


    /**
     * setItemCollections
     * source : https://stackoverflow.com/questions/50638257/laravel-5-6-pass-additional-parameters-to-api-resource
     *
     * @param  JsonResource $collectionItemsClass
     * @param   \Illuminate\Http\Request $request
     * @return void
     */
    public function setResourceItem($collectionItemsClass, $request = Request::class)
    {
        $this->collections = $collectionItemsClass;
        return $this->toArray($request);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'per_page'          => $this->perPage(),
            'total'             => $this->total(),
            'current_page'      => $this->currentPage(),
            'last_page'         => $this->lastPage(),
            'last_page_url'     => $this->url($this->lastPage()),
            'next_page_url'     => $this->nextPageUrl(),
            'previous_page_url' => $this->previousPageUrl(),
            'first_page_url'    => $this->url(1),
            'from'              => $this->firstItem(),
            'to'                => $this->lastItem(),
            'path'              => $this->resource->toArray()['path'],
            'items'             => $this->collections::collection($this->items())
        ];
    }
}