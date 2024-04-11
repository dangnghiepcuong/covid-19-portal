<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'business_id' => $this->business_id,
            'on_date' => $this->on_date,
            'vaccine_lot' => $this->vaccineLot,
            'day_shift_limit' => $this->day_shift_limit,
            'noon_shift_limit' => $this->noon_shift_limit,
            'night_shift_limit' => $this->night_shift_limit,
            'day_shift_registration' => $this->day_shift_registration,
            'noon_shift_registration' => $this->noon_shift_registration,
            'night_shift_registration' => $this->night_shift_registration,
            'day_shift' => $this->day_shift,
            'noon_shift' => $this->noon_shift,
            'night_shift' => $this->night_shift,
        ];
    }
}
