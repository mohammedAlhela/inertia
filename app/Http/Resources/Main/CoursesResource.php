<?php

namespace App\Http\Resources\Main;

use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
{

    public function __construct($resource)
    {
        // Ensure we call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource; // $apple param passed
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [

            'Addmission' => $this->id,
            'Department' => $this->department->name,
            'Name' => $this->name,
            'Students limit' => $this->students_limit,
            'Evaluation type' => $this->evaluation_type,
            'Subjects' =>  implode(" ,",$this->subjects->pluck('name')->toArray())
        ];
    }
}
