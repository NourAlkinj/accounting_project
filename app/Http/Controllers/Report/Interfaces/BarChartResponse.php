<?php
namespace App\Http\Controllers\Report\Interfaces;

interface BarChartResponse
{
  public function getXAxis(): array;
  public function getYAxis(): array;
  public function getSeries(): array;
}
