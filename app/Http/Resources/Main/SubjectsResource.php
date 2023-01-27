<?php

namespace App\Http\Resources\Main;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectsResource extends JsonResource
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
            'Course' => $this->course->name,
            'Name' => $this->name,
            'Type' => $this->type,
            'Subject type' => $this->subject_type,
            'Students limit' => $this->students_limit,

        ];
    }
}
