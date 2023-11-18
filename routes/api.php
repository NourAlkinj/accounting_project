<?php

use App\Events\ItemsUpdated;
use App\Events\UserCreated;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetGroupController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillTemplateController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyInformationController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\CurrencyActivityController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\DefaultCurrencyController;
use App\Http\Controllers\DefaultPriceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\JournalEntryPermissionUserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Notifications\NotificationsController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\ReportTemplateController;
use App\Http\Controllers\ReturnedBillController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VoucherPermissionUserController;
use App\Http\Controllers\VoucherTemplateController;
use App\Models\DefaultCurrency;
use App\Models\Store;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::post('/broadcasting/auth', function () {
  return true;
});

Route::get('check-user-information', [UserController::class, 'checkUserInformation']);

Route::get('/', function () {
  return view('welcome');
});

Route::get('/playground', function () {
  event(new \App\Events\PlaygroundEvent());
  return null;
});

Route::post('change-lang', function (Illuminate\Http\Request $request) {
  $locale = $request->input('locale');

  App::setLocale($locale);
  config(['app.locale' => $locale]);
  Session::put('locale', $locale);
  return response()->json(['message' => 'Locale changed successfully']);
});
Route::get('performance-seeder', [Controller::class, 'performanceSeeder']);


Route::get('get-current-lang', function (Illuminate\Http\Request $request) {
  return Session::get('locale');
});

Route::get('get-stores-count', function () {
  $stores = Store::all();
  return $stores;

});

//------------Common-------------//
Route::get('getAllConnectedPrinters', [Controller::class, 'getAllConnectedPrinters'])->name('getAllConnectedPrinters');


//
//-------Branch------//

Route::group(['namespace' => 'Branch', 'prefix' => 'branch', 'auth'], function () {

  Route::get('index', [BranchController::class, 'index'])->name('branch.index');
  Route::get('all', [BranchController::class, 'all'])->name('branch.all');

  Route::post('store', [BranchController::class, 'store'])->name('branch.store');
  Route::get('show/{id}', [BranchController::class, 'show'])->name('branch.show');
  Route::post('update/{id}', [BranchController::class, 'update'])->name('branch.update');
//  Route::get('delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');
  Route::get('delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');

  Route::get('call-generate-codes/{id}', [BranchController::class, 'callGenerateCodes'])->name('branch.callGenerateCodes');
  Route::get('call-auto-complete/{id}', [BranchController::class, 'callAutoComplete'])->name('branch.callAutoComplete');
  Route::get('call-get-name-and-code/{id}', [BranchController::class, 'callGetNameAndCode'])->name('branch.callGetNameAndCode');
  Route::get('branchOrUserInBranch/{id}', [BranchController::class, 'branchOrUserInBranch'])->name('branch.branchOrUserInBranch');
  Route::get('call-get-all-codes-and-names', [BranchController::class, 'callGetAllCodesAndNames'])->name('branch.callGetAllCodesAndNames');
  Route::get('call-get-object-by-value/{code}', [BranchController::class, 'callGetObjectByValue'])->name('branch.callGetObjectByValue');
  Route::get('getQuery', [BranchController::class, 'getQuery'])->name('branch.getQuery');
  Route::get('get-object-By-code-dB', [BranchController::class, 'getObjectByCodeDB'])->name('branch.getObjectByCodeDB');
  Route::get('get-all-ids', [BranchController::class, 'callGetAllIDs'])->name('branch.callGetAllIDs');
  Route::get('call-get-root-code', [BranchController::class, 'callGetRootCode'])->name('branch.callGetRootCode');
  Route::get('call-get-count-raws-in-model', [BranchController::class, 'callGetCountRawsInModel'])->name('branch.callGetCountRawsInModel');
  Route::get('callNumOfSubModels/{id}', [BranchController::class, 'callNumOfSubModels'])->name('branch.callNumOfSubModels');
  Route::get('call-validate-code/{code}', [BranchController::class, 'callValidateCode'])->name('branch.callValidateCode');
  Route::get('last-ID', [BranchController::class, 'lastId'])->name('branch.lastID');
  Route::get('get-parent/{id}', [BranchController::class, 'getParent'])->name('branch.getParent');
  Route::get('callgetParentName/{id}', [BranchController::class, 'callgetParentName'])->name('branch.callgetParentName');
  Route::get('call-de-activate-children/{id}', [BranchController::class, 'callDeActivateChildren'])->name('branch.callDeActivateChildren');
  Route::get('call-activate-children/{id}', [BranchController::class, 'callActivateChildren'])->name('branch.callActivateChildren');

  Route::get('call-activate-de-activate-children/{id}', [BranchController::class, 'callActivateDeActivateBranch'])->name('branch.callActivateDeActivateBranch');
  Route::get('root', [BranchController::class, 'callRoot'])->name('branch.callRoot');
  Route::get('not-root', [BranchController::class, 'callNotRoot'])->name('branch.callNotRoot');
  Route::get('call-de-activate-children/{id}', [BranchController::class, 'callDeActivateChildren'])->name('branch.callDeActivateChildren');
  // Route::get('call--activate-de-activate-children/{id}', [BranchController::class, 'callActivateDeActivateBranch'])->name('branch.callActivateDeActivateBranch');


});

