<?php

namespace App\Traits\Voucher;

use App\Http\Requests\VoucherRequest;
use App\Models\JournalEntry;
use App\Models\JournalEntryRecord;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherPermissionUser;
use App\Models\VoucherRecord;
use App\Models\VoucherTemplate;
use Illuminate\Http\Request;

trait  VoucherRecordTrait
{


    public function getVoucherRecords()
    {
        return Voucher::find(1)->records;
    }

//  public function saveVoucherRecords(VoucherRequest $request, $voucher_id)
//  {
//    $voucher = Voucher::find($voucher_id);
//    $voucher_Recordss = $voucher->records->toArray();
//    $records_in_request = $request->records;
//    $recordsToCreate = array_diff(array_column($records_in_request, 'id2'), array_column($voucher_Recordss, 'id2'));
//    foreach ($recordsToCreate as $record) {
//      $recordData = $request->records[array_search($record, array_column($request->records, 'id2'))];
//      VoucherRecord::create([
//        'account_id' => $recordData['account_id'],
//        'debit' => $recordData['debit'],
//        'index' => abs($recordData['index']),
//        'relative_debit' => $recordData['debit'],
//        'relative_credit' => $recordData['credit'],
//        'debit_total' => $recordData['debit_total'],
//        'credit_total' => $recordData['credit_total'],
//        'credit' => $recordData['credit'],
//        'notes' => $recordData['notes'],
//        'cost_center_id' => $recordData['cost_center_id'],
//        'currency_id' => $recordData['currency_id'],
//        'parity' => $recordData['parity'],
//        'equivalent' => $recordData['equivalent'],
//        'contra_account_id' => $recordData['contra_account_id'],
//        'current_balance' => $recordData['current_balance'],
//        'final_balance' => $recordData['final_balance'],
//        'id2' => $recordData['id'],
//        'voucher_id' => $voucher_id,
//      ]);
//    }
//    $recordsToDelete = array_diff(array_column($voucher_Recordss, 'id2'), array_column($records_in_request, 'id2'));
//    foreach ($recordsToDelete as $record) {
//      $record = VoucherRecord::where('voucher_id', $voucher_id)->where('id2', $record)->first();
//      $record->delete();
//    }
//    $recordsToUpdate = array_intersect(array_column($records_in_request, 'id2'), array_column($voucher_Recordss, 'id2'));
//    foreach ($recordsToUpdate as $record) {
//      $recordData = $request->records[array_search($record, array_column($request->records, 'id2'))];
//      $record = VoucherRecord::where('voucher_id', $voucher_id)->where('id2', $record)->first();
//      $record->update($request->all()
////          [
////        'account_id' => $recordData['account_id'],
////        'debit' => $recordData['debit'],
////        'index' => abs($recordData['index']),
////        'relative_debit' => $recordData['debit'],
////        'relative_credit' => $recordData['credit'],
////        'debit_total' => $recordData['debit_total'],
////        'credit_total' => $recordData['credit_total'],
////        'credit' => $recordData['credit'],
////        'notes' => $recordData['notes'],
////        'id2' => $recordData['id2'],
////        'cost_center_id' => $recordData['cost_center_id'],
////        'currency_id' => $recordData['currency_id'],
////        'parity' => $recordData['parity'],
////        'equivalent' => $recordData['equivalent'],
////        'contra_account_id' => $recordData['contra_account_id'],
////        'current_balance' => $recordData['current_balance'],
////        'final_balance' => $recordData['final_balance'],
////        'voucher_id' => $voucher_id,
////      ]
//      );
//    }
//  }
    public function saveVoucherRecords(VoucherRequest $request, $voucher_id)
    {
        $voucher = Voucher::find($voucher_id);
        $voucher_Recordss = $voucher->records->toArray();
        $records_in_request = $request->records;
        $recordsToCreate = array_diff(array_column($records_in_request, 'id'), array_column($voucher_Recordss, 'id'));
        foreach ($recordsToCreate as $record) {
            $recordData = $request->records[array_search($record, array_column($request->records, 'id'))];
            VoucherRecord::create($recordData);
        }
        $recordsToDelete = array_diff(array_column($voucher_Recordss, 'id'), array_column($records_in_request, 'id'));
        foreach ($recordsToDelete as $record) {
            $record = VoucherRecord::where('voucher_id', $voucher_id)->where('id', $record)->first();
            $record->delete();
        }
        $recordsToUpdate = array_intersect(array_column($records_in_request, 'id2'), array_column($voucher_Recordss, 'id2'));
        foreach ($recordsToUpdate as $record) {
            $recordData = $request->records[array_search($record, array_column($request->records, 'id2'))];
            $record = VoucherRecord::where('voucher_id', $voucher_id)->where('id2', $record)->first();
            $record->update($recordData);
        }
    }

