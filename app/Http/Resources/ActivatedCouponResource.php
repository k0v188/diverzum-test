<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivatedCouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'company_name' => $this->company_name,
            'name' => $this->name,
            'discount' => $this->discount,
            'created_at' => Carbon::parse($this->created_at->timezone('Europe/Budapest'))->format('Y-m-d H:i')
        ];
    }
}