//Route::get('/locale/{locale}', function (string $locale) {
//
//  Route::get('index', [BranchController::class, 'index'])->name('branch.index');
//  Route::get('all', [BranchController::class, 'all'])->name('branch.all');
//
//  Route::post('store', [BranchController::class, 'store'])->name('branch.store');
//  Route::get('show/{id}', [BranchController::class, 'show'])->name('branch.show');
//  Route::post('update/{id}', [BranchController::class, 'update'])->name('branch.update');
//  Route::get('delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');
//  Route::get('call-generate-codes/{id}', [BranchController::class, 'callGenerateCodes'])->name('branch.callGenerateCodes');
//  Route::get('call-auto-complete/{id}', [BranchController::class, 'callAutoComplete'])->name('branch.callAutoComplete');
//  Route::get('call-get-name-and-code/{id}', [BranchController::class, 'callGetNameAndCode'])->name('branch.callGetNameAndCode');
//  Route::get('branchOrUserInBranch/{id}', [BranchController::class, 'branchOrUserInBranch'])->name('branch.branchOrUserInBranch');
//  Route::get('call-get-all-codes-and-names', [BranchController::class, 'callGetAllCodesAndNames'])->name('branch.callGetAllCodesAndNames');
//  Route::get('call-get-object-by-value/{code}', [BranchController::class, 'callGetObjectByValue'])->name('branch.callGetObjectByValue');
//  Route::get('getQuery', [BranchController::class, 'getQuery'])->name('branch.getQuery');
//  Route::get('get-object-By-code-dB', [BranchController::class, 'getObjectByCodeDB'])->name('branch.getObjectByCodeDB');
//  Route::get('get-all-ids', [BranchController::class, 'callGetAllIDs'])->name('branch.callGetAllIDs');
//  Route::get('call-get-root-code', [BranchController::class, 'callGetRootCode'])->name('branch.callGetRootCode');
//  Route::get('call-get-count-raws-in-model', [BranchController::class, 'callGetCountRawsInModel'])->name('branch.callGetCountRawsInModel');
//  Route::get('callNumOfSubModels/{id}', [BranchController::class, 'callNumOfSubModels'])->name('branch.callNumOfSubModels');
//  Route::get('call-validate-code/{code}', [BranchController::class, 'callValidateCode'])->name('branch.callValidateCode');
//  Route::get('last-ID', [BranchController::class, 'lastId'])->name('branch.lastID');
//  Route::get('get-parent/{id}', [BranchController::class, 'getParent'])->name('branch.getParent');
//  Route::get('callgetParentName/{id}', [BranchController::class, 'callgetParentName'])->name('branch.callgetParentName');
//  Route::get('call-de-activate-children/{id}', [BranchController::class, 'callDeActivateChildren'])->name('branch.callDeActivateChildren');
//  Route::get('call-activate-children/{id}', [BranchController::class, 'callActivateChildren'])->name('branch.callActivateChildren');
//
//  Route::get('call-activate-de-activate-children/{id}', [BranchController::class, 'callActivateDeActivateBranch'])->name('branch.callActivateDeActivateBranch');
//  Route::get('root', [BranchController::class, 'callRoot'])->name('branch.callRoot');
//  Route::get('not-root', [BranchController::class, 'callNotRoot'])->name('branch.callNotRoot');
//  Route::get('call-de-activate-children/{id}', [BranchController::class, 'callDeActivateChildren'])->name('branch.callDeActivateChildren');
//  // Route::get('call--activate-de-activate-children/{id}', [BranchController::class, 'callActivateDeActivateBranch'])->name('branch.callActivateDeActivateBranch');
//});

Route::get('/locale/{locale}', function (string $locale) {

  \Illuminate\Support\Facades\App::setLocale($locale);
  return \Illuminate\Support\Facades\App::getLocale();
});

Route::post('chang-lang', [LanguageController::class, 'changeLanguage']);
Route::get('get-auth-lang', [LanguageController::class, 'getAuthLang']);


//-------User------//

Route::group(['namespace' => 'User', 'prefix' => 'user', 'auth'], function () {
  Route::post('/login', [UserController::class, 'login'])->name('login');
  Route::get('index', [UserController::class, 'index'])->name('user.index');
  Route::get('all', [UserController::class, 'all'])->name('user.all');

  Route::post('store', [UserController::class, 'store'])->name('user.store');
  Route::get('show/{id}', [UserController::class, 'show'])->name('user.show');
  Route::post('update/{id}', [UserController::class, 'update'])->name('user.update');
  Route::get('delete/{id}', [UserController::class, 'delete'])->name('user.delete');
  Route::get('call-generate-codes/{id}', [UserController::class, 'callGenerateCodes'])->name('user.callGenerateCodes');
  Route::get('call-get-all-codes-and-names', [UserController::class, 'callGetAllCodesAndNames'])->name('user.callGetAllCodesAndNames');
  Route::get('call-get-object-by-code/{code}', [UserController::class, 'callGetObjectByValue'])->name('user.callGetObjectByValue');
  Route::get('get-Roles', [UserController::class, 'getRoles'])->name('user.getRoles');
  Route::get('show-user-permissions/{id}', [UserController::class, 'showUserPermissions']);
  Route::get('show-user-permissions-back/{id}', [UserController::class, 'showUserPermissionsBack'])->name('user.showUserPermissions');
  Route::get('get-user-role/{id}', [UserController::class, 'getUserRole'])->name('user.getUserRole');
  Route::get('role-permission/{id}', [UserController::class, 'rolePermission'])->name('user.rolePermission');
  Route::get('role-permission-back/{id}', [UserController::class, 'showRolePermissionsBack'])->name('user.showRolePermissionsBack');
  Route::get('get-all-ids', [UserController::class, 'callGetAllIDs'])->name('user.callGetAllIDs');
  Route::get('call-get-count-raws-in-model', [UserController::class, 'callGetCountRawsInModel'])->name('user.callGetCountRawsInModel');
  Route::get('call-get-parent-name/{id}', [BranchController::class, 'callGetParentName'])->name('user.callGetParentName');
  Route::get('last-ID', [UserController::class, 'lastId'])->name('user.lastID');
  Route::get('root', [UserController::class, 'callRoot'])->name('user.callRoot');
  Route::get('not-root', [UserController::class, 'callNotRoot'])->name('user.callNotRoot');
  Route::get('Permission', [UserController::class, 'Permission'])->name('user.Permission');


  Route::get('set-all-permissions-to-admin', [UserController::class, 'setAllPermissionsToAdmin']);
  Route::get('is-use-user/{id}', [UserController::class, 'isUseUser'])->name('user.isUseUser');


});