    // Old

    public function saveVoucherRecord(VoucherRequest $request, $voucher_id)
    {
        $voucher_Records = Voucher::find($voucher_id)->records;
        foreach ($voucher_Records as $voucher_Record) {
            $voucher_Record->forceDelete();
        }
        $new_voucherRecords = $request->records;
        foreach ($new_voucherRecords as $voucherRecord) {
//      $voucherRecord['index'] = abs($voucherRecord['index']);
            $voucherRecord['voucher_id'] = $voucher_id;
            VoucherRecord::create($voucherRecord);
        }
    }


    public function VoucherRecordCostCenter($id)
    {
        $voucherRecords = Voucher::find($id)->records;
        foreach ($voucherRecords as $voucherRecord) {
            $records[] = $voucherRecord;
            foreach ($records as $record) {
                $costCeners[] = $record->CostCenter;
            }
        }
        return array_unique($costCeners);
    }


    public function userVoucherOptions($voucher_template_id)
    {

        $id = auth('sanctum')->user()->id;
        return VoucherPermissionUser::where('user_id', $id)->where('voucher_template_id', $voucher_template_id)->get();
    }


    public function setVoucherPermissionUser($voucher_template_id)
    {
        $show_setting = [
            [
                "columns" => [
                    [
                        "id" => 1,
                        "name" => "delete",
                        "field" => "delete",
                        "label" => "Delete",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ],
                    [
                        "id" => 13,
                        "name" => "clear",
                        "field" => "clear",
                        "label" => "Clear",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ],
                    [
                        "id" => 2,
                        "name" => "account_id",
                        "field" => "account",
                        "label" => "Account",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 3,
                        "name" => "current_balance",
                        "field" => "current balance",
                        "label" => "Currenct Balance",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 4,
                        "name" => "debit",
                        "field" => "debit",
                        "label" => "Debit",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 5,
                        "name" => "credit",
                        "field" => "credit",
                        "label" => "Credit",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 6,
                        "name" => "notes",
                        "field" => "notes",
                        "label" => "Notes",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 7,
                        "name" => "currency_id",
                        "field" => "currency",
                        "label" => "Currency",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 8,
                        "name" => "parity",
                        "field" => "parity",
                        "label" => "Parity",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 9,
                        "name" => "equivalent",
                        "field" => "equivalent",
                        "label" => "Equivalent",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 10,
                        "name" => "final_balance",
                        "field" => "final balance",
                        "label" => "Final Balance",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 11,
                        "name" => "contra_account_id",
                        "field" => "contra account",
                        "label" => "Contra Account",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ], [
                        "id" => 12, "name" => "cost_center_id",
                        "field" => "cost center",
                        "label" => "Cost Center",
                        "align" => "center",
                        "visibility" => true,
                        "bgColor" => ""
                    ]
                ],
                "visibleColumns" => [
                    "delete",
                    "clear",
                    "account_id",
                    "current_balance",
                    "debit",
                    "credit",
                    "notes",
                    "currency_id",
                    "parity",
                    "final_balance",
                    "equivalent",
                    "contra_account_id",
                    "cost_center_id"
                ],
                "tableSeparatorStyle" => "horizontal",
                "tablePagination" => [
                    "sortBy" => null,
                    "descending" => false,
                    "page" => 1,
                    "rowsPerPage" => 10
                ]
            ],

        ];
        $print_setting = [];


        $users = User::all();
        foreach ($users as $user) {
            VoucherPermissionUser::create(
                [

                    'show_setting' => $show_setting,
                    'print_setting' => $print_setting,
                    'user_id' => $user->id,
                    'voucher_template_id' => $voucher_template_id
                ]
            );
        }
    }

