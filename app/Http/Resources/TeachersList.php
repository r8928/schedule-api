<?php

namespace App\Http\Resources;

use App\Enums\ClassType;
use App\Enums\SubjectType;
use Illuminate\Http\Resources\Json\JsonResource;

class TeachersList extends JsonResource
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
            'name' => $this->name,
            'qualifications' => $this->qualifications,
            'classes' => implode(', ', $this->class->map(function ($item) {

                return ClassType::fromKey($item->class);
            })->toArray()),
            'subjects' => implode(', ', $this->subject->map(function ($item) {

                return SubjectType::fromKey($item->subject);
            })->toArray()),
        ];
    }
}