//-------CompanyInformation------//


Route::group(['namespace' => 'CompanyInformation', 'prefix' => 'company_information'], function () {
  Route::get('index', [CompanyInformationController::class, 'index']);
  Route::post('store', [CompanyInformationController::class, 'store']);
  Route::get('show/{id}', [CompanyInformationController::class, 'show']);
  Route::post('update/{id}', [CompanyInformationController::class, 'update']);
  Route::get('delete/{id}', [CompanyInformationController::class, 'delete']);

});


//-------Category------//


Route::group(['namespace' => 'Category', 'prefix' => 'category', 'auth'], function () {
  Route::get('index', [CategoryController::class, 'index'])->name('category.index');
  Route::get('all', [CategoryController::class, 'all'])->name('category.all');

  Route::post('store', [CategoryController::class, 'store'])->name('category.store');
  Route::get('show/{id}', [CategoryController::class, 'show'])->name('category.show');
  Route::post('update/{id}', [CategoryController::class, 'update'])->name('category.update');
  Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
  Route::get('call-generate-codes/{id}', [CategoryController::class, 'callGenerateCodes'])->name('category.callGenerateCodes');
  Route::get('call-auto-complete/{id}', [CategoryController::class, 'callAutoComplete'])->name('category.callAutoComplete');
  Route::get('call-get-all-codes-and-names', [CategoryController::class, 'callGetAllCodesAndNames'])->name('category.callGetAllCodesAndNames');
});

//-------Item------//

Route::group(['namespace' => 'Item', 'prefix' => 'item', 'auth'], function () {
  Route::get('index', [ItemController::class, 'index'])->name('item.index');
  Route::get('all', [ItemController::class, 'all'])->name('item.all');
  Route::post('store', [ItemController::class, 'store'])->name('item.store');
  Route::get('show/{id}', [ItemController::class, 'show'])->name('item.show');
  Route::post('update/{id}', [ItemController::class, 'update'])->name('item.update');
  Route::get('delete/{id}', [ItemController::class, 'delete'])->name('item.delete');
  Route::get('call-generate-codes/{id}', [ItemController::class, 'callGenerateCodes'])->name('item.callGenerateCodes');
  Route::get('call-get-name-and-code/{id}', [ItemController::class, 'callGetNameAndCode'])->name('item.callGetNameAndCode');
  Route::get('get-item-by-id-or-barcode', [ItemController::class, 'getItemByIdOrBarcode'])->name('item.getItemByIdOrBarcode');

  Route::get('get-cost/{item_id}/{unit_id}/{store_id}/{currency_id}', [ItemController::class, 'getCost'])->name('bill.getCost');


  Route::get('get-item-max-purchase-cost/{item_id}/{unit_id}/{currency_id}', [ItemController::class, 'getItemMaxPurchaseCost']);

  Route::get('get-item-min-purchase-cost/{item_id}/{unit_id}/{currency_id}', [ItemController::class, 'getItemMinPurchaseCost']);

  Route::get('get-item-last-purchase-cost/{item_id}/{unit_id}/{currency_id}', [ItemController::class, 'getItemLastPurchaseCost']);

  Route::get('get-item-FIFO-cost/{currency_id}', [ItemController::class, 'getItemFIFOCost']);


});

//-------Unit------//

Route::group(['namespace' => 'Unit', 'prefix' => 'unit', 'auth'], function () {


  Route::get('get-item-units/{id}', [ItemController::class, 'getItemUnits'])->name('unit.getItemUnits');
  Route::get('get-all-item-units', [ItemController::class, 'getAllItemsUnits'])->name('unit.getAllItemsUnits');
  Route::get('get-unit-item/{id}', [ItemController::class, 'getUnitItem'])->name('unit.getUnitItem');
  Route::get('get-units-barcodes/{id}', [ItemController::class, 'getUnitBarcodes'])->name('unit.getUnitBarcodes');
  Route::get('get-item-units-barcodes/{id}', [ItemController::class, 'getItemUnitsBarcodes'])->name('unit.getItemUnitsBarcodes');
  Route::get('get-all-items-units-barcodes', [ItemController::class, 'getAllItemsUnitsBarcodes'])->name('unit.getAllItemsUnitsBarcodes');
  Route::post('saveUnit/{id}', [ItemController::class, 'saveUnit'])->name('unit.saveUnit');
  Route::post('saveUnitBarcodes/{itemId}/{unitId}', [ItemController::class, 'saveUnitBarcodes'])->name('unit.saveUnitBarcodes');
  Route::post('updateUnit/{id}', [ItemController::class, 'updateUnit'])->name('unit.updateUnit');
  Route::post('updateUnitBarcodes/{id}', [ItemController::class, 'updateUnitBarcodes'])->name('unit.updateUnitBarcodes');
  Route::post('store', [ItemController::class, 'store'])->name('unit.store');
  Route::post('update', [ItemController::class, 'updae'])->name('unit.update');
});

//-------Journal Entry------//