    public function generateJournalEntry(Request $request, $source_id, $source_template_id)
    {
        $voucher_template_id = $request['voucher_template_id'];
        $voucher_template = VoucherTemplate::find($voucher_template_id);
        $source = [
            'source_id' => $source_id,
            'source_template_id' => $source_template_id,
            'has_source' => true,
            "source_name" => "voucher"
        ];

        $generatredJournalEntry = JournalEntry::create([
            'date' => $request['date'],
            'time' => $request['time'],
            'receipt_number' => $request['receipt_number'],
            'currency_id' => $request['currency_id'],
            'account_id' => $request['account_id'],
            'parity' => $request['parity'],
            'security_level' => $request['security_level'],
            'debit_total' => $request['debit_total'],
            'credit_total' => $request['credit_total'],
            'branch_id' => $request['branch_id'],
            'notes' => $request['notes'],
            'is_post_to_account' => $request['is_post_to_account'],
            'source' => $source

        ]);
        $voucher = Voucher::find($source_id);
        $voucher['generated_entry_id'] = $generatredJournalEntry->id;
        $voucher->save();

        if ($voucher_template['is_entry'] == true) {
            $this->generateJournalEntryRecord($request, $generatredJournalEntry->id);
        }
        // Reciept
        if ($voucher_template['is_receipt'] == true) {
            if ($voucher_template['is_generates_entry_for_each_item'] == false) {
                $this->generateJournalEntryRecord($request, $generatredJournalEntry->id);
                $this->generateJournalEntryRecordOfReciept($request, $generatredJournalEntry->id);
            }
            if ($voucher_template['is_generates_entry_for_each_item'] == true) {
                $this->generateJournalEntryRecordForeachReciept($request, $generatredJournalEntry->id);
            }
        }

        if ($voucher_template['is_payment'] == true) {

            if ($voucher_template['is_generates_entry_for_each_item'] == false) {
                $this->generateJournalEntryRecord($request, $generatredJournalEntry->id);
                $this->generateJournalEntryRecordOfPayment($request, $generatredJournalEntry->id);
            }
            if ($voucher_template['is_generates_entry_for_each_item'] == true) {
                $this->generateJournalEntryRecordForeachPayment($request, $generatredJournalEntry->id);
            }
        }

        if ($voucher_template['is_daily'] == true) {
            $this->generateJournalEntryRecordDaily($request, $generatredJournalEntry->id);
        }
    }

    public function generateJournalEntryRecord(Request $request, $journal_entry_id)
    {
        $JournalEntry_Records = JournalEntry::find($journal_entry_id)->records;
        foreach ($JournalEntry_Records as $JournalEntry_Record) {
            $JournalEntry_Record->forceDelete();
        }
        $JournalEntryRecords = $request->records;
        foreach ($JournalEntryRecords as $JournalEntryRecord) {
            JournalEntryRecord::create([
                'account_id' => $JournalEntryRecord['account_id'],
                'debit' => $JournalEntryRecord['debit'],
                'index' => abs($JournalEntryRecord['index']),
                'relative_debit' => $JournalEntryRecord['debit'],
                'relative_credit' => $JournalEntryRecord['credit'],
                'credit' => $JournalEntryRecord['credit'],
                'notes' => $JournalEntryRecord['notes'],
                'cost_center_id' => $JournalEntryRecord['cost_center_id'],
                'currency_id' => $JournalEntryRecord['currency_id'],
                'parity' => $JournalEntryRecord['parity'],
                'equivalent' => $JournalEntryRecord['equivalent'],
                'contra_account_id' => $JournalEntryRecord['contra_account_id'],
                'current_balance' => $JournalEntryRecord['current_balance'],
                'final_balance' => $JournalEntryRecord['final_balance'],
                'journal_entry_id' => $journal_entry_id,
                'is_post_to_account' => $JournalEntryRecord['is_post_to_account'],
                'post_to_account_date' => $JournalEntryRecord['post_to_account_date'],
                'relative_final_balance' => $JournalEntryRecord['relative_final_balance'],
                'relative_current_balance' => $JournalEntryRecord['relative_current_balance'],
            ]);
        }
    }

    public function generateJournalEntryRecordOfReciept(Request $request, $journal_entry_id)
    {
        $sum = 0;
        $JournalEntryRecords = $request->records;
        foreach ($JournalEntryRecords as $JournalEntryRecord) {
            $sum = $sum + $JournalEntryRecord['credit'];
        }
        JournalEntryRecord::create([
            'account_id' => $request['account_id'],
            'debit' => $sum,
            'index' => abs($request['index']),
            'relative_debit' => $request['debit'],
            'relative_credit' => $request['credit'],
            'notes' => $request['notes'],
            'cost_center_id' => $request['cost_center_id'],
            'currency_id' => $request['currency_id'],
            'parity' => $request['parity'],
            'equivalent' => $request['equivalent'],
            'contra_account_id' => $request['contra_account_id'],
            'current_balance' => $request['current_balance'],
            'final_balance' => $request['final_balance'],
            'journal_entry_id' => $journal_entry_id,
            'is_post_to_account' => $request['is_post_to_account'],
            'post_to_account_date' => $request['post_to_account_date'],
            'relative_final_balance' => $request['relative_final_balance'],
            'relative_current_balance' => $request['relative_current_balance'],
        ]);
    }

