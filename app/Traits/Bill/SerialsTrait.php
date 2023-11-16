<?php
namespace App\Traits\Bill;
use App\Models\Serial;
use App\Models\SerialNumberBillRecord;


trait SerialsTrait {

    public function saveSerialState($bill, $record): void {
        if(!array_key_exists('serials', $record)) return;

        foreach ($record['serials'] as $serialData) {
            $serialData['item_id'] = $record['item_id'];
            $serial = Serial::create($serialData);

            if ($bill['storing_type'] == 'OUT') {
            SerialNumberBillRecord::create([
                'serial_id' => $serial['id'],
                'bill_record_id' => $record['id'],
                'bill_id' => $bill['id'],
                'item_Id' => $record['item_id'],
                'is_input' => false,
                'is_output' => true,
                'input_date' => null,
                'output_date' => $bill['date']
            ]);
            }
            if ($bill->storing_type == 'IN') {
            SerialNumberBillRecord::create([
                'serial_id' => $serial['id'],
                'bill_record_id' => $record['id'],
                'bill_id' => $bill['id'],
                'item_Id' => $record['item_id'],
                'is_input' => true,
                'is_output' => false,
                'input_date' => $bill['date'],
                'output_date' => null
            ]);
            }
        }
    }

}