Route::group(['namespace' => 'JournalEntry', 'prefix' => 'journal_entry', 'auth'], function () {
  Route::get('index', [JournalEntryController::class, 'index'])->name('jounalEntry.index');
  Route::post('store', [JournalEntryController::class, 'store'])->name('jounalEntry.store');
  Route::get('show/{id}', [JournalEntryController::class, 'show'])->name('jounalEntry.show');
  Route::post('update/{id}', [JournalEntryController::class, 'update'])->name('jounalEntry.update');
  Route::get('delete/{id}', [JournalEntryController::class, 'delete'])->name('jounalEntry.delete');
  Route::get('cost-center/{id}', [JournalEntryController::class, 'journalEntryRecordCostCenter'])->name('jounalEntry.journalEntryRecordCostCenter');
  Route::get('soft-delete/{id}', [JournalEntryController::class, 'forceDelete'])->name('jounalEntry.forceDelete');
  Route::post('restore/{id}', [JournalEntryController::class, 'restoreJournalEntryRecords'])->name('jounalEntry.restoreJournalEntryRecords');
  Route::post('get-accounts', [JournalEntryController::class, 'getAccounts'])->name('jounalEntry.getAccounts');
  Route::get('getJournalRecords', [JournalEntryController::class, 'getJournalRecords'])->name('jounalEntry.getJournalRecords');
  Route::get('get-user', [JournalEntryController::class, 'getUser'])->name('jounalEntry.getUser');
  Route::get('init', [JournalEntryController::class, 'init'])->name('jounalEntry.init');
  Route::post('save-5000-row', [JournalEntryController::class, 'save5000row'])->name('jounalEntry.save5000row');
  Route::get('entries', function () {
    return \App\Models\JournalEntryRecord::all();
  });
});


//-------Journal Entry Permission User------//


Route::group(['namespace' => 'JournalEntryPermissionUser', 'prefix' => 'journal_entry_permission_user', 'auth'], function () {
  Route::get('index', [JournalEntryPermissionUserController::class, 'index'])->name('journal_entry_permission_user.index');
  Route::post('store', [JournalEntryPermissionUserController::class, 'store'])->name('journal_entry_permission_user.store');
  Route::get('show/{id}', [JournalEntryPermissionUserController::class, 'show'])->name('journal_entry_permission_user.show');
  Route::post('update/{id}', [JournalEntryPermissionUserController::class, 'update'])->name('journal_entry_permission_user.update');
  Route::get('delete/{id}', [JournalEntryPermissionUserController::class, 'delete'])->name('journal_entry_permission_user.delete');
  Route::get('user-options', [JournalEntryPermissionUserController::class, 'userOptions'])->name('journal_entry_permission_user.userOptionss');
  Route::get('get-auth', function () {
    Route::get('user-options', [JournalEntryPermissionUserController::class, 'userOptions'])->name('journal_entry_permission_user.userOptions');
  });
});

//-------Voucher------//