    public function generateJournalEntryRecordForeachReciept(Request $request, $journal_entry_id)
    {
        $JournalEntryRecords = $request->records;
        foreach ($JournalEntryRecords as $JournalEntryRecord) {

            JournalEntryRecord::create([
                'account_id' => $JournalEntryRecord['account_id'],
                'debit' => $JournalEntryRecord['credit'],
                'index' => abs($JournalEntryRecord['index']),
                'relative_debit' => $JournalEntryRecord['debit'],
                'relative_credit' => $JournalEntryRecord['credit'],
                'notes' => $JournalEntryRecord['notes'],
                'cost_center_id' => $JournalEntryRecord['cost_center_id'],
                'currency_id' => $JournalEntryRecord['currency_id'],
                'parity' => $JournalEntryRecord['parity'],
                'equivalent' => $JournalEntryRecord['equivalent'],
                'contra_account_id' => $JournalEntryRecord['contra_account_id'],
                'current_balance' => $JournalEntryRecord['current_balance'],
                'final_balance' => $JournalEntryRecord['final_balance'],
                'journal_entry_id' => $journal_entry_id,
                'is_post_to_account' => $JournalEntryRecord['is_post_to_account'],
                'post_to_account_date' => $JournalEntryRecord['post_to_account_date'],
                'relative_final_balance' => $JournalEntryRecord['relative_final_balance'],
                'relative_current_balance' => $JournalEntryRecord['relative_current_balance'],
            ]);

            JournalEntryRecord::create([
                'account_id' => $JournalEntryRecord['account_id'],
                'credit' => $JournalEntryRecord['credit'],
                'index' => abs($JournalEntryRecord['index']),
                'relative_debit' => $JournalEntryRecord['debit'],
                'relative_credit' => $JournalEntryRecord['credit'],
                'notes' => $JournalEntryRecord['notes'],
                'cost_center_id' => $JournalEntryRecord['cost_center_id'],
                'currency_id' => $JournalEntryRecord['currency_id'],
                'parity' => $JournalEntryRecord['parity'],
                'equivalent' => $JournalEntryRecord['equivalent'],
                'contra_account_id' => $JournalEntryRecord['contra_account_id'],
                'current_balance' => $JournalEntryRecord['current_balance'],
                'final_balance' => $JournalEntryRecord['final_balance'],
                'journal_entry_id' => $journal_entry_id,
                'is_post_to_account' => $JournalEntryRecord['is_post_to_account'],
                'post_to_account_date' => $JournalEntryRecord['post_to_account_date'],
                'relative_final_balance' => $JournalEntryRecord['relative_final_balance'],
                'relative_current_balance' => $JournalEntryRecord['relative_current_balance'],
            ]);
        }
    }

    public function generateJournalEntryRecordOfPayment(Request $request, $journal_entry_id)
    {
        $debit_total = $request->debit_total;
        JournalEntryRecord::create([
            'account_id' => $request['account_id'],
            'credit' => $debit_total,
            'index' => abs($request['index']),
            'relative_debit' => $request['debit'],
            'relative_credit' => $request['credit'],
            'notes' => $request['notes'],
            'cost_center_id' => $request['cost_center_id'],
            'currency_id' => $request['currency_id'],
            'parity' => $request['parity'],
            'equivalent' => $request['equivalent'],
            'contra_account_id' => $request['contra_account_id'],
            'current_balance' => $request['current_balance'],
            'final_balance' => $request['final_balance'],
            'journal_entry_id' => $journal_entry_id,
            'is_post_to_account' => $request['is_post_to_account'],
            'post_to_account_date' => $request['post_to_account_date'],
            'relative_final_balance' => $request['relative_final_balance'],
            'relative_current_balance' => $request['relative_current_balance'],
        ]);
    }

