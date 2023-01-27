<?php

namespace App\Http\Resources\Main;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentsResource extends JsonResource
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
            'Name' => $this->name,
            'Courses' =>  implode(" ,",$this->courses->pluck('name')->toArray()),
            'Subjects' =>  implode(" ,",$this->subjects->pluck('name')->toArray())
        ];
    }
}