Route::group(['namespace' => 'Voucher', 'prefix' => 'voucher', 'auth'], function () {
  Route::get('index', [VoucherController::class, 'index'])->name('voucher.index');
  Route::get('vouchers-according-to-template/{id}', [VoucherController::class, 'vouchersAccordingToTemplate'])->name('voucher.vouchersAccordingToTemplate');
  Route::post('store', [VoucherController::class, 'store'])->name('voucher.store');
  Route::get('show/{id}', [VoucherController::class, 'show'])->name('voucher.show');
  Route::post('update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
  Route::get('delete/{id}', [VoucherController::class, 'delete'])->name('voucher.delete');
  Route::get('cost-center/{id}', [VoucherController::class, 'voucherRecordCostCenter'])->name('voucher.voucherRecordCostCenter');
  Route::get('soft-delete/{id}', [VoucherController::class, 'forceDelete'])->name('voucher.forceDelete');
  Route::post('restore/{id}', [VoucherController::class, 'restoreVoucherRecords'])->name('voucher.restoreVoucherRecords');
  Route::get('get-voucher-Records', [VoucherController::class, 'getVoucherRecords'])->name('voucher.getVoucherRecords');
  Route::post('saveVoucherRecords/{voucher_id}', [VoucherController::class, 'saveVoucherRecords'])->name('voucher.saveVoucherRecord');
  Route::post('generateJournalEntry', [VoucherController::class, 'generateJournalEntry'])->name('voucher.generateJournalEntry');
});


//-------Voucher Permission User------//


Route::group(['namespace' => 'VoucherPermissionUser', 'prefix' => 'voucher_permission_user', 'auth'], function () {
  Route::get('index', [VoucherPermissionUserController::class, 'index'])->name('voucher_permission_user.index');
  Route::post('store/{voucher_template_id}', [VoucherPermissionUserController::class, 'store'])->name('voucher_permission_user.store');
  Route::get('show/{id}', [VoucherPermissionUserController::class, 'show'])->name('voucher_permission_user.show');
  Route::post('update/{id}', [VoucherPermissionUserController::class, 'update'])->name('voucher_permission_user.update');
  Route::get('delete/{id}', [VoucherPermissionUserController::class, 'delete'])->name('voucher_permission_user.delete');
  Route::get('user-voucher-options/{voucher_template_id}', [VoucherPermissionUserController::class, 'userVoucherOptions'])->name('voucher_permission_user.userVoucherOptions');
});


//-------Bill------//


Route::group(['namespace' => 'Bill', 'prefix' => 'bill', 'auth'], function () {
  Route::get('index', [BillController::class, 'index'])->name('bill.index');
  Route::get('all', [BillController::class, 'all'])->name('bill.all');
  Route::get('bills-according-to-template/{id}', [BillController::class, 'billsAccordingToTemplate'])->name('bill.billsAccordingToTemplate');
  Route::post('store', [BillController::class, 'store'])->name('bill.store');
  Route::get('show/{id}', [BillController::class, 'show'])->name('bill.show');
  Route::post('update/{id}', [BillController::class, 'update'])->name('bill.update');
  Route::get('delete/{id}', [BillController::class, 'delete'])->name('bill.delete');
  Route::get('cost-center/{id}', [BillController::class, 'billRecordCostCenter'])->name('bill.billRecordCostCenter');
  Route::get('soft-delete/{id}', [BillController::class, 'forceDelete'])->name('bill.forceDelete');
  Route::post('restore/{id}', [BillController::class, 'restoreBillRecords'])->name('bill.restoreBillRecords');
  Route::get('get-voucher-Records', [BillController::class, 'getBillRecords'])->name('bill.getBillRecords');
  Route::post('save-bill-record/{bill_id}', [BillController::class, 'saveBillRecord'])->name('bill.saveBillRecord');
  Route::get('get_current_store_exist_quantity/{item_id}/{store_id}', [BillController::class, 'getCurrentStoreExistQuantity'])->name('bill.getCurrentStoreExistQuantity');
  Route::get('get_current_exist_quantity/{item_id}', [BillController::class, 'getCurrentExistQuantity'])->name('bill.getCurrentExistQuantity');


  Route::get('generateJournalEntry', [BillTemplateController::class, 'generateJournalEntry'])->name('bill.generateJournalEntry');

  Route::get('get-records-with-max-quantities/{bill_id}', [BillController::class, 'getRecordsWithMaxQuantities']);


  //  Route::get('get-cost/{item_id}/{unit_id}/{store_id}/{currency_id}', [BillController::class, 'getCost'])->name('bill.getCost');
});


//------- Department ------//

Route::group(['namespace' => 'Department', 'prefix' => 'department'], function () {
  Route::get('index', [DepartmentController::class, 'index'])->name('department.index');
  Route::get('all', [DepartmentController::class, 'all'])->name('department.all');
  Route::post('store', [DepartmentController::class, 'store'])->name('department.store');
  Route::get('show/{id}', [DepartmentController::class, 'show'])->name('department.show');
  Route::post('update/{id}', [DepartmentController::class, 'update'])->name('department.update');
  Route::get('delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');
  Route::get('call-generate-codes/{id}', [DepartmentController::class, 'callGenerateCodes'])->name('department.callGenerateCodes');
  Route::get('call-auto-complete/{id}', [DepartmentController::class, 'callAutoComplete'])->name('department.callAutoComplete');
});

//------- Employee ------//

Route::group(['namespace' => 'Employee', 'prefix' => 'employee'], function () {
  Route::get('index', [EmployeeController::class, 'index'])->name('employee.index');
  Route::get('all', [EmployeeController::class, 'all'])->name('employee.all');
  Route::post('store', [EmployeeController::class, 'store'])->name('employee.store');
  Route::get('show/{id}', [EmployeeController::class, 'show'])->name('employee.show');
  Route::post('update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
  Route::get('delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
  Route::get('call-generate-codes/{id}', [EmployeeController::class, 'callGenerateCodes'])->name('employee.callGenerateCodes');
});
//------- Tasks ------//

Route::group(['namespace' => 'Task', 'prefix' => 'task', 'auth'], function () {

  Route::get('index', [TaskController::class, 'index'])->name('task.index');
  Route::get('all', [TaskController::class, 'all'])->name('task.all');
  Route::post('store', [TaskController::class, 'store'])->name('task.store');
  Route::get('show/{id}', [TaskController::class, 'show'])->name('task.show');
  Route::post('update/{id}', [TaskController::class, 'update'])->name('task.update');
  Route::get('delete/{id}', [TaskController::class, 'delete'])->name('task.delete');


  //---------Relations---------//
  Route::get('get-state-tasks/{id}', [TaskController::class, 'getStateTasks']);
  Route::get('get-task-employees/{id}', [TaskController::class, 'getTaskEmployees']);
  Route::get('get-employees-tasks', [TaskController::class, 'getEmployeesTasks']);
  Route::get('get-task-state/{id}', [TaskController::class, 'delete']);
  Route::get('get-employee-with-tasks/{id}', [TaskController::class, 'getEmployeeWithTasks']);
  Route::get('get-task-supervisor/{id}', [TaskController::class, 'getTaskSupervisor']);
  Route::get('get-supervisor-task/{id}', [TaskController::class, 'getSupervisorTask']);
  Route::get('swap-task/{from_emp_id}/{to_emp_id}/{task_id}', [TaskController::class, 'swapTask']);
  Route::get('remove-task-from-employee/{employee_id}/{task_id}', [TaskController::class, 'removeTaskFromEmployee']);
  Route::post('update-tasks-state', [TaskController::class, 'updateTasksState']);
});

//------- Attachments------//

Route::group(['namespace' => 'Attachment', 'prefix' => 'attachment'], function () {
  Route::post('upload', [AttachmentController::class, 'upload'])->name('attachment.upload');
  Route::get('folder/{folder_name}', [AttachmentController::class, 'folder'])->name('attachment.folder');
});


//------- Tasks States------//

Route::group(['namespace' => 'TaskState', 'prefix' => 'task-state'], function () {
  Route::get('index', [TaskStateController::class, 'index'])->name('task-state.index');
  Route::post('store', [TaskStateController::class, 'store'])->name('task-state.store');
  Route::get('show/{id}', [TaskStateController::class, 'show'])->name('task-state.show');
  Route::post('update/{id}', [TaskStateController::class, 'update'])->name('task-state.update');
  Route::get('delete/{id}', [TaskStateController::class, 'delete'])->name('task-state.delete');
  Route::post('states-update', [TaskStateController::class, 'StatesUpdate'])->name('task-state.StatesUpdate');
  Route::post('transfer-task', [TaskStateController::class, 'transferTask'])->name('task-state.transferTask');
  Route::post('update-task-state', [TaskStateController::class, 'updateTaskState'])->name('task-state.updateTaskState');


});

//------- Reports------//

Route::group(['namespace' => 'Report', 'prefix' => 'report'], function () {
  Route::get('get-pie-chart-items-quantity/{store_id}', [ReportController::class, 'getPieChartItemQuantityInStore'])->name('report.getPieChartItemQuantityInStore');

  Route::get('get-pie-chart-items-quantity-in-all', [ReportController::class, 'getPieChartItemQuantityInAllStores'])->name('report.getPieChartItemQuantityInAllStores');

  Route::get('get-bar-chart-items-quantity/{store_id}', [ReportController::class, 'getBarChartItemQuantityInStore'])->name('report.getBarChartItemQuantityInStore');

  Route::get('get-bar-chart-items-quantity-in-all', [ReportController::class, 'getBarChartItemQuantityInAllStores'])->name('report.getBarChartItemQuantityInAllStores');

  Route::get('ledgerReport', [ReportController::class, 'ledgerReport'])->name('report.ledgerReport');

  Route::post('finalLedgerReport', [ReportController::class, 'finalLedgerReport'])->name('report.finalLedgerReport');

  Route::post('ledger', [ReportController::class, 'ledger'])->name('report.ledger');
  Route::post('itemRepricing', [ReportController::class, 'itemRepricing'])->name('itemRepricing.ledger');

  Route::post('change-items-price', [ReportController::class, 'changeItemsPrice']);


  Route::get('accounts-balances-report', [ReportController::class, 'accountsBalancesReport'])->name('report.accountsBalancesReport');


});


//------- Store ------//
Route::group(['namespace' => 'Store', 'prefix' => 'store', 'auth'], function () {
  Route::get('index', [StoreController::class, 'index'])->name('store.index');
  Route::get('all', [StoreController::class, 'all'])->name('store.all');
  Route::post('store', [StoreController::class, 'store'])->name('store.store');
  Route::get('show/{id}', [StoreController::class, 'show'])->name('store.show');
  Route::post('update/{id}', [StoreController::class, 'update'])->name('store.update');
  Route::get('delete/{id}', [StoreController::class, 'delete'])->name('store.delete');
  Route::get('call-generate-codes/{id}', [StoreController::class, 'callGenerateCodes'])->name('store.callGenerateCodes');
  Route::get('call-auto-complete/{id}', [StoreController::class, 'callAutoComplete'])->name('store.callAutoComplete');
  Route::get('get-normals-in-assembly/{id}', [StoreController::class, 'getNormalsInAssembly'])->name('store.getNormalsInAssembly');
  Route::get('get-all-normals', [StoreController::class, 'getAllNormals'])->name('store.getAllNormals');
  Route::get('get-all-leaf-normal', [StoreController::class, 'getAllLeafNormal'])->name('store.getAllLeafNormal');
  Route::get('is-use-store/{id}', [StoreController::class, 'isUseStore'])->name('store.isUseStore');
});


//------- Currency ------//
Route::group(['namespace' => 'Currency', 'prefix' => 'currency', 'auth'], function () {
  Route::get('index', [CurrencyController::class, 'index'])->name('currency.index');
  Route::get('all', [CurrencyController::class, 'all'])->name('currency.all');
  Route::post('store', [CurrencyController::class, 'store'])->name('currency.store');
  Route::get('show/{id}', [CurrencyController::class, 'show'])->name('currency.show');
  Route::post('update/{id}', [CurrencyController::class, 'update'])->name('currency.update');
  Route::get('delete/{id}', [CurrencyController::class, 'delete'])->name('currency.delete');
  Route::get('get-default-currency', [CurrencyController::class, 'getDefaultCurrency'])->name('currency.getDefaultCurrency');
  Route::get('parity-in-date/{requiredCurrencyId}/{journalAccordingDate}', [CurrencyController::class, 'logParity'])->name('currency.logParity');
  Route::get('activity-log', [CurrencyActivityController::class, 'index'])->name('currency.index');
  Route::get('is-use-currency/{id}', [CurrencyController::class, 'isUseCurrency'])->name('currency.isUseCurrency');

});

//------- DefaultCurrency ------//
Route::group(['namespace' => 'DefaultCurrency', 'prefix' => 'defaultCurrency', 'auth'], function () {
  Route::get('index', [DefaultCurrencyController::class, 'index'])->name('defaultCurrency.index');
  Route::get('all', [DefaultCurrency::class, 'all'])->name('defaultCurrency.all');
  Route::get('show/{id}', [DefaultCurrencyController::class, 'show'])->name('defaultCurrency.show');
});

//-------CostCenter------//
Route::group(['namespace' => 'CostCenter', 'prefix' => 'costCenter', 'auth'], function () {
  Route::get('index', [CostCenterController::class, 'index'])->name('costCenter.index');
  Route::get('all', [CostCenterController::class, 'all'])->name('costCenter.all');
  Route::post('store', [CostCenterController::class, 'store'])->name('costCenter.store');
  Route::get('show/{id}', [CostCenterController::class, 'show'])->name('costCenter.show');
  Route::post('update/{id}', [CostCenterController::class, 'update'])->name('costCenter.update');
  Route::get('delete/{id}', [CostCenterController::class, 'delete'])->name('costCenter.delete');
  Route::get('call-generate-codes/{id}', [CostCenterController::class, 'callGenerateCodes'])->name('costCenter.callGenerateCodes');
  Route::get('call-auto-complete/{id}', [CostCenterController::class, 'callAutoComplete'])->name('costCenter.callAutoComplete');
  Route::get('get-normals-in-assembly/{id}', [CostCenterController::class, 'getNormalsInAssembly'])->name('costCenter.getNormalsInAssembly');
  Route::get('get-all-normals', [CostCenterController::class, 'getAllNormals'])->name('costCenter.getAllNormals');
  Route::get('get-all-leaf-normal', [CostCenterController::class, 'getAllLeafNormal'])->name('costCenter.getAllLeafNormal');
  Route::get('call-get-credit-debit-currentBalance/{id}', [CostCenterController::class, 'callGetCreditDebitCurrentBalance'])->name('costCenter.callGetCreditDebitCurrentBalance');
  Route::get('is-use-cost-center/{id}', [CostCenterController::class, 'isUseCostCenter'])->name('costCenter.isUseCostCenter');
  Route::get('call-get-debit/{id}/{requiredCurrencyId}', [CostCenterController::class, 'callGetDebit'])->name('costCenter.callGetDebit');
  Route::get('call-get-credit/{id}/{requiredCurrencyId}', [CostCenterController::class, 'callGetCredit'])->name('costCenter.callGetCredit');
  Route::get('call-get-currentBalance/{id}/{requiredCurrencyId}', [CostCenterController::class, 'callGetCurrentBalance'])->name('costCenter.callGetCurrentBalance');

});

//------- Accounts ------//
Route::group(['namespace' => 'Account', 'prefix' => 'account', 'auth'], function () {
  Route::get('index', [AccountController::class, 'index'])->name('account.index');
  Route::get('all', [AccountController::class, 'all'])->name('account.all');
  Route::post('store', [AccountController::class, 'store'])->name('account.store');
  Route::get('show/{id}', [AccountController::class, 'show'])->name('account.show');
  Route::post('update/{id}', [AccountController::class, 'update'])->name('account.update');
  Route::get('delete/{id}', [AccountController::class, 'delete'])->name('account.delete');
  Route::get('call-generate-codes/{id}', [AccountController::class, 'callGenerateCodes'])->name('account.callGenerateCodes');
  Route::get('call-auto-complete/{id}', [AccountController::class, 'callAutoComplete'])->name('account.callAutoComplete');
  Route::get('get-normals-in-assembly/{id}', [AccountController::class, 'getNormalsInAssembly'])->name('account.getNormalsInAssembly');
  Route::get('get-normals-in-distributive/{id}', [AccountController::class, 'getNormalsInDistributive'])->name('account.getNormalsInDistributive');
  Route::get('get-all-normals', [AccountController::class, 'getAllNormals'])->name('account.getAllNormals');
  Route::get('get-all-normals_With_Out_Clients', [AccountController::class, 'getAllNormalsWithOutClients'])->name('account.getAllNormalsWithOutClients');
  Route::get('get-all-finals', [AccountController::class, 'getAllFinals'])->name('account.getAllFinals');
  Route::get('get-all-leaf-normal', [AccountController::class, 'getAllLeafNormal'])->name('account.getAllLeafNormal');
  Route::get('get-all-leaf-final', [AccountController::class, 'getAllLeafFinal'])->name('account.getAllLeafFinal');
  Route::get('get-all-leaf-normal-with-distributive', [AccountController::class, 'getAllLeafNormalWithDistributive'])->name('account.getAllLeafNormalWithDistributive');
  Route::get('get-all-assembly', [AccountController::class, 'getAllAssembly'])->name('account.getAllAssembly');
  Route::get('get-all-normal-and-assembly', [AccountController::class, 'getAllNormalAndAssembly'])->name('account.getAllNormalAndAssembly');
  Route::get('is-use-account/{id}', [AccountController::class, 'isUseAccount'])->name('account.isUseAccount');
  Route::get('arabic-simple-chart', [AccountController::class, 'arabicSimpleChart'])->name('account.arabicSimpleChart');
  Route::get('english-simple-chart', [AccountController::class, 'englishSimpleChart'])->name('account.englishSimpleChart');
  Route::get('account-balance-info/{id}', [AccountController::class, 'accountBalanceInfo'])->name('account.accountBalanceInfo');
  Route::get('call-get-debit/{id}/{requiredCurrencyId}', [AccountController::class, 'callGetDebit'])->name('account.callGetDebit');
  Route::get('call-get-credit/{id}/{requiredCurrencyId}', [AccountController::class, 'callGetCredit'])->name('account.callGetCredit');
  Route::get('call-get-currentBalance/{id}/{requiredCurrencyId}', [AccountController::class, 'callGetCurrentBalance'])->name('account.callGetCurrentBalance');
  Route::get('initialize', [Controller::class, 'initialize'])->name('account.initialize');


//  Route::get('get-normal-account-finals/{id} ', [AccountController::class, 'getNormalFinalsName'])->name('account.getNormalAccountFinals');
//  Route::get('get-final-account-finals/{id} ', [AccountController::class, 'getFinalFinalsName'])->name('account.getFinalAccountsName');


});

//------- DefaultPrice ------//
Route::group(['namespace' => 'DefaultPrice', 'prefix' => 'defaultPrice', 'auth'], function () {
  Route::get('index', [DefaultPriceController::class, 'index'])->name('defaultPrice.index');
});

//------- Client ------//
Route::group(['namespace' => 'Client', 'prefix' => 'client', 'auth'], function () {
  Route::get('index', [ClientController::class, 'index'])->name('client.index');
  Route::post('store', [ClientController::class, 'store'])->name('client.store');
  Route::post('update/{id}', [ClientController::class, 'update'])->name('client.update');
  Route::get('delete/{accountId}', [ClientController::class, 'delete'])->name('client.delete');
  Route::get('show/{id}', [ClientController::class, 'show'])->name('client.show');
  Route::get('all', [ClientController::class, 'all'])->name('client.all');
  Route::get('is-use-client/{id}', [ClientController::class, 'isUseClient'])->name('client.isUseClient');

});

//------- VoucherTemplate ------//
Route::group(['namespace' => 'VoucherTemplate', 'prefix' => 'voucherTemplate', 'auth'], function () {
  Route::get('index', [VoucherTemplateController::class, 'index'])->name('voucherTemplate.index');
  Route::get('all', [VoucherTemplateController::class, 'all'])->name('voucherTemplate.all');
  Route::post('store', [VoucherTemplateController::class, 'store'])->name('voucherTemplate.store');
  Route::get('show/{id}', [VoucherTemplateController::class, 'show'])->name('voucherTemplate.show');
  Route::post('update/{id}', [VoucherTemplateController::class, 'update'])->name('voucherTemplate.update');
  Route::get('delete/{id}', [VoucherTemplateController::class, 'delete'])->name('voucherTemplate.delete');
  Route::get('nav-tree', [VoucherTemplateController::class, 'navTree'])->name('voucherTemplate.navTree');
  Route::get('is-use-voucher-template/{id}', [VoucherTemplateController::class, 'isUseVoucherTemplate'])->name('voucherTemplate.isUseVoucherTemplate');

});

//------- BillTemplate ------//
Route::group(['namespace' => 'BillTemplate', 'prefix' => 'billTemplate', 'auth'], function () {
  Route::get('index', [BillTemplateController::class, 'index'])->name('billTemplate.index');
  Route::get('all', [BillTemplateController::class, 'all'])->name('billTemplate.all');
  Route::post('store', [BillTemplateController::class, 'store'])->name('billTemplate.store');
  Route::get('show/{id}', [BillTemplateController::class, 'show'])->name('billTemplate.show');
  Route::post('update/{id}', [BillTemplateController::class, 'update'])->name('billTemplate.update');
  Route::get('delete/{id}', [BillTemplateController::class, 'delete'])->name('billTemplate.delete');
  Route::get('nav-tree', [BillTemplateController::class, 'navTree'])->name('billTemplate.navTree');
  Route::get('is-use-bill-template/{id}', [BillTemplateController::class, 'isUseBillTemplate'])->name('billTemplate.isUseBillTemplate');

});


//------- Asset Group ------//

Route::group(['namespace' => 'AssetGroup', 'prefix' => 'assetGroup'], function () {
  Route::get('index', [AssetGroupController::class, 'index'])->name('assetGroup.index');
  Route::post('store', [AssetGroupController::class, 'store'])->name('assetGroup.store');
  Route::get('show/{id}', [AssetGroupController::class, 'show'])->name('assetGroup.show');
  Route::post('update/{id}', [AssetGroupController::class, 'update'])->name('assetGroup.update');
  Route::get('delete/{id}', [AssetGroupController::class, 'delete'])->name('assetGroup.delete');
  Route::get('call-generate-codes/{id}', [AssetGroupController::class, 'callGenerateCodes'])->name('assetGroup.callGenerateCodes');
});


//------- Asset ------//

Route::group(['namespace' => 'Asset', 'prefix' => 'asset'], function () {
  Route::get('index', [AssetController::class, 'index'])->name('asset.index');
  Route::post('store', [AssetController::class, 'store'])->name('asset.store');
  Route::get('show/{id}', [AssetController::class, 'show'])->name('asset.show');
  Route::post('update/{id}', [AssetController::class, 'update'])->name('asset.update');
  Route::get('delete/{id}', [AssetController::class, 'delete'])->name('asset.delete');
  Route::get('call-generate-codes/{id}', [AssetController::class, 'callGenerateCodes'])->name('asset.callGenerateCodes');
});


//------- Setting ------//

Route::group(['namespace' => 'Setting', 'prefix' => 'setting'], function () {
  Route::post('store', [SettingController::class, 'store'])->name('setting.store');
  Route::post('update/{id}', [SettingController::class, 'update'])->name('setting.update');
  Route::get('show/{id}', [SettingController::class, 'show'])->name('setting.show');
  Route::get('delete/{id}', [SettingController::class, 'delete'])->name('setting.delete');

  // App Settings //
  Route::post('save_app_settings', [SettingController::class, 'saveAppSettings']);
  // Report Settings //
  Route::post('save_report_settings', [SettingController::class, 'saveReportSettings']);

});

Route::get('init', function () {
  event(new ItemsUpdated([1, 2, 3]));
});


//------- ReportTemplate ------//
Route::group(['namespace' => 'ReportTemplate', 'prefix' => 'reportTemplate', 'auth'], function () {
  Route::get('index', [ReportTemplateController::class, 'index'])->name('reportTemplate.index');
  Route::post('store', [ReportTemplateController::class, 'store'])->name('reportTemplate.store');
  Route::post('update/{id}', [ReportTemplateController::class, 'update'])->name('reportTemplate.update');
  Route::get('show/{id}', [ReportTemplateController::class, 'show'])->name('reportTemplate.show');
  Route::get('delete/{id}', [ReportTemplateController::class, 'delete'])->name('reportTemplate.delete');
  Route::post('save-image', [ReportTemplateController::class, 'saveImages']);
  Route::get('all', [ReportTemplateController::class, 'all'])->name('reportTemplate.all');

});

//------- DATABASE ------//
Route::group(['namespace' => 'Database', 'prefix' => 'database', 'auth'], function () {
  Route::get('create/{databaseName}', [DatabaseController::class, 'create']);
  Route::get('show', [DatabaseController::class, 'show']);
  Route::post('switchDatabase', [DatabaseController::class, 'switchDatabase']);
  Route::get('restore/{databaseName}', [DatabaseController::class, 'restore']);
//   Route::get('backup/{databaseName}', [DatabaseController::class, 'backup']);


  Route::get('run_migration', [DatabaseController::class, 'runMigration']);
  Route::get('run_migration_fresh_seed', [DatabaseController::class, 'runMigrationFreshSeed']);
  Route::get('run_migration_fresh', [DatabaseController::class, 'runMigrationFresh']);


  Route::get('backup_database', [DatabaseController::class, 'backupDatabase']);
   Route::get('get_current_database_information', [DatabaseController::class, 'getCurrentDatabaseInformation']);

Route::get('settings-database', [DatabaseController::class, 'settingsDatabase']);

});


//Route::get('get-name', [AccountController::class, 'getName'])->name('account.getName');


Route::post('save-images', [Controller::class, 'saveImages']);

Route::post('save-images', [Controller::class, 'saveImages']);


Route::post('upload-attachment', [Controller::class, 'uploadAttachmentss']);
Route::post('uploadManyAttachments', [Controller::class, 'uploadManyAttachments']);


Route::post('change-items-price', [ReportController::class, 'changeItemsPrice']);


Route::group(['namespace' => 'notifications', 'prefix' => 'notifications'], function () {
  Route::get('not-seen-notifications', [NotificationsController::class, 'notSeenNotifications'])->name('notSeenNotifications');

  Route::get('register-as-seen/{user_id}/{id}', [NotificationsController::class, 'registerAsSeen'])->name('registerAsSeen');
  Route::get('delete/{user_id}/{id}', [NotificationsController::class, 'delete'])->name('delete');

});
