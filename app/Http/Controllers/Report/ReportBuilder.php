<?php

namespace App\Http\Controllers\Report;

class ReportBuilder {


    public $eachFilterResult = [];
    public $result = [];

    public function __construct(public object $FiltersClass, public array $starting_value, public array $filters) {
        for ($i=0; $i < sizeof($filters); $i++) {

            // dd($filter = $filters[$i]['name']);
            if($filters[$i]) {
                $filter = $filters[$i]['name'];
    
                // Run The First Function Without previous function result
                //.. Then Pass each function result to the next.
                if($i == 0) {
                    $this->result = $FiltersClass->$filter($starting_value);
                }
                else if($filters[$i]['affects_final_result']) {
                    $this->result = $FiltersClass->$filter($this->result);
                }
                $this->eachFilterResult[$filter] =  $FiltersClass->$filter($this->result);
            }
        }

    }
}
