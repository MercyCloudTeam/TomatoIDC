<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'status'=>200,
            'data' => [
                'id' => $this->id,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'level' => $this->level,
                'content' => $this->content,
                'status' => $this->status,
            ]
        ];
    }
}