    public function generateJournalEntryRecordForeachPayment(Request $request, $journal_entry_id)
    {
        $JournalEntryRecords = $request->records;
        foreach ($JournalEntryRecords as $JournalEntryRecord) {
            JournalEntryRecord::create([
                'account_id' => $JournalEntryRecord['account_id'],
                'index' => abs($JournalEntryRecord['index']),
                'relative_debit' => $JournalEntryRecord['debit'],
                'relative_credit' => $JournalEntryRecord['credit'],
                'credit' => $JournalEntryRecord['debit'],
                'notes' => $JournalEntryRecord['notes'],
                'cost_center_id' => $JournalEntryRecord['cost_center_id'],
                'currency_id' => $JournalEntryRecord['currency_id'],
                'parity' => $JournalEntryRecord['parity'],
                'equivalent' => $JournalEntryRecord['equivalent'],
                'contra_account_id' => $JournalEntryRecord['contra_account_id'],
                'current_balance' => $JournalEntryRecord['current_balance'],
                'final_balance' => $JournalEntryRecord['final_balance'],
                'journal_entry_id' => $journal_entry_id,
                'is_post_to_account' => $JournalEntryRecord['is_post_to_account'],
                'post_to_account_date' => $JournalEntryRecord['post_to_account_date'],
                'relative_final_balance' => $JournalEntryRecord['relative_final_balance'],
                'relative_current_balance' => $JournalEntryRecord['relative_current_balance'],
            ]);
            JournalEntryRecord::create([
                'account_id' => $JournalEntryRecord['account_id'],
                'debit' => $JournalEntryRecord['debit'],
                'index' => abs($JournalEntryRecord['index']),
                'relative_debit' => $JournalEntryRecord['debit'],
                'relative_credit' => $JournalEntryRecord['credit'],
                'notes' => $JournalEntryRecord['notes'],
                'cost_center_id' => $JournalEntryRecord['cost_center_id'],
                'currency_id' => $JournalEntryRecord['currency_id'],
                'parity' => $JournalEntryRecord['parity'],
                'equivalent' => $JournalEntryRecord['equivalent'],
                'contra_account_id' => $JournalEntryRecord['contra_account_id'],
                'current_balance' => $JournalEntryRecord['current_balance'],
                'final_balance' => $JournalEntryRecord['final_balance'],
                'journal_entry_id' => $journal_entry_id,
                'is_post_to_account' => $JournalEntryRecord['is_post_to_account'],
                'post_to_account_date' => $JournalEntryRecord['post_to_account_date'],
                'relative_final_balance' => $JournalEntryRecord['relative_final_balance'],
                'relative_current_balance' => $JournalEntryRecord['relative_current_balance'],
            ]);
        }
    }

    public function generateJournalEntryRecordDaily(Request $request, $journal_entry_id)
    {
        $JournalEntry_Records = JournalEntry::find($journal_entry_id)->records;
        foreach ($JournalEntry_Records as $JournalEntry_Record) {
            $JournalEntry_Record->forceDelete();
        }
        $JournalEntryRecords = $request->records;
        foreach ($JournalEntryRecords as $JournalEntryRecord) {
            JournalEntryRecord::create([
                'account_id' => $JournalEntryRecord['account_id'],
                'index' => abs($JournalEntryRecord['index']),
                'relative_debit' => $JournalEntryRecord['debit'],
                'relative_credit' => $JournalEntryRecord['credit'],
                'credit' => $JournalEntryRecord['debit'],
                'debit' => $JournalEntryRecord['credit'],
                'notes' => $JournalEntryRecord['notes'],
                'cost_center_id' => $JournalEntryRecord['cost_center_id'],
                'currency_id' => $JournalEntryRecord['currency_id'],
                'parity' => $JournalEntryRecord['parity'],
                'equivalent' => $JournalEntryRecord['equivalent'],
                'contra_account_id' => $JournalEntryRecord['contra_account_id'],
                'current_balance' => $JournalEntryRecord['current_balance'],
                'final_balance' => $JournalEntryRecord['final_balance'],
                'journal_entry_id' => $journal_entry_id,
                'is_post_to_account' => $JournalEntryRecord['is_post_to_account'],
                'post_to_account_date' => $JournalEntryRecord['post_to_account_date'],
                'relative_final_balance' => $JournalEntryRecord['relative_final_balance'],
                'relative_current_balance' => $JournalEntryRecord['relative_current_balance'],
            ]);
        }
    }


}
