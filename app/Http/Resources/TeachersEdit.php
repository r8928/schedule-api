<?php

namespace App\Http\Resources;

use App\Enums\ClassType;
use App\Enums\SubjectType;
use Illuminate\Http\Resources\Json\JsonResource;

class TeachersEdit extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $classes = $this->class->pluck('class')->toArray();
        $subjects = $this->subject->pluck('subject')->toArray();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'qualifications' => $this->qualifications,
            'classes' => collect(ClassType::getKeys())->reduce(function ($carry, $item) use ($classes) {
                $carry[$item] = in_array($item, $classes);
                return $carry;
            }),
            'subjects' => collect(SubjectType::getKeys())->reduce(function ($carry, $item) use ($subjects) {
                $carry[$item] = in_array($item, $subjects);
                return $carry;
            }),
        ];
    }
}
