<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\RmInMaterialController;
use App\Http\Controllers\RmStokController;
use App\Http\Controllers\RmInNutController;
use App\Http\Controllers\TraceAbilityController;
use App\Http\Controllers\TrackingProsesController;
use App\Http\Controllers\ScanReturnRmController;
use App\Http\Controllers\RmReturnController;
use App\Http\Controllers\ScanOutPcsController;
use App\Http\Controllers\RmMaterialController;
use App\Http\Controllers\PcStoreDashboard1Controller;
use App\Http\Controllers\ProsesQR1Controller;
use App\Http\Controllers\RmDnIncomingController;
use App\Http\Controllers\RmDashboardController;
use App\Http\Controllers\DataPartNameController;
use App\Http\Controllers\ScanRakSatuController;
use App\Http\Controllers\RmDashboardStokController;
use App\Http\Controllers\PlanningLineB3Controller;
use App\Http\Controllers\DashboardMpsController;
use App\Http\Controllers\DashboardPlanningC1;
use App\Http\Controllers\Dashbaord2Controller;
use App\Http\Controllers\StmpTagKanbanController;
use App\Http\Controllers\StmpKanbanFukuiController;
use App\Http\Controllers\StmpKanbanKomatsuController;
use App\Http\Controllers\StmpKanbanB1Controller;
use App\Http\Controllers\StmpKanbanB2Controller;
use App\Http\Controllers\StmpKanbanA1Controller;
use App\Http\Controllers\StmpKanbanA2Controller;
use App\Http\Controllers\StmpKanbanTransfersController;
use App\Http\Controllers\DashboardPlanningB12;
use App\Http\Controllers\DashboardPlanningA12;
use App\Http\Controllers\DashboardPlanningTransfer;
use App\Http\Controllers\LineStoreIndexController;
use App\Http\Controllers\LineStoreIndex2Controller;
use App\Http\Controllers\LineStoreIndex3Controller;
use App\Http\Controllers\TabelStokBlankController;
use App\Http\Controllers\LineStoreUploadController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\TraceProses2Controller;
use App\Http\Controllers\TagLabelBlankController;
use App\Http\Controllers\DataFgStampingController;
use App\Http\Controllers\StmpKanbanC1Controller;
use App\Http\Controllers\PcStoreStok1Controller;
use App\Http\Controllers\ScanBpsPartController;
use App\Http\Controllers\TagLabel2Controller;
use App\Http\Controllers\TagLabel3Controller;
use App\Http\Controllers\StmpKanbanC2Controller;
use App\Http\Controllers\ScanRakTujuhBelasController;
use App\Http\Controllers\ScanRakSepuluhController;
use App\Http\Controllers\DataBlankController;
use App\Http\Controllers\ScanInStmpController;
use App\Http\Controllers\ScanInBlankController;
use App\Http\Controllers\UploadRekapController;
use App\Http\Controllers\UploadRekapAdmController;
use App\Http\Controllers\UploadRekapAdmP4Controller;
use App\Http\Controllers\DashbaordBoard26Controller;
use App\Http\Controllers\DashbaordBoard26AdmController;
use App\Http\Controllers\DashbaordBoard26Adm2Controller;
use App\Http\Controllers\DashboardPlanningBlank;
use App\Http\Controllers\Dashboard1LsController;
use App\Http\Controllers\ScanRak15OutController;
use App\Http\Controllers\ScanRakLimaBelasController;
use App\Http\Controllers\Listrekapd26Controller;
use App\Http\Controllers\LineWeldingController;
use App\Http\Controllers\TagLabelWeldingController;
use App\Http\Controllers\TagLabelSubcontController;
use App\Http\Controllers\DshStokD26TmminController;
use App\Http\Controllers\DshStokD26AdmController;
use App\Http\Controllers\ScanOutBlankController;
use App\Http\Controllers\DashboardWelding1Controller;
use App\Http\Controllers\DashboardBlank2Controller;
use App\Http\Controllers\Listrekapd26AdmController;
use App\Http\Controllers\TabelStokSbcController;
use App\Http\Controllers\ScanInStmpB12Controller;
use App\Http\Controllers\ScanInStmpA12Controller;
use App\Http\Controllers\ScanInStmpTransfersController;
use App\Http\Controllers\ListrekapdAdmP4Controller;
use App\Http\Controllers\DashbaordBoardAdmP4Controller;
use App\Http\Controllers\DshStokAdmP4Controller;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\UploadForcastController;
use App\Http\Controllers\TabelPrevDiesController;
use App\Http\Controllers\Andon2DieMtcController;
use App\Http\Controllers\LkhDiesMtcController;
use App\Http\Controllers\DashboardSummaryDiesController;
use App\Http\Controllers\ScanInPsWelding2Controller;
use App\Http\Controllers\TabelDataBomController;
use App\Http\Controllers\MpsPlanningController;
use App\Http\Controllers\StrOut1Controller;
use App\Http\Controllers\StrOut2Controller;
use App\Http\Controllers\StrOut3Controller;
use App\Http\Controllers\StrOut4Controller;
use App\Http\Controllers\StrOut5Controller;
use App\Http\Controllers\StrOut6Controller;
use App\Http\Controllers\StrOut7Controller;
use App\Http\Controllers\StrOut8Controller;
use App\Http\Controllers\StrOut9Controller;
use App\Http\Controllers\StrOut10Controller;
use App\Http\Controllers\StrOut11Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home.index');
// });
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'LoginController@login')->name('login');
    Route::post('/login', 'LoginController@authenticate')->name('login.post');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/check-line-statuses', [PcStoreDashboard1Controller::class, 'checkLineStatuses'])->name('check.line.statuses');
    Route::get('/machine/detail', [PcStoreDashboard1Controller::class, 'getMachineDetail'])->name('machine.detail');
    Route::get('/dashboard1/data', 'PcStoreDashboard1Controller@getData')->name('dashboard1.data');



    // Route::get('/store', 'DashboardStoreRoomController@index')->name('store');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('/list', 'UserController@list')->name('user.list');
        Route::post('/create', 'UserController@store')->name('user.store');
        Route::get('/edit', 'UserController@edit')->name('user.edit');
        Route::post('/update', 'UserController@update')->name('user.update');
        Route::post('/delete', 'UserController@destroy')->name('user.destroy');
        Route::post('/updatepwd', 'UserController@updatepwd')->name('user.updatepwd');
    });

    Route::group(['prefix' => 'logactivity'], function () {
        Route::get('/', [LogActivityController::class, 'index'])->name('logactivity.index');
        Route::get('/data', [LogActivityController::class, 'data'])->name('logactivity.data');
    });


    Route::group(['prefix' => 'databom'], function () {
        Route::get('/', 'TabelDataBomController@index')->name('databom.index');
        Route::get('/list', 'TabelDataBomController@list')->name('databom.list');
        Route::get('/list3', 'TabelDataBomController@list3')->name('databom.list3');
        Route::get('/listdetail', 'TabelDataBomController@listdetail')->name('databom.listdetail');
        Route::post('/create', 'TabelDataBomController@store')->name('databom.store');
        Route::get('/edit', 'TabelDataBomController@edit')->name('databom.edit');
        Route::post('/delete', 'TabelDataBomController@destroy')->name('databom.destroy');
        Route::post('/deleteline', 'TabelDataBomController@destroyline')->name('databom.destroyline');
        Route::post('/update', 'TabelDataBomController@update')->name('databom.update');
        Route::get('/export', 'TabelDataBomController@export')->name('databom.export');
        Route::get('/export-template', 'TabelDataBomController@exportTemplate')->name('databom.exportTemplate');
        Route::post('/submit', 'TabelDataBomController@submit')->name('databom.submit');
        Route::post('/import-Dp', [TabelDataBomController::class, 'importDp'])->name('databom.importDp');
    });


    Route::group(['prefix' => 'line'], function () {
        Route::get('/', 'LineStampingController@index')->name('line.index');
        Route::get('/list', 'LineStampingController@list')->name('line.list');
        Route::post('/create', 'LineStampingController@store')->name('line.store');
        Route::get('/edit', 'LineStampingController@edit')->name('line.edit');
        Route::post('/update', 'LineStampingController@update')->name('line.update');
        Route::post('/delete', 'LineStampingController@destroy')->name('line.destroy');
    });

    Route::group(['prefix' => 'kanbanstmp'], function () {
        Route::get('/', 'StmpTagKanbanController@index')->name('kanbanstmp.index');
        Route::get('/list', 'StmpTagKanbanController@list')->name('kanbanstmp.list');
        Route::get('/listdetail', 'StmpTagKanbanController@listdetail')->name('kanbanstmp.listdetail');
        Route::post('/create', 'StmpTagKanbanController@store')->name('kanbanstmp.store');
        Route::get('/edit', 'StmpTagKanbanController@edit')->name('kanbanstmp.edit');
        Route::post('/delete', 'StmpTagKanbanController@destroy')->name('kanbanstmp.destroy');
        Route::post('/deleteline', 'StmpTagKanbanController@destroyline')->name('kanbanstmp.destroyline');
        Route::post('/update', 'StmpTagKanbanController@update')->name('kanbanstmp.update');
        Route::get('/export', 'StmpTagKanbanController@export')->name('kanbanstmp.export');
        Route::post('/submit', 'StmpTagKanbanController@submit')->name('kanbanstmp.submit');
        Route::post('/delete_draft', 'StmpTagKanbanController@delete_draft')->name('kanbanstmp.delete_draft');
        Route::get('/getdoc', 'StmpTagKanbanController@getdoc')->name('kanbanstmp.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpTagKanbanController@cetak')->name('kanbanstmp.cetak');
        Route::post('/taglabel2/generateMultipleQrCodes', [StmpTagKanbanController::class, 'generateMultipleQrCodes'])->name('kanbanstmp.generateMultipleQrCodes');
        Route::get('/kanbanstmp/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpTagKanbanController@getDropdownData')->name('kanbanstmp.data');
        Route::get('/dropdown-data2', 'StmpTagKanbanController@getDropdownData2')->name('kanbanstmp.data2');
        Route::post('/get-qty-stamping', 'StmpTagKanbanController@getQtyStamping')->name('kanbanstmp.getQtyStamping');
        Route::post('/total-qty', 'StmpTagKanbanController@sumQty')->name('kanbanstmp.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpTagKanbanController@getUniqNosByMachine')->name('kanbanstmp.getUniqNosByMachine');
        Route::post('/sisa-qty', 'StmpTagKanbanController@SisaQty')->name('kanbanstmp.SisaQty');
        Route::get('/get-uniq-nos', 'StmpTagKanbanController@getPartNos')->name('kanbanstmp.getPartNos');

        // Route::get('/kanbanstmp/partnos', [YourController::class, 'getPartNos'])->name('kanbanstmp.partnos');


        //         Route::get('/get-part-numbers', [YourController::class, 'getPartNumbers'])->name('get.part.numbers');
// Route::get('/get-uniq-no', [YourController::class, 'getUniqNumbers'])->name('get.uniq.numbers');

        // Route::post('/stamping/add-qty', 'StmpTagKanbanController@addQtyStamping')->name('kanbanstmp.addQtyStamping');
        // Route::post('/stamping/add-qty', [StmpTagKanbanController::class, 'addQtyStamping']);
        // Route::get('/get-uniq-nos', [StmpTagKanbanController::class, 'getUniqNos'])->name('kanbanstmp.getUniqNos');
        // Route::get('/get-uniq-nos-by-machine', [StmpTagKanbanController::class, 'getUniqNosByMachine'])->name('kanbanstmp.getUniqNosByMachine');
        // Route::get('/dropdown-data', 'StmpTagKanbanController@getDropdownData')->name('kanbanstmp.data');

        //         Route::get('/kanbanstmp/data2', [YourController::class, 'getDropdownData'])->name('kanbanstmp.data2');
// Route::get('/kanbanstmp/part_list', [YourController::class, 'getPartList'])->name('kanbanstmp.part_list');

        // In your web.php routes file



        // Route::post('/sum-qty', [StmpTagKanbanController::class, 'sumQty']);




        // Route::post('/get-qty-stamping', [YourController::class, 'getQtyStamping'])->name('get.qty.stamping');

        // Route::get('/dropdown-data', [StmpTagKanbanController::class, 'getDropdownData'])->name('kanbanstmp.data');

    });


    Route::group(['prefix' => 'kanbanstmpc1'], function () {
        Route::get('/', 'StmpKanbanC1Controller@index')->name('kanbanstmpc1.index');
        Route::get('/list', 'StmpKanbanC1Controller@list')->name('kanbanstmpc1.list');
        Route::get('/listdetail', 'StmpKanbanC1Controller@listdetail')->name('kanbanstmpc1.listdetail');
        Route::post('/create', 'StmpKanbanC1Controller@store')->name('kanbanstmpc1.store');
        Route::get('/edit', 'StmpKanbanC1Controller@edit')->name('kanbanstmpc1.edit');
        Route::post('/delete', 'StmpKanbanC1Controller@destroy')->name('kanbanstmpc1.destroy');
        Route::post('/deleteline', 'StmpKanbanC1Controller@destroyline')->name('kanbanstmpc1.destroyline');
        Route::post('/update', 'StmpKanbanC1Controller@update')->name('kanbanstmpc1.update');
        Route::get('/export', 'StmpKanbanC1Controller@export')->name('kanbanstmpc1.export');
        Route::post('/submit', 'StmpKanbanC1Controller@submit')->name('kanbanstmpc1.submit');
        Route::post('/delete_draft', 'StmpKanbanC1Controller@delete_draft')->name('kanbanstmpc1.delete_draft');
        Route::get('/getdoc', 'StmpKanbanC1Controller@getdoc')->name('kanbanstmpc1.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanC1Controller@cetak')->name('kanbanstmpc1.cetak');
        Route::get('/kanbanstmpc1/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanC1Controller@getDropdownData')->name('kanbanstmpc1.data');
        Route::get('/dropdown-data2', 'StmpKanbanC1Controller@getDropdownData2')->name('kanbanstmpc1.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanC1Controller@getQtyStamping')->name('kanbanstmpc1.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanC1Controller@sumQty')->name('kanbanstmpc1.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanC1Controller@getUniqNosByMachine')->name('kanbanstmpc1.getUniqNosByMachine');
        Route::get('/get-uniq-nos', 'StmpKanbanC1Controller@getPartNos')->name('kanbanstmpc1.getPartNos');

        // Route::get('/kanbanstmpc1/data2', [StmpKanbanC1Controller::class, 'getData'])->name('kanbanstmpc1.data2');
        // Route::post('/kanbanstmpc1/sumQty', [StmpKanbanC1Controller::class, 'sumQty'])->name('kanbanstmpc1.sumQty');
    });

    Route::group(['prefix' => 'kanbanstmpc2'], function () {
        Route::get('/', 'StmpKanbanC2Controller@index')->name('kanbanstmpc2.index');
        Route::get('/list', 'StmpKanbanC2Controller@list')->name('kanbanstmpc2.list');
        Route::get('/listdetail', 'StmpKanbanC2Controller@listdetail')->name('kanbanstmpc2.listdetail');
        Route::post('/create', 'StmpKanbanC2Controller@store')->name('kanbanstmpc2.store');
        Route::get('/edit', 'StmpKanbanC2Controller@edit')->name('kanbanstmpc2.edit');
        Route::post('/delete', 'StmpKanbanC2Controller@destroy')->name('kanbanstmpc2.destroy');
        Route::post('/deleteline', 'StmpKanbanC2Controller@destroyline')->name('kanbanstmpc2.destroyline');
        Route::post('/update', 'StmpKanbanC2Controller@update')->name('kanbanstmpc2.update');
        Route::get('/export', 'StmpKanbanC2Controller@export')->name('kanbanstmpc2.export');
        Route::post('/submit', 'StmpKanbanC2Controller@submit')->name('kanbanstmpc2.submit');
        Route::post('/delete_draft', 'StmpKanbanC2Controller@delete_draft')->name('kanbanstmpc2.delete_draft');
        Route::get('/getdoc', 'StmpKanbanC2Controller@getdoc')->name('kanbanstmpc2.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanC2Controller@cetak')->name('kanbanstmpc2.cetak');
        Route::get('/kanbanstmpc2/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanC2Controller@getDropdownData')->name('kanbanstmpc2.data');
        Route::get('/dropdown-data2', 'StmpKanbanC2Controller@getDropdownData2')->name('kanbanstmpc2.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanC2Controller@getQtyStamping')->name('kanbanstmpc2.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanC2Controller@sumQty')->name('kanbanstmpc2.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanC2Controller@getUniqNosByMachine')->name('kanbanstmpc2.getUniqNosByMachine');
        Route::get('/get-uniq-nos', 'StmpKanbanC2Controller@getPartNos')->name('kanbanstmpc2.getPartNos');
        Route::get('/form-planning', [StmpKanbanC2Controller::class, 'getDataStamping'])->name('getDataStamping.planning');
    });

    Route::group(['prefix' => 'kanbanstmpb1'], function () {
        Route::get('/', 'StmpKanbanB1Controller@index')->name('kanbanstmpb1.index');
        Route::get('/list', 'StmpKanbanB1Controller@list')->name('kanbanstmpb1.list');
        Route::get('/listdetail', 'StmpKanbanB1Controller@listdetail')->name('kanbanstmpb1.listdetail');
        Route::post('/create', 'StmpKanbanB1Controller@store')->name('kanbanstmpb1.store');
        Route::get('/edit', 'StmpKanbanB1Controller@edit')->name('kanbanstmpb1.edit');
        Route::post('/delete', 'StmpKanbanB1Controller@destroy')->name('kanbanstmpb1.destroy');
        Route::post('/deleteline', 'StmpKanbanB1Controller@destroyline')->name('kanbanstmpb1.destroyline');
        Route::post('/update', 'StmpKanbanB1Controller@update')->name('kanbanstmpb1.update');
        Route::get('/export', 'StmpKanbanB1Controller@export')->name('kanbanstmpb1.export');
        Route::post('/submit', 'StmpKanbanB1Controller@submit')->name('kanbanstmpb1.submit');
        Route::post('/delete_draft', 'StmpKanbanB1Controller@delete_draft')->name('kanbanstmpb1.delete_draft');
        Route::get('/getdoc', 'StmpKanbanB1Controller@getdoc')->name('kanbanstmpb1.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanB1Controller@cetak')->name('kanbanstmpb1.cetak');
        Route::post('/taglabel2/generateMultipleQrCodes', [StmpKanbanB1Controller::class, 'generateMultipleQrCodes'])->name('kanbanstmpb1.generateMultipleQrCodes');
        Route::get('/kanbanstmpb1/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanB1Controller@getDropdownData')->name('kanbanstmpb1.data');
        Route::get('/dropdown-data2', 'StmpKanbanB1Controller@getDropdownData2')->name('kanbanstmpb1.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanB1Controller@getQtyStamping')->name('kanbanstmpb1.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanB1Controller@sumQty')->name('kanbanstmpb1.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanB1Controller@getUniqNosByMachine')->name('kanbanstmpb1.getUniqNosByMachine');
        Route::post('/sisa-qty', 'StmpKanbanB1Controller@SisaQty')->name('kanbanstmpb1.SisaQty');
        Route::get('/get-uniq-nos', 'StmpKanbanB1Controller@getPartNos')->name('kanbanstmpb1.getPartNos');
    });

    Route::group(['prefix' => 'kanbanstmpb2'], function () {
        Route::get('/', 'StmpKanbanB2Controller@index')->name('kanbanstmpb2.index');
        Route::get('/list', 'StmpKanbanB2Controller@list')->name('kanbanstmpb2.list');
        Route::get('/listdetail', 'StmpKanbanB2Controller@listdetail')->name('kanbanstmpb2.listdetail');
        Route::post('/create', 'StmpKanbanB2Controller@store')->name('kanbanstmpb2.store');
        Route::get('/edit', 'StmpKanbanB2Controller@edit')->name('kanbanstmpb2.edit');
        Route::post('/delete', 'StmpKanbanB2Controller@destroy')->name('kanbanstmpb2.destroy');
        Route::post('/deleteline', 'StmpKanbanB2Controller@destroyline')->name('kanbanstmpb2.destroyline');
        Route::post('/update', 'StmpKanbanB2Controller@update')->name('kanbanstmpb2.update');
        Route::get('/export', 'StmpKanbanB2Controller@export')->name('kanbanstmpb2.export');
        Route::post('/submit', 'StmpKanbanB2Controller@submit')->name('kanbanstmpb2.submit');
        Route::post('/delete_draft', 'StmpKanbanB2Controller@delete_draft')->name('kanbanstmpb2.delete_draft');
        Route::get('/getdoc', 'StmpKanbanB2Controller@getdoc')->name('kanbanstmpb2.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanB2Controller@cetak')->name('kanbanstmpb2.cetak');
        Route::post('/taglabel2/generateMultipleQrCodes', [StmpKanbanB2Controller::class, 'generateMultipleQrCodes'])->name('kanbanstmpb2.generateMultipleQrCodes');
        Route::get('/kanbanstmpb2/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanB2Controller@getDropdownData')->name('kanbanstmpb2.data');
        Route::get('/dropdown-data2', 'StmpKanbanB2Controller@getDropdownData2')->name('kanbanstmpb2.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanB2Controller@getQtyStamping')->name('kanbanstmpb2.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanB2Controller@sumQty')->name('kanbanstmpb2.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanB2Controller@getUniqNosByMachine')->name('kanbanstmpb2.getUniqNosByMachine');
        Route::post('/sisa-qty', 'StmpKanbanB2Controller@SisaQty')->name('kanbanstmpb2.SisaQty');
        Route::get('/get-uniq-nos', 'StmpKanbanB2Controller@getPartNos')->name('kanbanstmpb2.getPartNos');
    });

    Route::group(['prefix' => 'kanbanstmpa1'], function () {
        Route::get('/', 'StmpKanbanA1Controller@index')->name('kanbanstmpa1.index');
        Route::get('/list', 'StmpKanbanA1Controller@list')->name('kanbanstmpa1.list');
        Route::get('/listdetail', 'StmpKanbanA1Controller@listdetail')->name('kanbanstmpa1.listdetail');
        Route::post('/create', 'StmpKanbanA1Controller@store')->name('kanbanstmpa1.store');
        Route::get('/edit', 'StmpKanbanA1Controller@edit')->name('kanbanstmpa1.edit');
        Route::post('/delete', 'StmpKanbanA1Controller@destroy')->name('kanbanstmpa1.destroy');
        Route::post('/deleteline', 'StmpKanbanA1Controller@destroyline')->name('kanbanstmpa1.destroyline');
        Route::post('/update', 'StmpKanbanA1Controller@update')->name('kanbanstmpa1.update');
        Route::get('/export', 'StmpKanbanA1Controller@export')->name('kanbanstmpa1.export');
        Route::post('/submit', 'StmpKanbanA1Controller@submit')->name('kanbanstmpa1.submit');
        Route::post('/delete_draft', 'StmpKanbanA1Controller@delete_draft')->name('kanbanstmpa1.delete_draft');
        Route::get('/getdoc', 'StmpKanbanA1Controller@getdoc')->name('kanbanstmpa1.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanA1Controller@cetak')->name('kanbanstmpa1.cetak');
        Route::post('/taglabel2/generateMultipleQrCodes', [StmpKanbanA1Controller::class, 'generateMultipleQrCodes'])->name('kanbanstmpa1.generateMultipleQrCodes');
        Route::get('/kanbanstmpa1/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanA1Controller@getDropdownData')->name('kanbanstmpa1.data');
        Route::get('/dropdown-data2', 'StmpKanbanA1Controller@getDropdownData2')->name('kanbanstmpa1.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanA1Controller@getQtyStamping')->name('kanbanstmpa1.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanA1Controller@sumQty')->name('kanbanstmpa1.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanA1Controller@getUniqNosByMachine')->name('kanbanstmpa1.getUniqNosByMachine');
        Route::post('/sisa-qty', 'StmpKanbanA1Controller@SisaQty')->name('kanbanstmpa1.SisaQty');
        Route::get('/get-uniq-nos', 'StmpKanbanA1Controller@getPartNos')->name('kanbanstmpa1.getPartNos');
    });

    Route::group(['prefix' => 'kanbanstmpa2'], function () {
        Route::get('/', 'StmpKanbanA2Controller@index')->name('kanbanstmpa2.index');
        Route::get('/list', 'StmpKanbanA2Controller@list')->name('kanbanstmpa2.list');
        Route::get('/listdetail', 'StmpKanbanA2Controller@listdetail')->name('kanbanstmpa2.listdetail');
        Route::post('/create', 'StmpKanbanA2Controller@store')->name('kanbanstmpa2.store');
        Route::get('/edit', 'StmpKanbanA2Controller@edit')->name('kanbanstmpa2.edit');
        Route::post('/delete', 'StmpKanbanA2Controller@destroy')->name('kanbanstmpa2.destroy');
        Route::post('/deleteline', 'StmpKanbanA2Controller@destroyline')->name('kanbanstmpa2.destroyline');
        Route::post('/update', 'StmpKanbanA2Controller@update')->name('kanbanstmpa2.update');
        Route::get('/export', 'StmpKanbanA2Controller@export')->name('kanbanstmpa2.export');
        Route::post('/submit', 'StmpKanbanA2Controller@submit')->name('kanbanstmpa2.submit');
        Route::post('/delete_draft', 'StmpKanbanA2Controller@delete_draft')->name('kanbanstmpa2.delete_draft');
        Route::get('/getdoc', 'StmpKanbanA2Controller@getdoc')->name('kanbanstmpa2.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanA2Controller@cetak')->name('kanbanstmpa2.cetak');
        Route::post('/taglabel2/generateMultipleQrCodes', [StmpKanbanA2Controller::class, 'generateMultipleQrCodes'])->name('kanbanstmpa2.generateMultipleQrCodes');
        Route::get('/kanbanstmpa2/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanA2Controller@getDropdownData')->name('kanbanstmpa2.data');
        Route::get('/dropdown-data2', 'StmpKanbanA2Controller@getDropdownData2')->name('kanbanstmpa2.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanA2Controller@getQtyStamping')->name('kanbanstmpa2.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanA2Controller@sumQty')->name('kanbanstmpa2.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanA2Controller@getUniqNosByMachine')->name('kanbanstmpa2.getUniqNosByMachine');
        Route::post('/sisa-qty', 'StmpKanbanA2Controller@SisaQty')->name('kanbanstmpa2.SisaQty');
        Route::get('/get-uniq-nos', 'StmpKanbanA2Controller@getPartNos')->name('kanbanstmpa2.getPartNos');
    });

    Route::group(['prefix' => 'kanbanstmptransfers'], function () {
        Route::get('/', 'StmpKanbanTransfersController@index')->name('kanbanstmptransfers.index');
        Route::get('/list', 'StmpKanbanTransfersController@list')->name('kanbanstmptransfers.list');
        Route::get('/listdetail', 'StmpKanbanTransfersController@listdetail')->name('kanbanstmptransfers.listdetail');
        Route::post('/create', 'StmpKanbanTransfersController@store')->name('kanbanstmptransfers.store');
        Route::get('/edit', 'StmpKanbanTransfersController@edit')->name('kanbanstmptransfers.edit');
        Route::post('/delete', 'StmpKanbanTransfersController@destroy')->name('kanbanstmptransfers.destroy');
        Route::post('/deleteline', 'StmpKanbanTransfersController@destroyline')->name('kanbanstmptransfers.destroyline');
        Route::post('/update', 'StmpKanbanTransfersController@update')->name('kanbanstmptransfers.update');
        Route::get('/export', 'StmpKanbanTransfersController@export')->name('kanbanstmptransfers.export');
        Route::post('/submit', 'StmpKanbanTransfersController@submit')->name('kanbanstmptransfers.submit');
        Route::post('/delete_draft', 'StmpKanbanTransfersController@delete_draft')->name('kanbanstmptransfers.delete_draft');
        Route::get('/getdoc', 'StmpKanbanTransfersController@getdoc')->name('kanbanstmptransfers.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanTransfersController@cetak')->name('kanbanstmptransfers.cetak');
        Route::post('/taglabel2/generateMultipleQrCodes', [StmpKanbanTransfersController::class, 'generateMultipleQrCodes'])->name('kanbanstmptransfers.generateMultipleQrCodes');
        Route::get('/kanbanstmptransfers/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanTransfersController@getDropdownData')->name('kanbanstmptransfers.data');
        Route::get('/dropdown-data2', 'StmpKanbanTransfersController@getDropdownData2')->name('kanbanstmptransfers.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanTransfersController@getQtyStamping')->name('kanbanstmptransfers.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanTransfersController@sumQty')->name('kanbanstmptransfers.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanTransfersController@getUniqNosByMachine')->name('kanbanstmptransfers.getUniqNosByMachine');
        Route::post('/sisa-qty', 'StmpKanbanTransfersController@SisaQty')->name('kanbanstmptransfers.SisaQty');
        Route::get('/get-uniq-nos', 'StmpKanbanTransfersController@getPartNos')->name('kanbanstmptransfers.getPartNos');
    });

    Route::group(['prefix' => 'kanbanstmpkomatsu'], function () {
        Route::get('/', 'StmpKanbanKomatsuController@index')->name('kanbanstmpkomatsu.index');
        Route::get('/list', 'StmpKanbanKomatsuController@list')->name('kanbanstmpkomatsu.list');
        Route::get('/listdetail', 'StmpKanbanKomatsuController@listdetail')->name('kanbanstmpkomatsu.listdetail');
        Route::post('/create', 'StmpKanbanKomatsuController@store')->name('kanbanstmpkomatsu.store');
        Route::get('/edit', 'StmpKanbanKomatsuController@edit')->name('kanbanstmpkomatsu.edit');
        Route::post('/delete', 'StmpKanbanKomatsuController@destroy')->name('kanbanstmpkomatsu.destroy');
        Route::post('/deleteline', 'StmpKanbanKomatsuController@destroyline')->name('kanbanstmpkomatsu.destroyline');
        Route::post('/update', 'StmpKanbanKomatsuController@update')->name('kanbanstmpkomatsu.update');
        Route::get('/export', 'StmpKanbanKomatsuController@export')->name('kanbanstmpkomatsu.export');
        Route::post('/submit', 'StmpKanbanKomatsuController@submit')->name('kanbanstmpkomatsu.submit');
        Route::post('/delete_draft', 'StmpKanbanKomatsuController@delete_draft')->name('kanbanstmpkomatsu.delete_draft');
        Route::get('/getdoc', 'StmpKanbanKomatsuController@getdoc')->name('kanbanstmpkomatsu.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanKomatsuController@cetak')->name('kanbanstmpkomatsu.cetak');
        Route::post('/taglabel2/generateMultipleQrCodes', [StmpKanbanKomatsuController::class, 'generateMultipleQrCodes'])->name('kanbanstmpkomatsu.generateMultipleQrCodes2');
        Route::get('/kanbanstmpkomatsu/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanKomatsuController@getDropdownData')->name('kanbanstmpkomatsu.data');
        Route::get('/dropdown-data2', 'StmpKanbanKomatsuController@getDropdownData2')->name('kanbanstmpkomatsu.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanKomatsuController@getQtyStamping')->name('kanbanstmpkomatsu.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanKomatsuController@sumQty')->name('kanbanstmpkomatsu.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanKomatsuController@getUniqNosByMachine')->name('kanbanstmpkomatsu.getUniqNosByMachine');
        Route::post('/sisa-qty', 'StmpKanbanKomatsuController@SisaQty')->name('kanbanstmpkomatsu.SisaQty');
        Route::get('/get-uniq-nos', 'StmpKanbanKomatsuController@getPartNos')->name('kanbanstmpkomatsu.getPartNos');
    });

    Route::group(['prefix' => 'kanbanstmpfukui'], function () {
        Route::get('/', 'StmpKanbanFukuiController@index')->name('kanbanstmpfukui.index');
        Route::get('/list', 'StmpKanbanFukuiController@list')->name('kanbanstmpfukui.list');
        Route::get('/listdetail', 'StmpKanbanFukuiController@listdetail')->name('kanbanstmpfukui.listdetail');
        Route::post('/create', 'StmpKanbanFukuiController@store')->name('kanbanstmpfukui.store');
        Route::get('/edit', 'StmpKanbanFukuiController@edit')->name('kanbanstmpfukui.edit');
        Route::post('/delete', 'StmpKanbanFukuiController@destroy')->name('kanbanstmpfukui.destroy');
        Route::post('/deleteline', 'StmpKanbanFukuiController@destroyline')->name('kanbanstmpfukui.destroyline');
        Route::post('/update', 'StmpKanbanFukuiController@update')->name('kanbanstmpfukui.update');
        Route::get('/export', 'StmpKanbanFukuiController@export')->name('kanbanstmpfukui.export');
        Route::post('/submit', 'StmpKanbanFukuiController@submit')->name('kanbanstmpfukui.submit');
        Route::post('/delete_draft', 'StmpKanbanFukuiController@delete_draft')->name('kanbanstmpfukui.delete_draft');
        Route::get('/getdoc', 'StmpKanbanFukuiController@getdoc')->name('kanbanstmpfukui.getdoc');
        Route::get('/rmmaterial/cetak/{id}', 'StmpKanbanFukuiController@cetak')->name('kanbanstmpfukui.cetak');
        Route::post('/taglabel2/generateMultipleQrCodes', [StmpKanbanFukuiController::class, 'generateMultipleQrCodes'])->name('kanbanstmpfukui.generateMultipleQrCodes2');
        Route::get('/kanbanstmpkomatsu/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::get('/dropdown-data', 'StmpKanbanFukuiController@getDropdownData')->name('kanbanstmpfukui.data');
        Route::get('/dropdown-data2', 'StmpKanbanFukuiController@getDropdownData2')->name('kanbanstmpfukui.data2');
        Route::post('/get-qty-stamping', 'StmpKanbanFukuiController@getQtyStamping')->name('kanbanstmpfukui.getQtyStamping');
        Route::post('/total-qty', 'StmpKanbanFukuiController@sumQty')->name('kanbanstmpfukui.totalQtyKm');
        Route::get('/get-uniq-nos', 'StmpKanbanFukuiController@getUniqNosByMachine')->name('kanbanstmpfukui.getUniqNosByMachine');
        Route::post('/sisa-qty', 'StmpKanbanFukuiController@SisaQty')->name('kanbanstmpfukui.SisaQty');
        Route::get('/get-uniq-nos', 'StmpKanbanFukuiController@getPartNos')->name('kanbanstmpfukui.getPartNos');
    });


    Route::group(['prefix' => 'welding'], function () {
        Route::get('/', 'LineWeldingController@index')->name('welding.index');
        Route::get('/list', 'LineWeldingController@list')->name('welding.list');
        Route::post('/create', 'LineWeldingController@store')->name('welding.store');
        Route::get('/edit', 'LineWeldingController@edit')->name('welding.edit');
        Route::post('/update', 'LineWeldingController@update')->name('welding.update');
        Route::post('/delete', 'LineWeldingController@destroy')->name('welding.destroy');
        Route::post('/import-Dp', [LineWeldingController::class, 'importDp'])->name('welding.importDp');
        Route::get('users/export', 'LineWeldingController@export')->name('format.export');
        Route::get('users/export2', 'LineWeldingController@export2')->name('dataWelding.export');
    });
    Route::group(['prefix' => 'dataFg'], function () {
        Route::get('/', 'DataFgStampingController@index')->name('datafg.index');
        Route::get('/list', 'DataFgStampingController@list')->name('datafg.list');
        Route::post('/create', 'DataFgStampingController@store')->name('datafg.store');
        Route::get('/edit', 'DataFgStampingController@edit')->name('datafg.edit');
        Route::post('/update', 'DataFgStampingController@update')->name('datafg.update');
        Route::post('/delete', 'DataFgStampingController@destroy')->name('datafg.destroy');
        Route::post('/import-Dp', [DataFgStampingController::class, 'importDp'])->name('datafg.importDp');
        Route::get('users/export', 'DataFgStampingController@export')->name('datafg.export');

    });
    Route::group(['prefix' => 'datablank'], function () {
        Route::get('/', 'DataBlankController@index')->name('datablank.index');
        Route::get('/list', 'DataBlankController@list')->name('datablank.list');
        Route::post('/create', 'DataBlankController@store')->name('datablank.store');
        Route::get('/edit', 'DataBlankController@edit')->name('datablank.edit');
        Route::post('/update', 'DataBlankController@update')->name('datablank.update');
        Route::post('/delete', 'DataBlankController@destroy')->name('datablank.destroy');
        Route::post('/import-Dp', [DataBlankController::class, 'importDp'])->name('datablank.importDp');
    });
    Route::group(['prefix' => 'partname'], function () {
        Route::get('/', 'DataPartNameController@index')->name('partname.index');
        Route::get('/list', 'DataPartNameController@list')->name('partname.list');
        Route::post('/create', 'DataPartNameController@store')->name('partname.store');
        Route::get('/edit', 'DataPartNameController@edit')->name('partname.edit');
        Route::post('/update', 'DataPartNameController@update')->name('partname.update');
        Route::post('/delete', 'DataPartNameController@destroy')->name('partname.destroy');
        Route::get('users/export', 'DataPartNameController@export')->name('partname.export');
        // Route::get('/import-dn', 'DataPartNameController@importDn')->name('partname.importDn');
        // Route::get('/partname/exportFiltered', [DataPartNameController::class, 'exportFiltered'])->name('partname.exportFiltered');

        Route::post('/import-Dp', [DataPartNameController::class, 'importDp'])->name('partname.importDp');
        // Route::get('users/export/', [UsersController::class, 'export']);
    });
    Route::group(['prefix' => 'costumer'], function () {
        Route::get('/', 'DataCostumerController@index')->name('costumer.index');
        Route::get('/list', 'DataCostumerController@list')->name('costumer.list');
        Route::post('/create', 'DataCostumerController@store')->name('costumer.store');
        Route::get('/edit', 'DataCostumerController@edit')->name('costumer.edit');
        Route::post('/update', 'DataCostumerController@update')->name('costumer.update');
        Route::post('/delete', 'DataCostumerController@destroy')->name('costumer.destroy');
    });
    Route::group(['prefix' => 'tabelb3'], function () {
        Route::get('/', 'TabelB3Controller@index')->name('tabelb3.index');
        Route::get('/list', 'TabelB3Controller@list')->name('tabelb3.list');
        Route::post('/create', 'TabelB3Controller@store')->name('tabelb3.store');
        Route::get('/edit', 'TabelB3Controller@edit')->name('tabelb3.edit');
        Route::post('/update', 'TabelB3Controller@update')->name('tabelb3.update');
        Route::post('/delete', 'TabelB3Controller@destroy')->name('tabelb3.destroy');
    });
    Route::group(['prefix' => 'tabelc1'], function () {
        Route::get('/', 'TabelC1Controller@index')->name('tabelc1.index');
        Route::get('/list', 'TabelC1Controller@list')->name('tabelc1.list');
        Route::post('/create', 'TabelC1Controller@store')->name('tabelc1.store');
        Route::get('/edit', 'TabelC1Controller@edit')->name('tabelc1.edit');
        Route::post('/update', 'TabelC1Controller@update')->name('tabelc1.update');
        Route::post('/delete', 'TabelC1Controller@destroy')->name('tabelc1.destroy');
    });
    Route::group(['prefix' => 'tabelc2'], function () {
        Route::get('/', 'TabelC2Controller@index')->name('tabelc2.index');
        Route::get('/list', 'TabelC2Controller@list')->name('tabelc2.list');
        Route::post('/create', 'TabelC2Controller@store')->name('tabelc2.store');
        Route::get('/edit', 'TabelC2Controller@edit')->name('tabelc2.edit');
        Route::post('/update', 'TabelC2Controller@update')->name('tabelc2.update');
        Route::post('/delete', 'TabelC2Controller@destroy')->name('tabelc2.destroy');
    });


    Route::group(['prefix' => 'planninglineb3'], function () {
        Route::get('/', 'PlanningLineB3Controller@index')->name('planninglineb3.index');
        Route::get('/list', 'PlanningLineB3Controller@list')->name('planninglineb3.list');
        Route::get('/list3', 'PlanningLineB3Controller@list3')->name('planninglineb3.list3');
        Route::get('/listdetail', 'PlanningLineB3Controller@listdetail')->name('planninglineb3.listdetail');
        Route::post('/create', 'PlanningLineB3Controller@store')->name('planninglineb3.store');
        Route::get('/edit', 'PlanningLineB3Controller@edit')->name('planninglineb3.edit');
        Route::post('/delete', 'PlanningLineB3Controller@destroy')->name('planninglineb3.destroy');
        Route::post('/deleteline', 'PlanningLineB3Controller@destroyline')->name('planninglineb3.destroyline');
        Route::post('/update', 'PlanningLineB3Controller@update')->name('planninglineb3.update');
        Route::get('/export', 'PlanningLineB3Controller@export')->name('planninglineb3.export');
        Route::post('/submit', 'PlanningLineB3Controller@submit')->name('planninglineb3.submit');
        Route::get('/update-status', [PlanningLineB3Controller::class, 'updateStatusQty']);
        Route::post('/approve-production', 'PlanningLineB3Controller@approveProduction')->name('planninglineb3.approveProduction');
        Route::get('/get-actual-production/{id}', 'PlanningLineB3Controller@getActualProduction')->name('planninglineb3.getActualProduction');
        Route::post('/planninglineb3/reorder', [PlanningLineB3Controller::class, 'reorder'])->name('planninglineb3.reorder');
        // Route::get('/get-products-by-line', [PlanningLineB3Controller::class, 'getProductsByLine']);
        Route::get('/getProductsByLine', 'PlanningLineB3Controller@getProductsByLine')->name('planninglineb3.getProductsByLine');
        Route::get('/get-qty-actual-by-partno', [PlanningLineB3Controller::class, 'getQtyActualByPartNo'])->name('planninglineb3.getQtyActualByPartNo');
        // Route::get('/get-qty-actual-by-partno2', [PlanningLineB3Controller::class, 'getQtyActualByPartNo2'])->name('planninglineb3.getQtyActualByPartNo2');
        Route::get('/get-qty-blank', [PlanningLineB3Controller::class, 'getQtyBlank'])->name('get.qty.blank');
        Route::get('/get-stock', [PlanningLineB3Controller::class, 'getStock'])->name('get.stock');
        Route::get('/get-raw-material', [PlanningLineB3Controller::class, 'getRawMaterial'])->name('get.raw.material');
        Route::post('/check-partno2', [PlanningLineB3Controller::class, 'checkPartNo2'])->name('check.partno2');
        Route::get('/get-qty-stamping', [PlanningLineB3Controller::class, 'getQtyStamping'])->name('get.qty.transit');
        Route::get('/get-qty-kanban', [PlanningLineB3Controller::class, 'getQtyKanban'])->name('get.qty.kanban');
        // Route::post('/approve-production', [PlanningLineB3Controller::class, 'approveProduction'])->name('approve.production');
        Route::get('/get-job-details', 'PlanningLineB3Controller@getJobDetails')->name('planninglineb3.getJobDetails');
    });

    Route::group(['prefix' => 'mpsplanning'], function () {
        Route::get('/', 'MpsPlanningController@index')->name('mpsplanning.index');
        Route::get('/list', 'MpsPlanningController@list')->name('mpsplanning.list');
        Route::get('/listdetail', 'MpsPlanningController@listdetail')->name('mpsplanning.listdetail');
        Route::post('/create', 'MpsPlanningController@store')->name('mpsplanning.store');
        Route::get('/edit', 'MpsPlanningController@edit')->name('mpsplanning.edit');
        Route::post('/delete', 'MpsPlanningController@destroy')->name('mpsplanning.destroy');
        Route::post('/deleteline', 'MpsPlanningController@destroyline')->name('mpsplanning.destroyline');
        Route::post('/update', 'MpsPlanningController@update')->name('mpsplanning.update');
        Route::get('/export', 'MpsPlanningController@export')->name('mpsplanning.export');
    });

    Route::group(['prefix' => 'planninglinec2'], function () {
        Route::get('/', 'PlanningLineC2Controller@index')->name('planninglinec2.index');
        Route::get('/list', 'PlanningLineC2Controller@list')->name('planninglinec2.list');
        Route::get('/listdetail', 'PlanningLineC2Controller@listdetail')->name('planninglinec2.listdetail');
        Route::post('/create', 'PlanningLineC2Controller@store')->name('planninglinec2.store');
        Route::get('/edit', 'PlanningLineC2Controller@edit')->name('planninglinec2.edit');
        Route::post('/delete', 'PlanningLineC2Controller@destroy')->name('planninglinec2.destroy');
        Route::post('/deleteline', 'PlanningLineC2Controller@destroyline')->name('planninglinec2.destroyline');
        Route::post('/update', 'PlanningLineC2Controller@update')->name('planninglinec2.update');
        Route::get('/export', 'PlanningLineC2Controller@export')->name('planninglinec2.export');
    });


    Route::group(['prefix' => 'lkhb3'], function () {
        Route::get('/', 'Lkhb3Controller@index')->name('lkhb3.index');
        Route::get('/list', 'Lkhb3Controller@list')->name('lkhb3.list');
        Route::post('/update', 'Lkhb3Controller@update')->name('lkhb3.update');
        Route::post('/delete', 'Lkhb3Controller@destroy')->name('lkhb3.destroy');
    });

    Route::group(['prefix' => 'lkhc1'], function () {
        Route::get('/', 'LkhC1Controller@index')->name('lkhc1.index');
        Route::get('/list', 'LkhC1Controller@list')->name('lkhc1.list');
        Route::post('/update', 'LkhC1Controller@update')->name('lkhc1.update');
        Route::post('/delete', 'LkhC1Controller@destroy')->name('lkhc1.destroy');
    });

    Route::group(['prefix' => 'lkhc2'], function () {
        Route::get('/', 'LkhC2Controller@index')->name('lkhc2.index');
        Route::get('/list', 'LkhC2Controller@list')->name('lkhc2.list');
        Route::post('/update', 'LkhC2Controller@update')->name('lkhc2.update');
        Route::post('/delete', 'LkhC2Controller@destroy')->name('lkhc2.destroy');
    });


    Route::group(['prefix' => 'reportb3'], function () {
        Route::get('/', 'ReportB3Controller@index')->name('reportb3.index');
        Route::get('/list', 'ReportB3Controller@list')->name('reportb3.list');
        Route::post('/update', 'ReportB3Controller@update')->name('reportb3.update');
        Route::post('/delete', 'ReportB3Controller@destroy')->name('reportb3.destroy');
    });

    Route::group(['prefix' => 'reportc1'], function () {
        Route::get('/', 'ReportC1Controller@index')->name('reportc1.index');
        Route::get('/list', 'ReportC1Controller@list')->name('reportc1.list');
        Route::post('/update', 'ReportC1Controller@update')->name('reportc1.update');
        Route::post('/delete', 'ReportC1Controller@destroy')->name('reportc1.destroy');
    });

    Route::group(['prefix' => 'reportc2'], function () {
        Route::get('/', 'ReportC2Controller@index')->name('reportc2.index');
        Route::get('/list', 'ReportC2Controller@list')->name('reportc2.list');
        Route::post('/update', 'ReportC2Controller@update')->name('reportc2.update');
        Route::post('/delete', 'ReportC2Controller@destroy')->name('reportc2.destroy');
    });

    ////// RM MATERIAL SECTION //////
    Route::group(['prefix' => 'supplierrm'], function () {
        Route::get('/', 'RmSupplierController@index')->name('supplierrm.index');
        Route::get('/list', 'RmSupplierController@list')->name('supplierrm.list');
        Route::post('/create', 'RmSupplierController@store')->name('supplierrm.store');
        Route::get('/edit', 'RmSupplierController@edit')->name('supplierrm.edit');
        Route::post('/update', 'RmSupplierController@update')->name('supplierrm.update');
        Route::post('/delete', 'RmSupplierController@destroy')->name('supplierrm.destroy');
        Route::get('/export', 'RmSupplierController@export')->name('supplierrm.export');
    });

    Route::group(['prefix' => 'supplierrmnut'], function () {
        Route::get('/', 'RmSupplierNutController@index')->name('supplierrmnut.index');
        Route::get('/list', 'RmSupplierNutController@list')->name('supplierrmnut.list');
        Route::post('/create', 'RmSupplierNutController@store')->name('supplierrmnut.store');
        Route::get('/edit', 'RmSupplierNutController@edit')->name('supplierrmnut.edit');
        Route::post('/update', 'RmSupplierNutController@update')->name('supplierrmnut.update');
        Route::post('/delete', 'RmSupplierNutController@destroy')->name('supplierrmnut.destroy');
        Route::get('/export', 'RmSupplierNutController@export')->name('supplierrmnut.export');
    });

    Route::group(['prefix' => 'material'], function () {
        Route::get('/', 'RmMaterialController@index')->name('material.index');
        Route::get('/list', 'RmMaterialController@list')->name('material.list');
        Route::post('/create', 'RmMaterialController@store')->name('material.store');
        Route::get('/edit', 'RmMaterialController@edit')->name('material.edit');
        Route::post('/update', 'RmMaterialController@update')->name('material.update');
        Route::post('/delete', 'RmMaterialController@destroy')->name('material.destroy');
        Route::post('/check-material', 'RmMaterialController@checkMaterial')->name('material.check');
        // Route::get('/filter-materials', 'RmMaterialController@filterMaterials')->name('material.filter');
        Route::get('/filter-materials', [RmMaterialController::class, 'filterMaterials'])->name('material.filter');

        // Route::get('/filter-materials', [RmMaterialController::class, 'filterMaterials'])->name('filter.materials');

        // Route::post('/filter-material-line', [RmMaterialController::class, 'filterMaterialByLine'])->name('material.filter');
        // routes/web.php
        // Route::post('/check-material', [RmMaterialController::class, 'checkMaterial'])->name('check.material');

    });

    Route::group(['prefix' => 'standartnut'], function () {
        Route::get('/', 'RmStandartNutController@index')->name('standartnut.index');
        Route::get('/list', 'RmStandartNutController@list')->name('standartnut.list');
        Route::post('/create', 'RmStandartNutController@store')->name('standartnut.store');
        Route::get('/edit', 'RmStandartNutController@edit')->name('standartnut.edit');
        Route::post('/update', 'RmStandartNutController@update')->name('standartnut.update');
        Route::post('/delete', 'RmStandartNutController@destroy')->name('standartnut.destroy');
    });

    Route::group(['prefix' => 'materialnut'], function () {
        Route::get('/', 'RmMaterialNutController@index')->name('materialnut.index');
        Route::get('/list', 'RmMaterialNutController@list')->name('materialnut.list');
        Route::post('/create', 'RmMaterialNutController@store')->name('materialnut.store');
        Route::get('/edit', 'RmMaterialNutController@edit')->name('materialnut.edit');
        Route::post('/update', 'RmMaterialNutController@update')->name('materialnut.update');
        Route::post('/delete', 'RmMaterialNutController@destroy')->name('materialnut.destroy');
    });

    Route::group(['prefix' => 'inmaterial'], function () {
        Route::get('/', 'RmInMaterialController@index')->name('inmaterial.index');
        Route::get('/list', 'RmInMaterialController@list')->name('inmaterial.list');
        Route::get('/listdetail', 'RmInMaterialController@listdetail')->name('inmaterial.listdetail');
        Route::post('/create', 'RmInMaterialController@store')->name('inmaterial.store');
        Route::get('/edit', 'RmInMaterialController@edit')->name('inmaterial.edit');
        Route::post('/delete', 'RmInMaterialController@destroy')->name('inmaterial.destroy');
        Route::post('/deleteline', 'RmInMaterialController@destroyline')->name('inmaterial.destroyline');
        Route::post('/update', 'RmInMaterialController@update')->name('inmaterial.update');
        Route::get('/export', 'RmInMaterialController@export')->name('inmaterial.export');
        Route::get('/inmaterial/cetak/{id}', 'RmInMaterialController@cetak')->name('inmaterial.cetak');
        Route::get('/printDetail', 'RmInMaterialController@printDetail')->name('rmmaterial.printDetail');
        Route::get('/getdoc', 'RmInMaterialController@getdoc')->name('inmaterial.getdoc');
        Route::post('/submit', 'RmInMaterialController@submit')->name('inmaterial.submit');
        Route::post('/delete_draft', 'RmInMaterialController@delete_draft')->name('inmaterial.delete_draft');
        Route::post('/generateMultipleQrCodes', 'RmInMaterialController@generateMultipleQrCodes')->name('inmaterial.generateMultipleQrCodes');
        Route::get('/inmaterial/print/{doc_no}', [RmInMaterialController::class, 'printPdf'])->name('inmaterial.print');
        Route::post('/get-materials-by-doc-no', [RmInMaterialController::class, 'getMaterialsByDocNodn'])->name('getMaterialsByDocNodn');
        Route::post('/update-qty-in', [RmInMaterialController::class, 'updateQtyIndn'])->name('updateQtyIndn');
    });

    Route::group(['prefix' => 'innut'], function () {
        Route::get('/', 'RmInNutController@index')->name('innut.index');
        Route::get('/list', 'RmInNutController@list')->name('innut.list');
        Route::get('/listdetail', 'RmInNutController@listdetail')->name('innut.listdetail');
        Route::post('/create', 'RmInNutController@store')->name('innut.store');
        Route::get('/edit', 'RmInNutController@edit')->name('innut.edit');
        Route::post('/delete', 'RmInNutController@destroy')->name('innut.destroy');
        Route::post('/deleteline', 'RmInNutController@destroyline')->name('innut.destroyline');
        Route::post('/update', 'RmInNutController@update')->name('innut.update');
        Route::get('/export', 'RmInNutController@export')->name('innut.export');
        Route::get('/rmmaterial/cetak/{id}', 'RmInNutController@cetak')->name('rmmaterial.cetaknut');
        Route::get('/printDetail', 'RmInNutController@printDetail')->name('innut.printDetail');
        Route::get('/getdoc', 'RmInNutController@getdoc')->name('innut.getdoc');
        Route::post('/submit', 'RmInNutController@submit')->name('innut.submit');
        Route::post('/delete_draft', 'RmInNutController@delete_draft')->name('innut.delete_draft');
        Route::get('/inmaterial/print/{doc_no}', [RmInNutController::class, 'printPdf'])->name('innut.print');
        Route::get('/innut/rmmaterial/cetak/{id}', [RmInNutController::class, 'generateBarcode']);
        Route::post('/innut/print-multiple', [RmInNutController::class, 'printMultiple'])->name('innut.printMultiple');
        Route::get('/download/{filename}', [RmInNutController::class, 'downloadFile'])->name('download.file');
        Route::post('/get-materials-by-doc-no', [RmInNutController::class, 'getMaterialsByDocNo'])->name('getMaterialsByDocNo');
        Route::post('/update-qty-in', [RmInNutController::class, 'updateQtyIn'])->name('updateQtyIn');
        Route::get('/dashboardrm/cetak/{id}', [RmInNutController::class, 'cetak'])->name('innut.cetak');
    });


    Route::group(['prefix' => 'rmstok'], function () {
        Route::get('/', 'RmStokController@index')->name('rmstok.index');
        Route::get('/list', 'RmStokController@list')->name('rmstok.list');
        Route::post('/create', 'RmStokController@store')->name('rmstok.store');
        Route::get('/edit', 'RmStokController@edit')->name('rmstok.edit');
        Route::post('/update', 'RmStokController@update')->name('rmstok.update');
        Route::post('/delete', 'RmStokController@destroy')->name('rmstok.destroy');
        Route::get('users/export', 'RmStokController@export')->name('rmstok.export');
        Route::post('/update1', 'RmStokController@update1')->name('rmstok.update1');
        Route::post('/rmstok/store2', 'RmStokController@store2')->name('rmstok.store2');
        // Route::get('/details', [RmStokController::class, 'getMaterialDetails'])->name('rmstok.detail');
        Route::get('/rmstok/detail', [RmStokController::class, 'getMaterialDetails'])->name('rmstok.detail');
        Route::post('/import-stok', [RmStokController::class, 'importStok'])->name('importStok');
    });


    Route::group(['prefix' => 'taglabel3'], function () {
        Route::get('/', 'TagLabel3Controller@index')->name('taglabel3.index');
        Route::get('/list', 'TagLabel3Controller@list')->name('taglabel3.list');
        Route::get('/listdetail', 'TagLabel3Controller@listdetail')->name('taglabel3.listdetail');
        // Route::get('/taglabel3/list', [TagLabel3Controller::class, 'list'])->name('taglabel3.list');
        Route::get('/taglabel3/list', 'TagLabel3Controller@listdetail3')->name('taglabel3.list3');
        Route::get('/edit', 'TagLabel3Controller@edit')->name('taglabel3.edit');
        Route::post('/store', 'TagLabel3Controller@store')->name('taglabel3.store');
        Route::get('/taglabel3/get-data-by-part', [TagLabel3Controller::class, 'getByPart'])->name('taglabel3.getdatabypart');
        Route::post('/taglabel3/generateMultipleQrCodes', [TagLabel3Controller::class, 'generateMultipleQrCodes'])->name('taglabel3.generateMultipleQrCodes');
        Route::post('/deleteline', 'TagLabel3Controller@destroyline')->name('taglabel3.destroyline');

    });

    Route::group(['prefix' => 'taglabel2'], function () {
        Route::get('/', 'TagLabel2Controller@index')->name('taglabel2.index');
        Route::get('/list', 'TagLabel2Controller@list')->name('taglabel2.list');
        Route::get('/listdetail', 'TagLabel2Controller@listdetail')->name('taglabel2.listdetail');
        // Route::get('/taglabel2/list', [TagLabel2Controller::class, 'list'])->name('taglabel2.list');
        Route::get('/taglabel2/list', 'TagLabel2Controller@listdetail2')->name('taglabel2.list2');
        Route::get('/edit', 'TagLabel2Controller@edit')->name('taglabel2.edit');
        Route::post('/store', 'TagLabel2Controller@store')->name('taglabel2.store');
        Route::get('/taglabel2/get-data-by-part', [TagLabel2Controller::class, 'getByPart'])->name('taglabel2.getdatabypart');
        Route::post('/taglabel2/generateMultipleQrCodes', [TagLabel2Controller::class, 'generateMultipleQrCodes'])->name('taglabel2.generateMultipleQrCodes');
        Route::post('/deleteline', 'TagLabel2Controller@destroyline')->name('taglabel2.destroyline');

    });


    Route::group(['prefix' => 'taglabelwelding'], function () {
        Route::get('/', 'TagLabelWeldingController@index')->name('taglabelwelding.index');
        Route::get('/list', 'TagLabelWeldingController@list')->name('taglabelwelding.list');
        Route::get('/listdetail', 'TagLabelWeldingController@listdetail')->name('taglabelwelding.listdetail');
        // Route::get('/taglabelwelding/list', [TagLabelWeldingController::class, 'list'])->name('taglabelwelding.list');
        Route::get('/taglabelwelding/list', 'TagLabelWeldingController@listdetail2')->name('taglabelwelding.list2');
        Route::get('/edit', 'TagLabelWeldingController@edit')->name('taglabelwelding.edit');
        Route::post('/store', 'TagLabelWeldingController@store')->name('taglabelwelding.store');
        Route::get('/taglabelwelding/get-data-by-part', [TagLabelWeldingController::class, 'getByPart'])->name('taglabelwelding.getdatabypart');
        Route::post('/taglabelwelding/generateMultipleQrCodes', [TagLabelWeldingController::class, 'generateMultipleQrCodes'])->name('taglabelwelding.generateMultipleQrCodes');
        Route::post('/deleteline', 'TagLabelWeldingController@destroyline')->name('taglabelwelding.destroyline');

    });

    Route::group(['prefix' => 'taglabelsubcont'], function () {
        Route::get('/', 'TagLabelSubcontController@index')->name('taglabelsubcont.index');
        Route::get('/list', 'TagLabelSubcontController@list')->name('taglabelsubcont.list');
        Route::get('/listdetail', 'TagLabelSubcontController@listdetail')->name('taglabelsubcont.listdetail');
        // Route::get('/taglabelsubcont/list', [TagLabelSubcontController::class, 'list'])->name('taglabelsubcont.list');
        Route::get('/taglabelsubcont/list', 'TagLabelSubcontController@listdetail2')->name('taglabelsubcont.list2');
        Route::get('/edit', 'TagLabelSubcontController@edit')->name('taglabelsubcont.edit');
        Route::post('/store', 'TagLabelSubcontController@store')->name('taglabelsubcont.store');
        Route::get('/taglabelsubcont/get-data-by-part', [TagLabelSubcontController::class, 'getByPart'])->name('taglabelsubcont.getdatabypart');
        Route::post('/taglabelsubcont/generateMultipleQrCodes', [TagLabelSubcontController::class, 'generateMultipleQrCodes'])->name('taglabelsubcont.generateMultipleQrCodes');
        Route::post('/deleteline', 'TagLabelSubcontController@destroyline')->name('taglabelsubcont.destroyline');

    });



    Route::group(['prefix' => 'rmdnincoming'], function () {
        Route::get('/', 'RmDnIncomingController@index')->name('rmdnincoming.index');
        Route::get('/list', 'RmDnIncomingController@list')->name('rmdnincoming.list');
        Route::get('/listdetail', 'RmDnIncomingController@listdetail')->name('rmdnincoming.listdetail');
        Route::post('/create', 'RmDnIncomingController@store')->name('rmdnincoming.store');
        Route::get('/edit', 'RmDnIncomingController@edit')->name('rmdnincoming.edit');
        Route::post('/delete', 'RmDnIncomingController@destroy')->name('rmdnincoming.destroy');
        Route::post('/deleteline', 'RmDnIncomingController@destroyline')->name('rmdnincoming.destroyline');
        Route::post('/update', 'RmDnIncomingController@update')->name('rmdnincoming.update');
        Route::get('/template', 'RmDnIncomingController@templateDn')->name('rmdnincoming.template');
        Route::get('/export', 'RmDnIncomingController@export')->name('rmdnincoming.export');
        Route::post('/import-monthly', [RmDnIncomingController::class, 'importDn'])->name('importDn');
        Route::post('/export-monthly', [RmDnIncomingController::class, 'exportDn'])->name('exportDn');
    });
    Route::group(['prefix' => 'rmmonthly'], function () {
        Route::get('/', 'RmUploadMonthlyController@index')->name('rmmonthly.index');
        Route::get('/list', 'RmUploadMonthlyController@list')->name('rmmonthly.list');
        Route::get('/listdetail', 'RmUploadMonthlyController@listdetail')->name('rmmonthly.listdetail');
        Route::post('/create', 'RmUploadMonthlyController@store')->name('rmmonthly.store');
        Route::get('/edit', 'RmUploadMonthlyController@edit')->name('rmmonthly.edit');
        Route::post('/delete', 'RmUploadMonthlyController@destroy')->name('rmmonthly.destroy');
        Route::post('/deleteline', 'RmUploadMonthlyController@destroyline')->name('rmmonthly.destroyline');
        Route::post('/update', 'RmUploadMonthlyController@update')->name('rmmonthly.update');
        Route::get('/export', 'RmUploadMonthlyController@export')->name('rmmonthly.export');
        // Route::post('/import-monthly', [RmUploadMonthlyController::class, 'importMonthly'])->name('importMonthly');
        Route::post('/import-monthly', 'RmUploadMonthlyController@importMonthly')->name('rmmonthly.importMonthly');

    });


    Route::group(['prefix' => 'stoknut'], function () {
        Route::get('/', 'RmStokNutController@index')->name('stoknut.index');
        Route::get('/list', 'RmStokNutController@list')->name('stoknut.list');
        Route::post('/create', 'RmStokNutController@store')->name('stoknut.store');
        Route::get('/edit', 'RmStokNutController@edit')->name('stoknut.edit');
        Route::post('/update', 'RmStokNutController@update')->name('stoknut.update');
        Route::post('/delete', 'RmStokNutController@destroy')->name('stoknut.destroy');
        Route::get('users/export', 'RmStokNutController@export')->name('stoknut.export');
        Route::post('/update1', 'RmStokNutController@update1')->name('stoknut.update1');
        Route::post('/stoknut/store2', 'RmStokNutController@store2')->name('stoknut.store2');
        // Route::get('rmstok/detail', [RmStokController::class, 'getDetail'])->name('rmstok.detail');

    });

    // Route::group(['prefix' => 'rmreturn'], function() {
    //     Route::get('/', 'RmReturnController@index')->name('rmreturn.index');
    //     Route::post('/approve-material', [RmReturnController::class, 'approveMaterial'])->name('approve.material');
    //     Route::post('/filter-material-line', [RmReturnController::class, 'filterMaterialByLine'])->name('filter.material.line');
    // });

    Route::group(['prefix' => 'dashboardblank'], function () {
        Route::get('/', 'DashboardBlank2Controller@index')->name('dashboardblank.index');
        Route::get('/list', 'DashboardBlank2Controller@list')->name('dashboardblank.list');
        Route::post('/dashboardblank/approve', 'DashboardBlank2Controller@approve')->name('dashboardblank.approve');
        Route::post('/dashboardblank/accepted', 'DashboardBlank2Controller@accepted')->name('dashboardblank.accepted');
        Route::get('/dashboardblank/getPartNoOptions', [DashboardBlank2Controller::class, 'getPartNoOptions'])->name('dashboardblank.getPartNoOptions');
        Route::get('/dashboardblank/getPartNoOptions2', [DashboardBlank2Controller::class, 'getPartNoOptions2'])->name('dashboardblank.getPartNoOptions2');
        Route::get('users/export', 'DashboardBlank2Controller@export')->name('dashboardblank.export');
        Route::get('/total', 'DashboardBlank2Controller@total')->name('dashboardblank.total');
        Route::get('/total2', 'DashboardBlank2Controller@total2')->name('dashboardblank.total2');
        Route::get('/safeData', 'DashboardBlank2Controller@getSafeData')->name('dashboardblank.getSafeData');
        Route::get('/safeData2', 'DashboardBlank2Controller@getSafeData2')->name('dashboardblank.getSafeData2');
        Route::get('/getCritcalData', 'DashboardBlank2Controller@getCritcalData')->name('dashboardblank.getCritcalData');
        Route::get('/getCritcalData2', 'DashboardBlank2Controller@getCritcalData2')->name('dashboardblank.getCritcalData2');
        Route::get('/getPartTa2', 'DashboardBlank2Controller@getPartTa2')->name('dashboardblank.getPartTa2');
        Route::get('/getPartTa', 'DashboardBlank2Controller@getPartTa')->name('dashboardblank.getPartTa');


        // Route::post('/rmreturn/approve', [RmReturnController::class, 'approve'])->name('rmreturn.approve');

    });




    Route::group(['prefix' => 'uploadrekap'], function () {
        Route::get('/', 'UploadRekapController@index')->name('uploadrekap.index');
        Route::get('/list', 'UploadRekapController@list')->name('uploadrekap.list');
        Route::get('/listdetail', 'UploadRekapController@listdetail')->name('uploadrekap.listdetail');
        Route::get('/getChartData', 'UploadRekapController@getChartData')->name('uploadrekap.getChartData');
        Route::post('/create', 'UploadRekapController@store')->name('uploadrekap.store');
        Route::get('/edit', 'UploadRekapController@edit')->name('uploadrekap.edit');
        Route::post('/update', 'UploadRekapController@update')->name('uploadrekap.update');
        Route::post('/delete', 'UploadRekapController@destroy')->name('uploadrekap.destroy');
        Route::get('users/export', 'UploadRekapController@export')->name('uploadrekap.export');
        Route::post('/import-ls', 'UploadRekapController@importRekap')->name('uploadrekap.importRekap');
        Route::post('/import-monthly', [UploadRekapController::class, 'importRekap'])->name('importRekap');
        Route::post('/reset-cycle', [UploadRekapController::class, 'resetCycle'])->name('uploadrekap.resetCycle');
        Route::get('/export-pdf', [UploadRekapController::class, 'exportPdf'])->name('uploadrekap.exportPdf');
        Route::get('/get-summary', [UploadRekapController::class, 'getSummary'])->name('uploadrekap.getSummary');
        // Route::post('/import-Dp', [LineStoreStokController::class, 'importDp'])->name('partname.importDp');
    });



    Route::group(['prefix' => 'uploadrekapadm'], function () {
        Route::get('/', 'UploadRekapAdmController@index')->name('uploadrekapadm.index');
        Route::get('/list', 'UploadRekapAdmController@list')->name('uploadrekapadm.list');
        Route::get('/listdetail', 'UploadRekapAdmController@listdetail')->name('uploadrekapadm.listdetail');
        Route::get('/getChartData', 'UploadRekapAdmController@getChartData')->name('uploadrekapadm.getChartData');
        Route::post('/create', 'UploadRekapAdmController@store')->name('uploadrekapadm.store');
        Route::get('/edit', 'UploadRekapAdmController@edit')->name('uploadrekapadm.edit');
        Route::post('/update', 'UploadRekapAdmController@update')->name('uploadrekapadm.update');
        Route::post('/delete', 'UploadRekapAdmController@destroy')->name('uploadrekapadm.destroy');
        Route::get('users/export', 'UploadRekapAdmController@export')->name('uploadrekapadm.export');
        Route::post('/import-rekapadm', [UploadRekapAdmController::class, 'importRekapadm'])->name('importRekapadm');
        Route::post('/reset-cycle', [UploadRekapAdmController::class, 'resetCycle'])->name('uploadrekapadm.resetCycle');
        Route::get('/export-pdf', [UploadRekapAdmController::class, 'exportPdf'])->name('uploadrekapadm.exportPdf');
        Route::get('/get-summary', [UploadRekapAdmController::class, 'getSummary'])->name('uploadrekapadm.getSummary');
        // Route::post('/import-Dp', [LineStoreStokController::class, 'importDp'])->name('partname.importDp');
    });


    Route::group(['prefix' => 'uploadrekapadmp4'], function () {
        Route::get('/', 'UploadRekapAdmP4Controller@index')->name('uploadrekapadmp4.index');
        Route::get('/list', 'UploadRekapAdmP4Controller@list')->name('uploadrekapadmp4.list');
        Route::get('/listdetail', 'UploadRekapAdmP4Controller@listdetail')->name('uploadrekapadmp4.listdetail');
        Route::get('/getChartData', 'UploadRekapAdmP4Controller@getChartData')->name('uploadrekapadmp4.getChartData');
        Route::post('/create', 'UploadRekapAdmP4Controller@store')->name('uploadrekapadmp4.store');
        Route::get('/edit', 'UploadRekapAdmP4Controller@edit')->name('uploadrekapadmp4.edit');
        Route::post('/update', 'UploadRekapAdmP4Controller@update')->name('uploadrekapadmp4.update');
        Route::post('/delete', 'UploadRekapAdmP4Controller@destroy')->name('uploadrekapadmp4.destroy');
        Route::get('users/export', 'UploadRekapAdmP4Controller@export')->name('uploadrekapadmp4.export');
        Route::post('/import-rekapadm4', [UploadRekapAdmP4Controller::class, 'importRekapadmp4'])->name('importRekapadmp4');
        Route::post('/reset-cycle', [UploadRekapAdmP4Controller::class, 'resetCycle'])->name('uploadrekapadmp4.resetCycle');
        Route::get('/export-pdf', [UploadRekapAdmP4Controller::class, 'exportPdf'])->name('uploadrekapadmp4.exportPdf');
        Route::get('/get-summary', [UploadRekapAdmP4Controller::class, 'getSummary'])->name('uploadrekapadmp4.getSummary');
        Route::post('/deleteline', 'UploadRekapAdmP4Controller@destroyline')->name('uploadrekapadmp4.destroyline');
        // Route::post('/import-Dp', [LineStoreStokController::class, 'importDp'])->name('partname.importDp');
    });

    Route::group(['prefix' => 'listrekapd26'], function () {
        Route::get('/', 'Listrekapd26Controller@index')->name('listrekapd26.index');
        Route::get('/list', 'Listrekapd26Controller@list')->name('listrekapd26.list');
        Route::get('/listdetail', 'Listrekapd26Controller@listdetail')->name('listrekapd26.listdetail');
        Route::post('/uploadrekap/update', [Listrekapd26Controller::class, 'updateQtyOrder'])->name('listrekapd26.update');
        Route::get('/get-cycle-list', [Listrekapd26Controller::class, 'getQtyRekap'])->name('get.qty.rekap');
        Route::get('/check-sts', [Listrekapd26Controller::class, 'checkSts'])->name('check.sts');
        Route::get('/check-labelwelding', [Listrekapd26Controller::class, 'checkLabelWelding2'])->name('check.labelwelding2');

        // Route::post('/import-Dp', [LineStoreStokController::class, 'importDp'])->name('partname.importDp');
    });

    Route::group(['prefix' => 'listrekapd26adm'], function () {
        Route::get('/', 'Listrekapd26AdmController@index')->name('listrekapd26adm.index');
        Route::get('/list', 'Listrekapd26AdmController@list')->name('listrekapd26adm.list');
        Route::get('/listdetail', 'Listrekapd26AdmController@listdetail')->name('listrekapd26adm.listdetail');
        Route::post('/uploadrekap/update', [Listrekapd26AdmController::class, 'updateQtyOrder'])->name('listrekapd26adm.update');
        Route::get('/get-cycle-list', [Listrekapd26AdmController::class, 'getQtyRekap'])->name('get.qty.rekapadm');
        Route::get('/check-sts', [Listrekapd26AdmController::class, 'checkStsAdm'])->name('check.stsadm');
        // Route::get('/check-labelwelding', [Listrekapd26AdmController::class, 'checkLabelWelding'])->name('check.labelwelding');
        Route::get('/check-label-welding', [Listrekapd26AdmController::class, 'checkLabelWelding'])->name('check.label.welding');
        Route::get('/check-pcstore', [Listrekapd26AdmController::class, 'checkPcStore'])->name('check.pcstore');
        // Route::post('/import-Dp', [LineStoreStokController::class, 'importDp'])->name('partname.importDp');
    });

    Route::group(['prefix' => 'listrekapdadmp4'], function () {
        Route::get('/', 'ListrekapdAdmP4Controller@index')->name('listrekapdadmp4.index');
        Route::get('/list', 'ListrekapdAdmP4Controller@list')->name('listrekapdadmp4.list');
        Route::get('/listdetail', 'ListrekapdAdmP4Controller@listdetail')->name('listrekapdadmp4.listdetail');
        Route::post('/uploadrekap/update', [ListrekapdAdmP4Controller::class, 'updateQtyOrder'])->name('listrekapdadmp4.update');
        Route::get('/get-cycle-list', [ListrekapdAdmP4Controller::class, 'getQtyRekap'])->name('get.qty.rekapadmp4');
        Route::get('/check-sts', [ListrekapdAdmP4Controller::class, 'checkStsAdm'])->name('check.stsadmp4');
        Route::get('/check-label-welding', [ListrekapdAdmP4Controller::class, 'checkLabelWelding'])->name('check.label.weldingp4');
        Route::get('/check-pcstore', [ListrekapdAdmP4Controller::class, 'checkPcStore'])->name('check.pcstorep4');
        // Route::post('/import-Dp', [LineStoreStokController::class, 'importDp'])->name('partname.importDp');
    });

    Route::group(['prefix' => 'linestorestok'], function () {
        Route::get('/', 'LineStoreStokController@index')->name('linestorestok.index');
        Route::get('/list', 'LineStoreStokController@list')->name('linestorestok.list');
        Route::post('/create', 'LineStoreStokController@store')->name('linestorestok.store');
        Route::get('/edit', 'LineStoreStokController@edit')->name('linestorestok.edit');
        Route::post('/update', 'LineStoreStokController@update')->name('linestorestok.update');
        Route::post('/delete', 'LineStoreStokController@destroy')->name('linestorestok.destroy');
        Route::get('users/export', 'LineStoreStokController@export')->name('linestorestok.export');
        Route::post('/import-ls', 'LineStoreStokController@importLs')->name('linestorestok.importLs');
        // Route::post('/import-Dp', [LineStoreStokController::class, 'importDp'])->name('partname.importDp');
    });

    Route::group(['prefix' => 'linestoreindex'], function () {
        Route::get('/', 'LineStoreIndexController@index')->name('linestoreindex.index');
        Route::get('/list', 'LineStoreIndexController@list')->name('linestoreindex.list');
        Route::post('/create', 'LineStoreIndexController@store')->name('linestoreindex.store');
        Route::get('/edit', 'LineStoreIndexController@edit')->name('linestoreindex.edit');
        Route::post('/update', 'LineStoreIndexController@update')->name('linestoreindex.update');
        Route::post('/delete', 'LineStoreIndexController@destroy')->name('linestoreindex.destroy');
        Route::post('/detail', 'LineStoreIndexController@detail')->name('linestoreindex.detail');
        Route::post('/export-line-store', [LineStoreIndexController::class, 'export'])->name('exportLineStore2.export');
        // Route::get('/get-tcf2-data', 'LineStoreIndexController@getTcf2Data')->name('linestoreindex.getTcf2Data');
        Route::get('/get-total-data', [LineStoreIndexController::class, 'getTotalPart'])->name('getTotalPart');
        Route::get('/get-safe-data', [LineStoreIndexController::class, 'getSafePart'])->name('getSafePart');
        Route::get('/get-critical-data', [LineStoreIndexController::class, 'getCrticalPart'])->name('getCrticalPart');
        Route::get('/get-ta-data', [LineStoreIndexController::class, 'getTaPart'])->name('getTaPart');
        Route::get('/get-tcf2-data', [LineStoreIndexController::class, 'getTcf2Data'])->name('getTcf2Data');
        Route::get('/get-tcf2-data2', [LineStoreIndexController::class, 'getTcf2Data2'])->name('getTcf2Data2');
        Route::get('/get-tcf2-data3', [LineStoreIndexController::class, 'getTcf2Data3'])->name('getTcf2Data3');
        Route::get('/get-geho-data', [LineStoreIndexController::class, 'getGehoData'])->name('getGehoData');
        Route::get('/get-geho-data2', [LineStoreIndexController::class, 'getGehoData2'])->name('getGehoData2');
        Route::get('/get-geho-data3', [LineStoreIndexController::class, 'getGehoData3'])->name('getGehoData3');
        Route::get('/get-swt-data', [LineStoreIndexController::class, 'getSwtData'])->name('getSwtData');
        Route::get('/get-swt-data2', [LineStoreIndexController::class, 'getSwtData2'])->name('getSwtData2');
        Route::get('/get-swt-data3', [LineStoreIndexController::class, 'getSwtData3'])->name('getSwtData3');
    });


    Route::group(['prefix' => 'linestoreindex2'], function () {
        Route::get('/', 'LineStoreIndex2Controller@index')->name('linestoreindex2.index');
        Route::get('/list', 'LineStoreIndex2Controller@list')->name('linestoreindex2.list');
        Route::post('/create', 'LineStoreIndex2Controller@store')->name('linestoreindex2store');
        Route::get('/edit', 'LineStoreIndex2Controller@edit')->name('linestoreindex2.edit');
        Route::post('/update', 'LineStoreIndex2Controller@update')->name('linestoreindex2.update');
        Route::post('/delete', 'LineStoreIndex2Controller@destroy')->name('linestoreindex2.destroy');
        Route::post('/detail', 'LineStoreIndex2Controller@detail')->name('linestoreindex2.detail');
        Route::post('/export-line-store', [LineStoreIndex2Controller::class, 'export'])->name('exportLineStore.export');
        // Route::get('/get-tcf2-data', 'LineStoreIndexController@getTcf2Data')->name('linestoreindex.getTcf2Data');
        Route::get('/get-total-data', [LineStoreIndex2Controller::class, 'getTotalPartInhouse'])->name('getTotalPartInhouse');
        Route::get('/get-total-data2', [LineStoreIndex2Controller::class, 'getTotalPartOuthouse'])->name('getTotalPartOuthouse');
        Route::get('/get-safe-data', [LineStoreIndex2Controller::class, 'getSafePartInhouse'])->name('getSafePartInhouse');
        Route::get('/get-safe-data2', [LineStoreIndex2Controller::class, 'getSafePartOuthouse'])->name('getSafePartOuthouse');
        Route::get('/get-critical-data', [LineStoreIndex2Controller::class, 'getCrticalPartInhouse'])->name('getCrticalPartInhouse');
        Route::get('/get-critical-data2', [LineStoreIndex2Controller::class, 'getCrticalOuthouse'])->name('getCrticalOuthouse');
        Route::get('/get-ta-data', [LineStoreIndex2Controller::class, 'getTaPartInhouse'])->name('getTaPartInhouse');
        Route::get('/get-ta-data2', [LineStoreIndex2Controller::class, 'getTaPartOuthouse'])->name('getTaPartOuthouse');
        Route::get('/get-planning-line-b3s', [LineStoreIndex2Controller::class, 'getPlanningLineB3'])->name('getPlanningLineB3');
        Route::get('/getScanPartBps', [LineStoreIndex2Controller::class, 'getScanPartBps'])->name('getScanPartBps');
        Route::get('/getScanOutStmps', [LineStoreIndex2Controller::class, 'getScanOutStmps'])->name('getScanOutStmps');
        Route::get('/get-model12d14-data', [LineStoreIndex2Controller::class, 'getModelD12'])->name('getModelD12');
        Route::get('/get-model12d14-data2', [LineStoreIndex2Controller::class, 'get2ModelD12'])->name('get2ModelD12');
        Route::get('/get-model12d14-data3', [LineStoreIndex2Controller::class, 'get3ModelD12'])->name('get3ModelD12');
        Route::get('/get-modeld26-data', [LineStoreIndex2Controller::class, 'getModelD26'])->name('getModelD26');
        Route::get('/get-modeld26adm-data2', [LineStoreIndex2Controller::class, 'get2ModelD26'])->name('get2ModelD26');
        Route::get('/get-modeld26adm-data3', [LineStoreIndex2Controller::class, 'get3ModelD26'])->name('get3ModelD26');
        Route::get('/get-modeld40-data', [LineStoreIndex2Controller::class, 'getModelD40'])->name('getModelD40');
        Route::get('/get-modeld40-data2', [LineStoreIndex2Controller::class, 'get2ModelD40'])->name('get2ModelD40');
        Route::get('/get-modeld40-data3', [LineStoreIndex2Controller::class, 'get3ModelD40'])->name('get3ModelD40');
        Route::get('/get-modeld30-data', [LineStoreIndex2Controller::class, 'getModelD30'])->name('getModelD30');
        Route::get('/get-modeld30-data2', [LineStoreIndex2Controller::class, 'get2ModelD30'])->name('get2ModelD30');
        Route::get('/get-modeld30-data3', [LineStoreIndex2Controller::class, 'get3ModelD30'])->name('get3ModelD30');
        Route::get('/get-modeld03-data', [LineStoreIndex2Controller::class, 'getModelD03'])->name('getModelD03');
        Route::get('/get-modeld03-data2', [LineStoreIndex2Controller::class, 'get2ModelD03'])->name('get2ModelD03');
        Route::get('/get-modeld03-data3', [LineStoreIndex2Controller::class, 'get3ModelD03'])->name('get3ModelD03');
        Route::get('/get-modelkS-data', [LineStoreIndex2Controller::class, 'getModelKS'])->name('getModelKS');
        Route::get('/get-modelkS-data2', [LineStoreIndex2Controller::class, 'get2ModelKS'])->name('get2ModelKS');
        Route::get('/get-modelkS-data3', [LineStoreIndex2Controller::class, 'get3ModelKS'])->name('get3ModelKS');


    });

    Route::group(['prefix' => 'linestoreindex3'], function () {
        Route::get('/', 'LineStoreIndex3Controller@index')->name('linestoreindex3.index');
        Route::get('/list', 'LineStoreIndex3Controller@list')->name('linestoreindex3.list');
        Route::post('/create', 'LineStoreIndex3Controller@store')->name('linestoreindex3store');
        Route::get('/edit', 'LineStoreIndex3Controller@edit')->name('linestoreindex3.edit');
        Route::post('/update', 'LineStoreIndex3Controller@update')->name('linestoreindex3.update');
        Route::post('/delete', 'LineStoreIndex3Controller@destroy')->name('linestoreindex3.destroy');
        Route::post('/detail', 'LineStoreIndex3Controller@detail')->name('linestoreindex3.detail');
        Route::get('/getLineStoreUploads', 'LineStoreIndex3Controller@getLineStoreUploads')->name('linestoreindex3.getLineStoreUploads');
        Route::get('/getSupplierData', 'LineStoreIndex3Controller@getSupplierData')->name('linestoreindex3.getSupplierData');
        Route::post('/store', 'LineStoreIndex3Controller@store')->name('linestoreindex3.store');
        // routes/web.php
        Route::get('/get-incoming-parts', [LineStoreIndex3Controller::class, 'getIncomingParts'])->name('linestoreindex3.getIncomingParts');
        // Route::get('/get-line-store-uploads', [LineStoreIndex3Controller::class, 'getLineStoreUploads']);
        // Route::get('/get-tcf2-data', 'LineStoreIndexController@getTcf2Data')->name('linestoreindex.getTcf2Data');
        // Route::get('/get-tcf2-data', [LineStoreIndex2Controller::class, 'getTcf2Data'])->name('getTcf2Data');
        // Route::get('/get-tcf2-data2', [LineStoreIndex2ontroller::class, 'getTcf2Data2'])->name('getTcf2Data2');
        // Route::get('/get-tcf2-data3', [LineStoreIndex2Controller::class, 'getTcf2Data3'])->name('getTcf2Data3');
    });

    Route::group(['prefix' => 'linestoreupload'], function () {
        Route::get('/', 'LineStoreUploadController@index')->name('linestoreupload.index');
        Route::get('/list', 'LineStoreUploadController@list')->name('linestoreupload.list');
        Route::get('/listdetail', 'LineStoreUploadController@listdetail')->name('linestoreupload.listdetail');
        Route::get('/linestoreupload/listdetail2', [LineStoreUploadController::class, 'listdetail2'])->name('linestoreupload.listdetail2');
        Route::post('/create', 'LineStoreUploadController@store')->name('linestoreupload.store');
        Route::get('/edit', 'LineStoreUploadController@edit')->name('linestoreupload.edit');
        Route::post('/delete', 'LineStoreUploadController@destroy')->name('linestoreupload.destroy');
        Route::post('/deleteline', 'LineStoreUploadController@destroyline')->name('linestoreupload.destroyline');
        Route::post('/update', 'LineStoreUploadController@update')->name('linestoreupload.update');
        Route::get('/export', 'LineStoreUploadController@export')->name('linestoreupload.export');
        Route::post('/import-monthly', [LineStoreUploadController::class, 'importDnLs'])->name('importDnLs');
        Route::post('/linestoreupload/generateMultipleQrCodes', [LineStoreUploadController::class, 'generateMultipleQrCodes'])->name('linestoreupload.generateMultipleQrCodes');

        // Route::post('/export-monthly', [RmDnIncomingController::class, 'exportDn'])->name('exportDn');
    });

    Route::group(['prefix' => 'tabelstoksbc'], function () {
        Route::get('/', 'TabelStokSbcController@index')->name('tabelstoksbc.index');
        Route::get('/list', 'TabelStokSbcController@list')->name('tabelstoksbc.list');
        Route::post('/create', 'TabelStokSbcController@store')->name('tabelstoksbc.store');
        Route::get('/edit', 'TabelStokSbcController@edit')->name('tabelstoksbc.edit');
        Route::post('/update', 'TabelStokSbcController@update')->name('tabelstoksbc.update');
        Route::post('/delete', 'TabelStokSbcController@destroy')->name('tabelstoksbc.destroy');
        Route::post('/import-Dp', [TabelStokSbcController::class, 'importSbc'])->name('tabelstoksbc.importSbc');
        Route::get('users/export', 'TabelStokSbcController@formatsbc')->name('formatsbc.export');
        Route::get('users/export2', 'TabelStokSbcController@export2')->name('datatabelstoksbc.export');
    });


    Route::group(['prefix' => 'dashboard1ls'], function () {
        Route::get('/', 'Dashboard1LsController@index')->name('dashboard1ls.index');
        Route::get('/get-scanout-data', 'Dashboard1LsController@getScanOutData')->name('dashboard1ls.getScanOutData');

        // routes/web.php
    });

    Route::group(['prefix' => 'blankstok'], function () {
        Route::get('/', 'TabelStokBlankController@index')->name('blankstok.index');
        Route::get('/list', 'TabelStokBlankController@list')->name('blankstok.list');
        Route::post('/create', 'TabelStokBlankController@store')->name('blankstok.store');
        Route::get('/edit', 'TabelStokBlankController@edit')->name('blankstok.edit');
        Route::get('/blankstok/detail', [TabelStokBlankController::class, 'detail'])->name('blankstok.detail');
        Route::post('/update', 'TabelStokBlankController@update')->name('blankstok.update');
        Route::post('/delete', 'TabelStokBlankController@destroy')->name('blankstok.destroy');
        Route::get('users/export', 'TabelStokBlankController@export')->name('blankstok.export');
        Route::post('/import-blank', 'TabelStokBlankController@importBlank')->name('blankstok.importBlank');
        Route::post('/export-Blank', [TabelStokBlankController::class, 'importBlank'])->name('partname.importBlank');

        Route::get('/blankstok/detail-out', [TabelStokBlankController::class, 'detailOut'])->name('blankstok.detailOut');

    });

    Route::group(['prefix' => 'taglabelblank'], function () {
        Route::get('/', 'TagLabelBlankController@index')->name('taglabelblank.index');
        Route::get('/list', 'TagLabelBlankController@list')->name('taglabelblank.list');
        Route::get('/listdetail', 'TagLabelBlankController@listdetail')->name('taglabelblank.listdetail');
        Route::post('/create', 'TagLabelBlankController@store')->name('taglabelblank.store');
        Route::get('/edit', 'TagLabelBlankController@edit')->name('taglabelblank.edit');
        Route::post('/submit', 'TagLabelBlankController@submit')->name('taglabelblank.submit');
        Route::post('/delete', 'TagLabelBlankController@destroy')->name('taglabelblank.destroy');
        Route::post('/deleteline', 'TagLabelBlankController@destroyline')->name('taglabelblank.destroyline');
        Route::post('/update', 'TagLabelBlankController@update')->name('taglabelblank.update');
        Route::get('/export', 'TagLabelBlankController@export')->name('taglabelblank.export');
        Route::get('/taglabelblank/cetak/{id}', 'TagLabelBlankController@cetak')->name('taglabelblank.cetak');
        Route::get('/printDetail', 'TagLabelBlankController@printDetail')->name('taglabelblank.printDetail');
        Route::get('/getdoc', 'TagLabelBlankController@getdoc')->name('taglabelblank.getdoc');
        Route::post('/submit', 'TagLabelBlankController@submit')->name('taglabelblank.submit');
        Route::post('/delete_draft', 'TagLabelBlankController@delete_draft')->name('taglabelblank.delete_draft');
        Route::get('/taglabel/print/{doc_no}', [TagLabelBlankController::class, 'printPdf'])->name('taglabelblank.print');
        Route::post('/get-taglabel-by-doc-no', [TagLabelBlankController::class, 'getLabelDoc'])->name('getLabelDoc');
        // Route::post('/update-qty-in', [TagLabelBlankController::class, 'updateQtyIndn'])->name('updateQtyIndn');
        Route::get('/get-qty-in', [TagLabelBlankController::class, 'getQtyIn'])->name('getQtyIn');
        // Route::get('/get-kode-material', 'TagLabelBlankController@getKodeMaterial')->name('taglabelblank.getKodeMaterial');
        Route::get('/get-kode-material', [TagLabelBlankController::class, 'getKodeMaterial'])->name('taglabelblank.getKodeMaterial');
        Route::get('/get-qty-blank', 'TagLabelBlankController@getQtyBlank')->name('taglabelblank.getQtyBlank');
        Route::get('/get-uniq-nos', 'TagLabelBlankController@getPartNos')->name('taglabelblank.getPartNos');
        Route::post('/taglabelblank/update-qty', [TagLabelBlankController::class, 'updateQtyBlank'])->name('taglabelblank.updateQtyBlank');
        Route::get('/get-material-codes', [TagLabelBlankController::class, 'getMaterialCodes'])->name('taglabelblank.getMaterialCodes');
        // Route::post('/get-scan', [TagLabelBlankController::class, 'getScanInData'])->name('taglabelblank.getScanInData');
        // Route::post('/taglabelblank/getScanInData', [App\Http\Controllers\TagLabelBlankController::class, 'getScanInData'])->name('taglabelblank.getScanInData');
        // Route::get('/taglabelblank/label/{id}', [TagLabelBlankController::class, 'label'])->name('taglabelblank.label');
    });




    Route::group(['prefix' => 'dashboard1'], function () {
        Route::get('/', 'PcStoreDashboard1Controller@index')->name('dashboard1.index');
        Route::get('/getSafe', 'PcStoreDashboard1Controller@getMinimalOverActual')->name('dashboard1.getMinimalOverActual');
        Route::get('/getWarning', 'PcStoreDashboard1Controller@getWarning')->name('dashboard1.getWarning');
        Route::get('/getDanger', 'PcStoreDashboard1Controller@getDanger')->name('dashboard1.getDanger');
        Route::get('/totalPart', 'PcStoreDashboard1Controller@totalPart')->name('dashboard1.totalPart');
        Route::get('/totalPart2', 'PcStoreDashboard1Controller@totalPart2')->name('dashboard1.totalPart2');
        Route::get('/stock-chart-data', [PcStoreDashboard1Controller::class, 'getStockChartData'])->name('stock.chart.data');
        Route::get('/out-stamping-data', [PcStoreDashboard1Controller::class, 'outStampingData'])->name('outStamping.data');
        Route::get('/orders/data', [PcStoreDashboard1Controller::class, 'getData'])->name('getData.data');
        // Route::get('/api/stock-minimal-over-actual', [PcStoreDashboard1Controller::class, 'getMinimalOverActual']);
        Route::get('/pc-store-directs-refresh', [PcStoreDashboard1Controller::class, 'refreshData'])->name('pc-store-directs.refresh');
    });


    Route::group(['prefix' => 'uploadforcast'], function () {
        Route::get('/', 'UploadForcastController@index')->name('uploadforcast.index');
        Route::get('/list', 'UploadForcastController@list')->name('uploadforcast.list');
        Route::get('/listdetail', 'UploadForcastController@listdetail')->name('uploadforcast.listdetail');
        Route::post('/create', 'UploadForcastController@store')->name('uploadforcast.store');
        Route::get('/edit', 'UploadForcastController@edit')->name('uploadforcast.edit');
        Route::post('/update', 'UploadForcastController@update')->name('uploadforcast.update');
        Route::post('/delete', 'UploadForcastController@destroy')->name('uploadforcast.destroy');
        Route::post('/import-Dp', [UploadForcastController::class, 'importDp'])->name('uploadforcast.importDp');
        Route::get('users/export', 'UploadForcastController@export')->name('uploadforcastdata.export');
        Route::get('users/export2', 'UploadForcastController@export2')->name('uploadforcastformat.export');
        Route::get('users/export3', 'UploadForcastController@export3')->name('uploadforcastformat2.export3');
        Route::post('/upload-import', [UploadForcastController::class, 'importFile']);
        Route::post('/import-importforcast2', [UploadForcastController::class, 'importforcast2'])->name('uploadforcast.importforcast2');

    });

    Route::group(['prefix' => 'dashboardmps'], function () {
        Route::get('/', 'DashboardMpsController@index')->name('dashboardmps.index');
        Route::get('/getIncomingMaterials', 'DashboardMpsController@getIncomingMaterials')->name('dashboardrm.getIncomingMaterials');
        Route::get('/getLatestRmReturnMaterials', 'DashboardMpsController@getLatestRmReturnMaterials')->name('dashboardrm.getLatestRmReturnMaterials');
        Route::get('/getQtyPlan', 'DashboardMpsController@getQtyPlan')->name('dashboardmps.getQtyPlan');
        // Route::get('/get-progress-data', [DashboardMpsController::class, 'getProgressData']);
        Route::get('/getPlanningData', 'DashboardMpsController@getPlanningData')->name('dashboardmps.getPlanningData');
        Route::post('/materialTa', 'DashboardMpsController@materialTa')->name('dashboardmps.materialTa');
        Route::get('/getTransitData', 'DashboardMpsController@getTransitData')->name('dashboardmps.getTransitData');
        // Route::get('/api/rm-return-materials', [DashboardMpsController::class, 'getLatestRmReturnMaterials']);
    });


    Route::group(['prefix' => 'dashboardplanning'], function () {
        Route::get('/', 'DashboardPlanningC1@index')->name('dashboardplanning.index');
        Route::get('/getIncomingMaterials', 'DashboardPlanningC1@getIncomingMaterials')->name('dashboardplanning.getIncomingMaterials');
        Route::get('/getLatestRmReturnMaterials', 'DashboardPlanningC1@getLatestRmReturnMaterials')->name('dashboardplanning.getLatestRmReturnMaterials');
        Route::get('/getLatestPlanningData', 'DashboardPlanningC1@getLatestPlanningData')->name('dashboardplanning.getLatestPlanningData');
        Route::post('/updateStatusProses', 'DashboardPlanningC1@updateStatusProses')->name('dashboardplanning.updateStatusProses');
        Route::get('/getTransitData', 'DashboardPlanningC1@getTransitData')->name('dashboardplanning.getTransitData');
        Route::get('/get-rm-info', [DashboardPlanningC1::class, 'getRMInfo'])->name('get.rm.info');
        Route::post('/rmreturn/accepted', 'DashboardPlanningC1@accepted2')->name('rmreturn.accepted2');
        Route::post('/cancel-production', [DashboardPlanningC1::class, 'cancelProduction'])->name('planninglineb3.cancelProduction');
        Route::post('/remark-production', [DashboardPlanningC1::class, 'updateDescription'])->name('planninglineb3.updateRemark');
        Route::get('/rmreturn/getPartNoOptions3', [DashboardPlanningC1::class, 'getPartNoOptions3'])->name('rmreturn.getPartNoOptions3');
        Route::get('/dashboardplanning/line-b3-data', 'DashboardPlanningC1@lineB3Data')->name('lineb3.data');
        Route::get('/dashboardplanning/line-c1-data', 'DashboardPlanningC1@lineC1Data')->name('linec1.data');
        Route::get('/dashboardplanning/line-c2-data', 'DashboardPlanningC1@lineC2Data')->name('linec2.data');
        Route::get('/export', 'DashboardPlanningC1@export')->name('dashboardplanning.export');
        Route::get('/cek-proses-mesin', [DashboardPlanningC1::class, 'cekProsesMesin'])->name('dashboardplanning.cekProsesMesin');
        Route::get('/get-dies-history', [DashboardPlanningC1::class, 'getDiesHistory'])->name('dashboardplanning.getDiesHistory');
        Route::get('/get-maintenance-history', [DashboardPlanningC1::class, 'getMaintenanceHistory'])->name('dashboardplanning.getMaintenanceHistory');
        Route::get('/get-machine-condition', [DashboardPlanningC1::class, 'getMachineCondition'])->name('dashboardplanning.getMachineCondition');
        Route::post('/approve-production', [DashboardPlanningC1::class, 'approveProduction'])->name('dashboardplanning.approveProduction');
        Route::get('/get-actual-production/{id}', [DashboardPlanningC1::class, 'getActualProduction'])->name('dashboardplanning.getActualProduction');

        // Route::post('planning-line/update-status-proses/{id}', [PlanningController::class, 'updateStatusProses']);
        // Route::get('/pc-store-directs-refresh', [PcStoreDashboard1Controller::class, 'refreshData'])->name('pc-store-directs.refresh');
    });


    Route::group(['prefix' => 'dashboardplanningb12'], function () {
        Route::get('/', 'DashboardPlanningB12@index')->name('dashboardplanningb12.index');
        Route::get('/getIncomingMaterials', 'DashboardPlanningB12@getIncomingMaterials')->name('dashboardplanningb12.getIncomingMaterials');
        Route::get('/getLatestRmReturnMaterials', 'DashboardPlanningB12@getLatestRmReturnMaterials')->name('dashboardplanningb12.getLatestRmReturnMaterials');
        Route::get('/getLatestPlanningData', 'DashboardPlanningB12@getLatestPlanningData')->name('dashboardplanningb12.getLatestPlanningData');
        Route::post('/updateStatusProses', 'DashboardPlanningB12@updateStatusProses')->name('dashboardplanningb12.updateStatusProses');
        Route::get('/getTransitData', 'DashboardPlanningB12@getTransitData')->name('dashboardplanningb12.getTransitData');
        Route::get('/get-rm-info', [DashboardPlanningB12::class, 'getRMInfo'])->name('get.rm.infob12');
        Route::post('/approve-production', 'DashboardPlanningB12@approveProduction')->name('dashboardplanningb12.approveProduction');
        Route::post('/cancel-production', [DashboardPlanningB12::class, 'cancelProduction'])->name('dashboardplanningb12.cancelProduction');
        Route::post('/remark-production', [DashboardPlanningB12::class, 'updateDescription'])->name('dashboardplanningb12.updateRemark');
        Route::get('/dashboardplanning/line-b1-data', 'DashboardPlanningB12@lineB1Data')->name('lineb1.data');
        Route::get('/dashboardplanning/line-b2-data', 'DashboardPlanningB12@lineB2Data')->name('lineb2.data');
        Route::get('/cek-proses-mesin', [DashboardPlanningB12::class, 'cekProsesMesin'])->name('dashboardplanningb12.cekProsesMesin');
        Route::get('/get-actual-production/{id}', 'DashboardPlanningB12@getActualProduction')->name('dashboardplanningb12.getActualProduction');
        Route::get('/export', 'DashboardPlanningB12@export')->name('dashboardplanningb12.export');
        Route::get('/get-3n-delivery', [DashboardPlanningB12::class, 'get3nDelivery'])->name('dashboardplanningb12.get3nDelivery');
        Route::get('/get-dies-history', [DashboardPlanningB12::class, 'getDiesHistory'])->name('dashboardplanningb12.getDiesHistory');
        Route::get('/get-maintenance-history', [DashboardPlanningB12::class, 'getMaintenanceHistory'])->name('dashboardplanningb12.getMaintenanceHistory');
        Route::get('/get-machine-condition', [DashboardPlanningB12::class, 'getMachineCondition'])->name('dashboardplanningb12.getMachineCondition');
    });

    Route::group(['prefix' => 'dashboardplanninga12'], function () {
        Route::get('/', 'DashboardPlanningA12@index')->name('dashboardplanninga12.index');
        Route::get('/getIncomingMaterials', 'DashboardPlanningA12@getIncomingMaterials')->name('dashboardplanninga12.getIncomingMaterials');
        Route::get('/getLatestRmReturnMaterials', 'DashboardPlanningA12@getLatestRmReturnMaterials')->name('dashboardplanninga12.getLatestRmReturnMaterials');
        Route::get('/getLatestPlanningData', 'DashboardPlanningA12@getLatestPlanningData')->name('dashboardplanninga12.getLatestPlanningData');
        Route::post('/updateStatusProses', 'DashboardPlanningA12@updateStatusProses')->name('dashboardplanninga12.updateStatusProses');
        Route::get('/getTransitData', 'DashboardPlanningA12@getTransitData')->name('dashboardplanninga12.getTransitData');
        Route::get('/get-rm-info', [DashboardPlanningA12::class, 'getRMInfo'])->name('get.rm.infoa12');
        Route::post('/approve-production', 'DashboardPlanningA12@approveProduction')->name('dashboardplanninga12.approveProduction');
        Route::post('/cancel-production', [DashboardPlanningA12::class, 'cancelProduction'])->name('dashboardplanninga12.cancelProduction');
        Route::post('/remark-production', [DashboardPlanningA12::class, 'updateDescription'])->name('dashboardplanninga12.updateRemark');
        Route::get('/dashboardplanning/line-a1-data', 'DashboardPlanningA12@lineA1Data')->name('linea1.data');
        Route::get('/dashboardplanning/line-a2-data', 'DashboardPlanningA12@lineA2Data')->name('linea2.data');
        Route::get('/cek-proses-mesin', [DashboardPlanningA12::class, 'cekProsesMesin'])->name('dashboardplanninga12.cekProsesMesin');
        Route::get('/get-actual-production/{id}', 'DashboardPlanningA12@getActualProduction')->name('dashboardplanninga12.getActualProduction');
        Route::get('/export', 'DashboardPlanningA12@export')->name('dashboardplanninga12.export');
        Route::get('/get-dies-history', [DashboardPlanningA12::class, 'getDiesHistory'])->name('dashboardplanninga12.getDiesHistory');
        Route::get('/get-maintenance-history', [DashboardPlanningA12::class, 'getMaintenanceHistory'])->name('dashboardplanninga12.getMaintenanceHistory');
        Route::get('/get-machine-condition', [DashboardPlanningA12::class, 'getMachineCondition'])->name('dashboardplanninga12.getMachineCondition');
        // Route::post('planning-line/update-status-proses/{id}', [PlanningController::class, 'updateStatusProses']);
        // Route::get('/pc-store-directs-refresh', [PcStoreDashboard1Controller::class, 'refreshData'])->name('pc-store-directs.refresh');
    });

    Route::group(['prefix' => 'dashboardplanningatransfers'], function () {
        Route::get('/', 'DashboardPlanningTransfer@index')->name('dashboardplanningatransfers.index');
        Route::get('/getIncomingMaterials', 'DashboardPlanningTransfer@getIncomingMaterials')->name('dashboardplanningatransfers.getIncomingMaterials');
        Route::get('/getLatestRmReturnMaterials', 'DashboardPlanningTransfer@getLatestRmReturnMaterials')->name('dashboardplanningatransfers.getLatestRmReturnMaterials');
        Route::get('/getLatestPlanningData', 'DashboardPlanningTransfer@getLatestPlanningData')->name('dashboardplanningatransfers.getLatestPlanningData');
        Route::post('/updateStatusProses', 'DashboardPlanningTransfer@updateStatusProses')->name('dashboardplanningatransfers.updateStatusProses');
        Route::get('/getTransitData', 'DashboardPlanningTransfer@getTransitData')->name('dashboardplanningatransfers.getTransitData');
        Route::get('/get-rm-info', [DashboardPlanningTransfer::class, 'getRMInfo'])->name('get.rm.infotransfers');
        Route::post('/approve-production', 'DashboardPlanningTransfer@approveProduction')->name('dashboardplanningatransfers.approveProduction');
        Route::post('/cancel-production', [DashboardPlanningTransfer::class, 'cancelProduction'])->name('dashboardplanningatransfers.cancelProduction');
        Route::post('/remark-production', [DashboardPlanningTransfer::class, 'updateDescription'])->name('dashboardplanningatransfers.updateRemark');
        Route::get('/dashboardplanning/line-a1-data', 'DashboardPlanningTransfer@lineTransfersData')->name('linetransfers.data');
        // Route::get('/dashboardplanning/line-a2-data', 'DashboardPlanningTransfer@lineB2Data')->name('linea2.data');
        Route::get('/cek-proses-mesin', [DashboardPlanningTransfer::class, 'cekProsesMesin'])->name('dashboardplanningatransfers.cekProsesMesin');
        Route::get('/get-actual-production/{id}', 'DashboardPlanningTransfer@getActualProduction')->name('dashboardplanningatransfers.getActualProduction');
        Route::get('/get-dies-history', [DashboardPlanningTransfer::class, 'getDiesHistory'])->name('dashboardplanningatransfers.getDiesHistory');
        Route::get('/get-maintenance-history', [DashboardPlanningTransfer::class, 'getMaintenanceHistory'])->name('dashboardplanningatransfers.getMaintenanceHistory');
        Route::get('/get-machine-condition', [DashboardPlanningTransfer::class, 'getMachineCondition'])->name('dashboardplanningatransfers.getMachineCondition');
        // Route::post('planning-line/update-status-proses/{id}', [PlanningController::class, 'updateStatusProses']);
        // Route::get('/pc-store-directs-refresh', [PcStoreDashboard1Controller::class, 'refreshData'])->name('pc-store-directs.refresh');
    });

    Route::group(['prefix' => 'dashboardplanningblank'], function () {
        Route::get('/', 'DashboardPlanningBlank@index')->name('dashboardplanningblank.index');
        Route::get('/getIncomingMaterials', 'DashboardPlanningBlank@getIncomingMaterials')->name('dashboardplanningblank.getIncomingMaterials');
        Route::get('/getLatestRmReturnMaterials', 'DashboardPlanningBlank@getLatestRmReturnMaterials')->name('dashboardplanningblank.getLatestRmReturnMaterials');
        Route::get('/getLatestPlanningData', 'DashboardPlanningBlank@getLatestPlanningData')->name('dashboardplanningblank.getLatestPlanningData');
        Route::post('/updateStatusProses', 'DashboardPlanningBlank@updateStatusProses')->name('dashboardplanningblank.updateStatusProses');
        Route::get('/getTransitData', 'DashboardPlanningBlank@getTransitData')->name('dashboardplanningblank.getTransitData');
        Route::post('/approve-production', 'DashboardPlanningBlank@approveProduction')->name('dashboardplanningblank.approveProduction');
        Route::post('/cancel-production', [DashboardPlanningBlank::class, 'cancelProduction'])->name('dashboardplanningblank.cancelProduction');
        Route::post('/remark-production', [DashboardPlanningBlank::class, 'updateDescription'])->name('dashboardplanningblank.updateRemark');
        Route::get('/cek-proses-mesin', [DashboardPlanningBlank::class, 'cekProsesMesin'])->name('dashboardplanningblank.cekProsesMesin');
        Route::get('/get-actual-production/{id}', 'DashboardPlanningBlank@getActualProduction')->name('dashboardplanningblank.getActualProduction');
    });

    Route::group(['prefix' => 'dashboardducking'], function () {
        Route::get('/', 'DashboardDuckingController@index')->name('dashboardducking.index');
        // Route::get('/pc-store-directs-refresh', [PcStoreDashboard1Controller::class, 'refreshData'])->name('pc-store-directs.refresh');
    });


    Route::group(['prefix' => 'dashboard2'], function () {
        Route::get('/', 'Dashbaord2Controller@index')->name('dashboard2.index');     // routes/web.php
        Route::get('/dashboard/data', [Dashbaord2Controller::class, 'getDashboardData'])->name('dashboard2.data');
        // Route::get('/pc-store-directs-refresh', [PcStoreDashboard1Controller::class, 'refreshData'])->name('pc-store-directs.refresh');
    });

    Route::group(['prefix' => 'boardd26'], function () {
        Route::get('/', 'DashbaordBoard26Controller@index')->name('boardd26.index');     // routes/web.php
        Route::get('/api/press-data', [DashbaordBoard26Controller::class, 'getPressDataJson'])->name('press.data.json');
        Route::get('/api/subassy-data', [DashbaordBoard26Controller::class, 'getSubassyDataJson'])->name('subassy.data.json');
        Route::get('/api/nut-data', [DashbaordBoard26Controller::class, 'getNutDataJson'])->name('nut.data.json');
        Route::get('/rekap-orders/{id}', [DashbaordBoard26Controller::class, 'show'])->name('rekaporders.show');
    });

    Route::group(['prefix' => 'boardd26adm2'], function () {
        Route::get('/', 'DashbaordBoard26Adm2Controller@index')->name('boardd26adm2.index');     // routes/web.php
        Route::get('/api/press-data', [DashbaordBoard26Adm2Controller::class, 'getPressDataAdm2'])->name('press.data.adm2');
        Route::get('/api/subassy-data', [DashbaordBoard26Adm2Controller::class, 'getSubassyDataAdm2'])->name('subassy.data.adm2');
        Route::get('/api/nut-data', [DashbaordBoard26Adm2Controller::class, 'getNutDataAdm2'])->name('nut.data.adm2');
        Route::get('/rekap-orders/{id}', [DashbaordBoard26Adm2Controller::class, 'showadm2'])->name('rekaporders.adm2');
        // Route::get('/relay/activate/{relay?}', [DashbaordBoard26AdmController::class, 'activate']);
        // Route::post('/relay/on', [DashbaordBoard26Controller::class, 'on'])->name('relay.on');
    });


    Route::group(['prefix' => 'boardd26adm'], function () {
        Route::get('/', 'DashbaordBoard26AdmController@index')->name('boardd26adm.index');     // routes/web.php
        Route::get('/api/press-data', [DashbaordBoard26AdmController::class, 'getPressDataAdm'])->name('press.data.adm');
        Route::get('/api/subassy-data', [DashbaordBoard26AdmController::class, 'getSubassyDataAdm'])->name('subassy.data.adm');
        Route::get('/api/nut-data', [DashbaordBoard26AdmController::class, 'getNutDataAdm'])->name('nut.data.adm');
        Route::get('/rekap-orders/{id}', [DashbaordBoard26AdmController::class, 'showadm'])->name('rekaporders.adm');
        Route::get('/api/get-tracking-status', [DashbaordBoard26AdmController::class, 'getTrackingStatus'])->name('boardd26adm.trackingStatus');
        // Route::get('/relay/activate/{relay?}', [DashbaordBoard26AdmController::class, 'activate']);
        // Route::post('/relay/on', [DashbaordBoard26Controller::class, 'on'])->name('relay.on');
    });

    Route::group(['prefix' => 'boardadmp4'], function () {
        Route::get('/', 'DashbaordBoardAdmP4Controller@index')->name('boardadmp4.index');     // routes/web.php
        Route::get('/api/press-data', [DashbaordBoardAdmP4Controller::class, 'getPressDataAdm'])->name('press.data.admp4');
        Route::get('/api/subassy-data', [DashbaordBoardAdmP4Controller::class, 'getSubassyDataAdm'])->name('subassy.data.admp4');
        Route::get('/api/nut-data', [DashbaordBoardAdmP4Controller::class, 'getNutDataAdm'])->name('nut.data.admp4');
        Route::get('/rekap-orders/{id}', [DashbaordBoardAdmP4Controller::class, 'showadm'])->name('rekaporders.admp4');
        // Route::get('/relay/activate/{relay?}', [DashbaordBoard26AdmController::class, 'activate']);
        // Route::post('/relay/on', [DashbaordBoard26Controller::class, 'on'])->name('relay.on');
    });




    Route::group(['prefix' => 'dashboardrm'], function () {
        // Route::get('/dashboard/rm', [RmDashboardController::class, 'index'])->name('dashboard.rm');
        Route::get('/', 'RmDashboardController@index')->name('dashboardrm.index');
        Route::get('/detail', 'RmDashboardController@detail')->name('dashboardrm.detail');
        Route::post('/update', 'RmDnIncomingController@update')->name('dashboardrm.update');
        Route::get('/dashboardrm/cetak/{id}', [RmDashboardController::class, 'cetak'])->name('dashboardrm.cetak');
        Route::post('/update-qty-in', [RmDnIncomingController::class, 'updateTotal'])->name('updateTotal');
        Route::get('/fetch-part-no', [RmDnIncomingController::class, 'fetchPartNo']);
        Route::get('/count', 'RmDashboardController@count')->name('dashboardrm.count');
        Route::get('/close', 'RmDashboardController@close')->name('dashboardrm.close');
        Route::get('/getSupplierData', 'RmDashboardController@getSupplierData')->name('dashboardrm.getSupplierData');
        Route::get('/getSupplierData2', 'RmDashboardController@getSupplierData2')->name('dashboardrm.getSupplierData2');
        Route::get('/getSupplierData3', 'RmDashboardController@getSupplierData3')->name('dashboardrm.getSupplierData3');
        Route::post('/dnIncoming/export', [RmDashboardController::class, 'export'])->name('dnIncoming.export');
        Route::get('/dashboardrm/detail2', [RmDashboardController::class, 'detail2'])->name('dashboardrm.detail2');
        Route::post('/dashboardrm/update', [RmDashboardController::class, 'update2'])->name('dashboardrm.update2');
        Route::post('/insertPartNo', 'RmDashboardController@insertPartNo')->name('dashboardrm.insertPartNo');
        Route::post('/dashboardrm/generate-multiple-qrcodes', [RmDashboardController::class, 'generateMultipleQrCodes'])->name('dashboardrm.generateMultipleQrCodes');
        Route::get('/dashboard-data', [RmDashboardController::class, 'getDashboardData'])->name('dashboardrm.getDashboardData');
        Route::get('/monthlyUpload', 'RmDashboardController@monthlyUpload')->name('dashboardrm.monthlyUpload');
        Route::get('/edit', 'RmDashboardController@edit')->name('dashboardrm.edit');
        Route::post('/deleteline', 'RmDashboardController@destroyline')->name('dashboardrm.destroyline');
        Route::post('/update', 'RmDashboardController@update')->name('dashboardrm.update');
        Route::get('/fetchData', 'RmDashboardController@fetchData')->name('dashboardrm.fetchData');
        // Route::get('/chart-data', [RmDashboardController::class, 'getChartData']);
        Route::get('/dashboardrm/getChartData', [RmDashboardController::class, 'getChartData'])->name('dashboardrm.getChartData');
        Route::get('/dashboardrm/getScanData', [RmDashboardController::class, 'getScanData'])->name('dashboardrm.getScanData');
    });


    Route::group(['prefix' => 'uploadmonthly'], function () {
        Route::get('/', 'RmUploadMonthlyController@index')->name('uploadmonthly.index');
    });

    Route::group(['prefix' => 'dashboardrmstok'], function () {
        Route::get('/', 'RmDashboardStokController@index')->name('dashboardrmstok.index');
        Route::get('/detail', 'RmDashboardStokController@detail')->name('dashboardrmstok.detail');
        Route::get('/detail2', 'RmDashboardStokController@detail2')->name('dashboardrmstok.detail2');
        Route::get('/safeData', 'RmDashboardStokController@getSafeData')->name('dashboardrmstok.getSafeData');
        Route::get('/CritcalData', 'RmDashboardStokController@getCritcalData')->name('dashboardrmstok.getCritcalData');
        Route::get('/getPartTa', 'RmDashboardStokController@getPartTa')->name('dashboardrmstok.getPartTa');
        Route::get('/dashboardrmstok/getRunOut', 'RmDashboardStokController@getRunOut')->name('dashboardrmstok.getRunOut');
        Route::post('/export', 'RmDashboardStokController@export')->name('dashboardrmstok.export');
        Route::get('/export2', 'RmDashboardStokController@export2')->name('dashboardrmstok.export2');
        Route::get('/export3', 'RmDashboardStokController@export3')->name('dashboardrmstok.export3');
        Route::get('/dashboardrmstok/getDocPo', 'RmDashboardStokController@getDocPo')->name('dashboardrmstok.getDocPo');
        Route::get('/dashboardrmstok/getPartDetails', [RmDashboardStokController::class, 'getPartDetails'])->name('dashboardrmstok.getPartDetails');
        Route::get('/dn_inputs/update', [RmDashboardStokController::class, 'getDnInputs'])->name('dnInputs.update');
        Route::get('/scan_out_rms/update2', [RmDashboardStokController::class, 'getScanOutRms'])->name('scanOutRms.update2');
        Route::get('/scan_out_rms/update3', [RmDashboardStokController::class, 'getScanOutSubcont'])->name('scanOutSubcont.update3');
        Route::get('/dashboardrmstok/cetak/{uniqNo}', [RmDashboardStokController::class, 'cetak'])->name('dashboardrmstok.cetak');
        // Route::post('/dnIncoming/export', [RmDashboardController::class, 'export'])->name('dnIncoming.export');
        // Route::get('/dashboardrmstok/safeData', [RmDashboardStokController::class, 'getSafeData'])->name('dashboardrmstok.safeData');

    });


    Route::group(['prefix' => 'dashboardnut'], function () {
        Route::get('/', 'DashboardNutController@index')->name('dashboardnut.index');
    });

    Route::group(['prefix' => 'dshstoktmmin'], function () {
        Route::get('/', 'DshStokD26TmminController@index')->name('dshstoktmmin.index');
        Route::get('/pc-store-data-adm', [DshStokD26TmminController::class, 'getDataAdm'])->name('pcstore.dataTmmin');
        Route::get('/welding-data', [DshStokD26TmminController::class, 'getDataAdm2'])->name('scan_out_weldings.dataTmmin');
    });

    Route::group(['prefix' => 'dshstokd26adm'], function () {
        Route::get('/', 'DshStokD26AdmController@index')->name('dshstokd26adm.index');
        Route::get('/pc-store-data-adm', [DshStokD26AdmController::class, 'getDataAdm'])->name('pcstore.dataAdm');
        Route::get('/welding-data', [DshStokD26AdmController::class, 'getDataAdm2'])->name('scan_out_weldings.dataAdm');
    });

    Route::group(['prefix' => 'dshstokadmp4'], function () {
        Route::get('/', 'DshStokAdmP4Controller@index')->name('dshstokadmp4.index');
        Route::get('/pc-store-data-adm', [DshStokAdmP4Controller::class, 'getDataAdm'])->name('pcstore.dataAdmp4');
        Route::get('/welding-data', [DshStokAdmP4Controller::class, 'getDataAdm2'])->name('scan_out_weldings.dataAdmp4');
    });

    Route::group(['prefix' => 'dashboardwelding1'], function () {
        Route::get('/', 'DashboardWelding1Controller@index')->name('dashboardwelding1.index');
        Route::get('/dashboard-welding-data', [DashboardWelding1Controller::class, 'getData'])->name('dashboardwelding1.getData');
        Route::get('/job-detail', [DashboardWelding1Controller::class, 'getJobDetail'])->name('job.detail');

    });

    Route::group(['prefix' => 'pcstoredirect'], function () {
        Route::get('/', 'PcStoreStok1Controller@index')->name('pcstoredirect.index');
        Route::get('/list', 'PcStoreStok1Controller@list')->name('pcstoredirect.list');
        Route::post('/create', 'PcStoreStok1Controller@store')->name('pcstoredirect.store');
        Route::get('/edit', 'PcStoreStok1Controller@edit')->name('pcstoredirect.edit');
        Route::post('/update', 'PcStoreStok1Controller@update')->name('pcstoredirect.update');
        Route::post('/delete', 'PcStoreStok1Controller@destroy')->name('pcstoredirect.destroy');
        Route::post('/importData', 'PcStoreStok1Controller@importData')->name('pcstoredirect.importData');
        Route::post('/importPcs', 'PcStoreStok1Controller@importPcs')->name('pcstoredirect.importPcs');
        Route::get('/export', 'PcStoreStok1Controller@export')->name('pcstoreexport.export');
    });

    Route::group(['prefix' => 'materialb3'], function () {
        Route::get('/', 'Materialb3Controller@index')->name('materialb3.index');
        Route::get('/list', 'Materialb3Controller@list')->name('materialb3.list');
        Route::post('/update', 'Materialb3Controller@update')->name('materialb3.update');
        Route::post('/delete', 'Materialb3Controller@destroy')->name('materialb3.destroy');
    });

    Route::group(['prefix' => 'scan'], function () {
        Route::get('/', 'Scan1Controller@index')->name('scan.index');
    });

    Route::group(['prefix' => 'scan2'], function () {
        Route::get('/', 'Scan2Controller@index')->name('scan2.index');
        Route::post('/saveScanResult', 'ScanNutController@saveScanResult')->name('scan2.saveScanResult');
    });

    Route::group(['prefix' => 'scan3'], function () {
        Route::get('/', 'Scan3Controller@index')->name('scan3.index');
        Route::post('/saveScanOutResult', 'ScanNutOutController@saveScanOutResult')->name('scan3.saveScanOutResult');
    });

    Route::group(['prefix' => 'scan4'], function () {
        Route::get('/', 'Scan4Controller@index')->name('scan4.index');
    });

    Route::group(['prefix' => 'tracesswnut'], function () {
        Route::get('/', 'RmTraceSswController@index')->name('tracesswnut.index');
        Route::get('/list', 'RmTraceSswController@list')->name('tracesswnut.list');

    });

    Route::group(['prefix' => 'trackingloc'], function () {
        Route::get('/', 'TrackingProsesController@index')->name('trackingloc.index');
        Route::post('/tracking/search', 'TrackingProsesController@searchByUniqNo')->name('tracking.search');
        Route::get('/abilities/update', [TrackingProsesController::class, 'getUpdatedAbilities'])->name('abilities.update');
        Route::get('/getAbilityDetails/{uniqNo}', [TraceAbilityController::class, 'getAbilityDetails']);

    });

    Route::group(['prefix' => 'proses1'], function () {
        Route::get('/', 'Proses1Controller@index')->name('proses1.index');
        Route::get('/list', 'Proses1Controller@list')->name('proses1.list');
        Route::post('/update', 'Proses1Controller@update')->name('proses1.update');
        Route::post('/delete', 'Proses1Controller@destroy')->name('proses1.destroy');
    });


    Route::group(['prefix' => 'proses2'], function () {
        Route::get('/', 'TraceProses2Controller@index')->name('proses2.index');
        // Route::get('/list', 'TraceProses2Controller@list')->name('proses2.list');
        Route::post('/update', 'TraceProses2Controller@update')->name('proses2.update');
        Route::post('/delete', 'TraceProses2Controller@destroy')->name('proses2.destroy');
        // Route::get('/getDetail', 'TraceProses2Controller@getDetail')->name('proses2.getDetail');

        Route::get('/proses2/list', [TraceProses2Controller::class, 'list'])->name('proses2.list');
        Route::get('/proses2/detail/{id}/{part_no}', [TraceProses2Controller::class, 'detail'])->name('proses2.detail');


    });

    Route::group(['prefix' => 'prosesqr1'], function () {
        Route::get('/', 'ProsesQR1Controller@index')->name('prosesqr1.index');
        Route::get('/trace/{uniqNo}', [ProsesQR1Controller::class, 'getTraceByUniqNo'])->name('getTraceByUniqNo');


    });


    ////BASIS SCAN /////

    Route::group(['prefix' => 'scandnrm'], function () {
        Route::get('/', 'ScanDnRmController@index')->name('scandnrm.index');
    });

    Route::group(['prefix' => 'scanoutrm'], function () {
        Route::get('/', 'ScanOutRmController@index')->name('scanoutrm.index');
        Route::post('/store', 'ScanOutRmController@store')->name('scanoutrm.store');
        Route::post('/check-scan-exists', 'ScanOutRmController@checkIfExists')->name('scanoutrm.check');
        Route::post('/check-scan-checkLine', 'ScanOutRmController@checkPartInLine')->name('scanoutrm.checkLine');
        Route::post('/scanoutrm/checkShift', 'ScanOutRmController@checkShift')->name('scanoutrm.checkShift');
        // routes/web.php


    });

    Route::group(['prefix' => 'scanoutsubcont'], function () {
        Route::get('/', 'ScanOutSubcontController@index')->name('scanoutsubcont.index');
        Route::post('/store', 'ScanOutSubcontController@store')->name('scanoutsubcont.store');
    });

    ///SCAN STMPING///
    Route::group(['prefix' => 'scaninstmp'], function () {
        Route::get('/', 'ScanInStmpController@index')->name('scaninstmp.index');
        Route::post('/store2', 'ScanInStmpController@store2')->name('scaninstmp.store2');
        Route::get('/get-qty-stamping', [ScanInStmpController::class, 'getQtyStamping'])->name('get.qtyTransit');
        Route::get('/check-partno-planning', [ScanInStmpController::class, 'checkPartNoPlanning'])->name('check.partNoPlanning');
        Route::get('/check-uniqNoUsed', [ScanInStmpController::class, 'checkUniqNoUsed'])->name('check.uniqNoUsed');
    });


    Route::group(['prefix' => 'scaninstmpb12'], function () {
        Route::get('/', 'ScanInStmpB12Controller@index')->name('scaninstmpb12.index');
        Route::post('/store2', 'ScanInStmpB12Controller@store2')->name('scaninstmpb12.store2');
        Route::get('/get-qty-stamping', [ScanInStmpB12Controller::class, 'getQtyStamping'])->name('getB12.qtyTransit');
        Route::get('/check-partno-planning', [ScanInStmpB12Controller::class, 'checkPartNoPlanning'])->name('check.partNoPlanningB12');
        Route::get('/check-uniqNoUsed', [ScanInStmpB12Controller::class, 'checkUniqNoUsed'])->name('check.uniqNoUsedB12');
    });

    Route::group(['prefix' => 'scaninstmpa12'], function () {
        Route::get('/', 'ScanInStmpA12Controller@index')->name('scaninstmpa12.index');
        Route::post('/store2', 'ScanInStmpA12Controller@store2')->name('scaninstmpa12.store2');
        Route::get('/get-qty-stamping', [ScanInStmpA12Controller::class, 'getQtyStamping'])->name('getA12.qtyTransit');
        Route::get('/check-partno-planning', [ScanInStmpA12Controller::class, 'checkPartNoPlanning'])->name('check.partNoPlanningA12');
        Route::get('/check-uniqNoUsed', [ScanInStmpA12Controller::class, 'checkUniqNoUsed'])->name('check.uniqNoUsedA12');
    });

    Route::group(['prefix' => 'scaninstmptransfers'], function () {
        Route::get('/', 'ScanInStmpTransfersController@index')->name('scaninstmptransfers.index');
        Route::post('/store2', 'ScanInStmpTransfersController@store2')->name('scaninstmptransfers.store2');
        Route::get('/get-qty-stamping', [ScanInStmpTransfersController::class, 'getQtyStamping'])->name('getTransfers.qtyTransit');
        Route::get('/check-partno-planning', [ScanInStmpB12Controller::class, 'checkPartNoPlanning'])->name('check.partNoPlanningTrf');
        Route::get('/check-uniqNoUsed', [ScanInStmpB12Controller::class, 'checkUniqNoUsed'])->name('check.uniqNoUsedTrf');
    });

    Route::group(['prefix' => 'scanoutstmp'], function () {
        Route::get('/', 'ScanOutStmpController@index')->name('scanoutstmp.index');
        Route::post('/store', 'ScanOutStmpController@store')->name('scanoutstmp.store');
    });



    Route::group(['prefix' => 'scanreturnrm'], function () {
        Route::get('/', 'ScanReturnRmController@index')->name('scanreturnrm.index');
        Route::post('/store', 'ScanReturnRmController@store')->name('scanreturnrm.store');
        Route::get('/get-qty-stamping', [ScanReturnRmController::class, 'getQtyStamping'])->name('get.qty.stamping');
    });

    Route::group(['prefix' => 'scaninlabel'], function () {
        Route::get('/', 'ScanInLabelController@index')->name('scaninlabel.index');
        Route::post('/store', 'ScanInLabelController@store')->name('scaninlabel.store');
    });

    Route::group(['prefix' => 'scanoutwelding'], function () {
        Route::get('/', 'ScanOutWeldingController@index')->name('scanoutwelding.index');
        Route::post('/store', 'ScanOutWeldingController@store')->name('scanoutwelding.store');
    });

    Route::group(['prefix' => 'scaninpswelding'], function () {
        Route::get('/', 'ScanInPsWeldingController@index')->name('scaninpswelding.index');
        Route::post('/store', 'ScanInPsWeldingController@store')->name('scaninpswelding.store');
    });

    Route::group(['prefix' => 'scaninpswelding2'], function () {
        Route::get('/', 'ScanInPsWelding2Controller@index')->name('scaninpswelding2.index');
        Route::post('/store', 'ScanInPsWelding2Controller@store')->name('scaninpswelding2.store');
        Route::get('/scanpcstore/pending', 'ScanInPsWelding2Controller@getPendingItems')->name('scaninpswelding2.pending');
    });

    Route::group(['prefix' => 'scaninlabel2'], function () {
        Route::get('/', 'ScanInLabel2Controller@index')->name('scaninlabel2.index');
        Route::post('/store', 'ScanInLabel2Controller@store')->name('scaninlabel2.store');
    });

    ///SCAN out Stamping//
    Route::group(['prefix' => 'scaninpsdirect'], function () {
        Route::get('/', 'ScanInPsDirectController@index')->name('scaninpsdirect.index');
        Route::post('/store', 'ScanInPsDirectController@store')->name('scaninpsdirect.store');

    });

    Route::group(['prefix' => 'scanoutpcs'], function () {
        Route::get('/', 'ScanOutPcsController@index')->name('scanoutpcs.index');
        // Route::post('/submit-scan-out', [ScanOutPcsController::class, 'storeScannedData']);
        Route::post('/scanoutpcs/store', [ScanOutpcsController::class, 'store'])->name('scanoutpcs.store');
    });


    Route::group(['prefix' => 'linestorein'], function () {
        Route::get('/', 'LineStoreScanInController@index')->name('linestorein.index');
    });
    // <<---ini untuk yang repair--->>>>>
    Route::group(['prefix' => 'scaninlsrepair'], function () {
        Route::get('/', 'LineStoreScanInController@index')->name('scaninlsrepair.index');
        Route::post('/store', 'LineStoreScanInController@store')->name('scaninlsrepair.store');
        Route::post('/check', 'LineStoreScanInController@check')->name('scaninlsrepair.check');
    });

    // <<---ini untuk yang no repair--->>>>>
    Route::group(['prefix' => 'scaninls2'], function () {
        Route::get('/', 'ScanInLineStoreController@index')->name('scaninls2.index');
        Route::post('/store', 'ScanInLineStoreController@store')->name('scaninls2.store');
        Route::post('/checkRepair', 'ScanInLineStoreController@checkRepair')->name('scaninls2.checkRepair');
    });

    Route::group(['prefix' => 'scanoutls'], function () {
        Route::get('/', 'ScanOutLsController@index')->name('scanoutls.index');
        Route::post('/store', 'ScanOutLsController@store')->name('scanoutls.store');
    });

    Route::group(['prefix' => 'scaninblank'], function () {
        Route::get('/', 'ScanInBlankController@index')->name('scaninblank.index');
        Route::post('/store2', 'ScanInBlankController@store2')->name('scaninblank.store2');
        Route::get('/get-qty-stamping', [ScanInBlankController::class, 'getQtyStamping'])->name('getBlank.qtyTransit');
    });

    Route::group(['prefix' => 'scanoutblank'], function () {
        Route::get('/', 'ScanOutBlankController@index')->name('scanoutblank.index');
        Route::post('/store', 'ScanOutBlankController@store')->name('scanoutblank.store');
        Route::post('/get-available-lines', [ScanOutBlankController::class, 'getAvailableLines'])->name('getAvailableLines');
    });

    Route::group(['prefix' => 'scanoutblank2'], function () {
        Route::get('/', 'ScanOutBlank2Controller@index')->name('scanoutblank2.index');
        Route::post('/store', 'ScanOutBlank2Controller@store')->name('scanoutblank2.store');
        Route::post('/check-scan-exists', 'ScanOutBlank2Controller@checkIfExists')->name('scanoutblank2.check');
        Route::post('/check-scan-checkLine', 'ScanOutBlank2Controller@checkPartInLine')->name('scanoutblank2.checkLine');
    });

    Route::group(['prefix' => 'scanweldingpart'], function () {
        Route::get('/', 'ScanBpsPartController@index')->name('scanweldingpart.index');
        Route::post('/scanbps/store-batch', [ScanBpsPartController::class, 'storeBatch'])->name('scanbps.storeBatch');
        // routes/web.php
        Route::get('/getQtyActStmp', [ScanBpsPartController::class, 'getQtyActStmp'])->name('getQtyActStmp');
        Route::get('/mps-data', [ScanBpsPartController::class, 'getMpsPlannings'])->name('scanbps.mpsData');
        Route::get('/bom-data', [ScanBpsPartController::class, 'getBomDataByJobNo'])->name('scanbps.bomData');

    });

    Route::group(['prefix' => 'tabellistdies'], function () {
        Route::get('/', 'TabelListDiesController@index')->name('tabellistdies.index');
        Route::get('/list', 'TabelListDiesController@list')->name('tabellistdies.list');
        Route::post('/create', 'TabelListDiesController@store')->name('tabellistdies.store');
        Route::get('/edit', 'TabelListDiesController@edit')->name('tabellistdies.edit');
        Route::post('/update', 'TabelListDiesController@update')->name('tabellistdies.update');
        Route::post('/delete', 'TabelListDiesController@destroy')->name('tabellistdies.destroy');
        Route::get('users/export', 'TabelListDiesController@export')->name('formatlistdies.export');
        Route::get('users/export2', 'TabelListDiesController@export2')->name('datalistdies.export');
        Route::post('import/listdies', 'TabelListDiesController@importDp')->name('tabellistdies.importDp');

    });

    Route::group(['prefix' => 'tabelprev'], function () {
        Route::get('/', 'TabelPrevDiesController@index')->name('tabelprev.index');
        Route::get('/list', 'TabelPrevDiesController@list')->name('tabelprev.list');
        Route::post('/update', 'TabelPrevDiesController@update')->name('tabelprev.update');
        Route::post('/delete', 'TabelPrevDiesController@destroy')->name('tabelprev.destroy');
        Route::get('/week-detail', [TabelPrevDiesController::class, 'weekDetail'])->name('week.detail');
        Route::get('/diemtc/lkh/details', [LkhDiesMtcController::class, 'getHistory'])->name('diemtc.lkh.history');


    });

    Route::group(['prefix' => 'andonts'], function () {
        Route::get('/', 'DashboardAndonTsController@index')->name('andonts.index');
    });

    Route::group(['prefix' => 'andontanrian'], function () {
        Route::get('/', 'Andon2DieMtcController@index')->name('andontanrian.index');
        Route::get('/andon/dies/data', [Andon2DieMtcController::class, 'getDies'])->name('andon.dies.data');
        Route::get('/andon/today/data', [Andon2DieMtcController::class, 'getAndonToday'])->name('andon.dies.today');
        Route::get('/andon/lkh/today', [Andon2DieMtcController::class, 'getLkhToday'])->name('andon.lkh.today');
    });


    Route::group(['prefix' => 'dashboardsummarydies'], function () {
        Route::get('/', [DashboardSummaryDiesController::class, 'index'])->name('dashboardsummarydies.index');
        Route::get('/data', [DashboardSummaryDiesController::class, 'data'])->name('dashboardsummarydies.data');
    });


    Route::group(['prefix' => 'lkhdies'], function () {
        Route::get('/diemtc-lkh/pdf/{doc_job}', [LkhDiesMtcController::class, 'generatePdf2'])->where('doc_job', '.*')->name('diemtc.lkh.pdf');
        Route::get('/', 'LkhDiesMtcController@index')->name('lkhdies.index');
        Route::get('/list', 'LkhDiesMtcController@list')->name('lkhdies.list');
        Route::get('/listdetail', 'LkhDiesMtcController@listdetail')->name('lkhdies.listdetail');
        Route::post('/create', 'LkhDiesMtcController@store')->name('lkhdies.store');
        Route::get('/edit', 'LkhDiesMtcController@edit')->name('lkhdies.edit');
        Route::post('/delete', 'LkhDiesMtcController@destroy')->name('lkhdies.destroy');
        Route::post('/deleteline', 'LkhDiesMtcController@destroyline')->name('lkhdies.destroyline');
        Route::post('/update', 'LkhDiesMtcController@update')->name('lkhdies.update');
        Route::get('/export', 'LkhDiesMtcController@export')->name('lkhdies.export');
        Route::get('/getdoc', 'LkhDiesMtcController@getdoc')->name('lkhdies.getdoc');
        Route::get('/dies/list', 'LkhDiesMtcController@getList')->name('lkhdies.getList');
        Route::post('/lkhdies/refresh-stroke', 'LkhDiesMtcController@refreshStroke')->name('lkhdies.refreshStroke');
        Route::get('/lkhdies/pdf/{id}', [LkhDiesMtcController::class, 'generatePdf'])->name('lkhdies.pdf');
        Route::get('/dies/list-progress', [LkhDiesMtcController::class, 'getList'])->name('dies.list.progress');
        Route::get('/lkh/dies/history', [LkhDiesMtcController::class, 'getHistory'])->name('lkhdies.getHistory');


    });

    Route::group(['prefix' => 'scanraksatu'], function () {
        Route::get('/', 'ScanRakSatuController@index')->name('scanraksatu.index');
        Route::post('/scan-out-nut', [ScanRakSatuController::class, 'storeScanOutNut'])->name('scanraksatu.storeScanOutNut');
        Route::get('/activate-relay', 'ScanRakSatuController@activateRelay')->name('scanraksatu.activateRelay');
        Route::get('/activate-relay2', 'ScanRakSatuController@activateRelayDua')->name('scanraksatu.activateRelayDua');
        Route::get('/activate-relay3', 'ScanRakSatuController@activateRelayTiga')->name('scanraksatu.activateRelayTiga');
        Route::post('/store-scan', [ScanRakSatuController::class, 'storeScan'])->name('store.scan');
        Route::get('/active-deactive', 'ScanRakSatuController@deactivateRelay')->name('scanraksatu.deactivateRelay');
        Route::get('/active-deactive2', 'ScanRakSatuController@deactivateRelayDua')->name('scanraksatu.deactivateRelayDua');
        Route::get('/active-deactive3', 'ScanRakSatuController@deactivateRelayTiga')->name('scanraksatu.deactivateRelayTiga');
    });

    Route::group(['prefix' => 'scanraktujuhbelas'], function () {
        Route::get('/', 'ScanRakTujuhBelasController@index')->name('scanraktujuhbelas.index');
        Route::post('/scan-out-nut', [ScanRakTujuhBelasController::class, 'storeScanOutNut'])->name('scanraktujuhbelas.storeScanOutNut');
        Route::get('/activate-relay', 'ScanRakTujuhBelasController@activateRelay')->name('scanraktujuhbelas.activateRelay');
        Route::get('/activate-relay2', 'ScanRakTujuhBelasController@activateRelayDua')->name('scanraktujuhbelas.activateRelayDua');
        Route::get('/activate-relay3', 'ScanRakTujuhBelasController@activateRelayTiga')->name('scanraktujuhbelas.activateRelayTiga');
        // Route::post('/store-scan', [ScanRakTujuhBelasController::class, 'storeScan'])->name('store.scan');
        Route::get('/active-deactive', 'ScanRakTujuhBelasController@deactivateRelay')->name('scanraktujuhbelas.deactivateRelay');
        Route::get('/active-deactive2', 'ScanRakTujuhBelasController@deactivateRelayDua')->name('scanraktujuhbelas.deactivateRelayDua');
        Route::get('/active-deactive3', 'ScanRakTujuhBelasController@deactivateRelayTiga')->name('scanraktujuhbelas.deactivateRelayTiga');
    });

    Route::group(['prefix' => 'scanraksepuluh'], function () {
        Route::get('/', 'ScanRakSepuluhController@index')->name('scanraksepuluh.index');
        Route::post('/scan-out-nut', [ScanRakSepuluhController::class, 'storeScanOutNut'])->name('scanraksepuluh.storeScanOutNut');
        Route::get('/activate-relay', 'ScanRakSepuluhController@activateRelay')->name('scanraksepuluh.activateRelay');
        Route::get('/activate-relay2', 'ScanRakSepuluhController@activateRelayDua')->name('scanraksepuluh.activateRelayDua');
        Route::get('/activate-relay3', 'ScanRakSepuluhController@activateRelayTiga')->name('scanraksepuluh.activateRelayTiga');
        // Route::post('/store-scan', [ScanRakSepuluhController::class, 'storeScan'])->name('store.scan');
        Route::get('/active-deactive', 'ScanRakSepuluhController@deactivateRelay')->name('scanraksepuluh.deactivateRelay');
        Route::get('/active-deactive2', 'ScanRakSepuluhController@deactivateRelayDua')->name('scanraksepuluh.deactivateRelayDua');
        Route::get('/active-deactive3', 'ScanRakSepuluhController@deactivateRelayTiga')->name('scanraksepuluh.deactivateRelayTiga');
    });


    Route::group(['prefix' => 'scanraklimabelas'], function () {
        Route::get('/', 'ScanRakLimaBelasController@index')->name('scanraklimabelas.index');
        Route::post('/scan-out-nut', [ScanRakLimaBelasController::class, 'storeScanOutNut'])->name('scanraklimabelas.storeScanOutNut');
        Route::get('/activate-relay', 'ScanRakLimaBelasController@activateRelay')->name('scanraklimabelas.activateRelay');
        Route::get('/activate-relay2', 'ScanRakLimaBelasController@activateRelayDua')->name('scanraklimabelas.activateRelayDua');
        Route::get('/activate-relay3', 'ScanRakLimaBelasController@activateRelayTiga')->name('scanraklimabelas.activateRelayTiga');
        Route::get('/activate-relay4', 'ScanRakLimaBelasController@activateRelayEmpat')->name('scanraklimabelas.activateRelayEmpat');
        Route::get('/activate-relay5', 'ScanRakLimaBelasController@activateRelayLima')->name('scanraklimabelas.activateRelayLima');
        // Route::post('/store-scan', [ScanRakLimaBelasController::class, 'storeScan'])->name('store.scan');
        Route::get('/active-deactive', 'ScanRakLimaBelasController@deactivateRelay')->name('scanraklimabelas.deactivateRelay');
        Route::get('/active-deactive2', 'ScanRakLimaBelasController@deactivateRelayDua')->name('scanraklimabelas.deactivateRelayDua');
        Route::get('/active-deactive3', 'ScanRakLimaBelasController@deactivateRelayTiga')->name('scanraklimabelas.deactivateRelayTiga');
        Route::get('/active-deactive4', 'ScanRakLimaBelasController@deactivateRelayEmpat')->name('scanraklimabelas.deactivateRelayEmpat');
        Route::get('/active-deactive5', 'ScanRakLimaBelasController@deactivateRelayLima')->name('scanraklimabelas.deactivateRelayLima');
    });


    Route::group(['prefix' => 'scanraklimabelasout'], function () {
        Route::get('/', 'ScanRak15OutController@index')->name('scanraklimabelasout.index');
        Route::get('/relay/activate', [ScanRak15OutController::class, 'activateRelayOut'])->name('scanraklimabelasout.activateRelayOut');
        Route::get('/relay/deactivate', [ScanRak15OutController::class, 'deactivateRelayOut'])->name('scanraklimabelasout.deactivateRelayOut');
        Route::get('/relay/activate2', [ScanRak15OutController::class, 'activateRelayOut2'])->name('scanraklimabelasout.activateRelayOut2');
        Route::get('/relay/deactivate2', [ScanRak15OutController::class, 'deactivateRelayOut2'])->name('scanraklimabelasout.deactivateRelayOut2');
        Route::get('/relay/activate3', [ScanRak15OutController::class, 'activateRelayOut3'])->name('scanraklimabelasout.activateRelayOut3');
        Route::get('/relay/deactivate3', [ScanRak15OutController::class, 'deactivateRelayOut3'])->name('scanraklimabelasout.deactivateRelayOut3');
    });






    Route::group(['prefix' => 'masterliststr'], function () {
        Route::get('/', 'MasterListStoreRoom@index')->name('masterliststr.index');
        Route::get('/list', 'MasterListStoreRoom@list')->name('masterliststr.list');
        Route::post('/create', 'MasterListStoreRoom@store')->name('masterliststr.store');
        Route::get('/edit', 'MasterListStoreRoom@edit')->name('masterliststr.edit');
        Route::post('/update', 'MasterListStoreRoom@update')->name('masterliststr.update');
        Route::post('/delete', 'MasterListStoreRoom@destroy')->name('masterliststr.destroy');
        Route::get('/export', 'MasterListStoreRoom@export')->name('masterliststr.export');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'StrCategoryController@index')->name('category.index');
        Route::get('/list', 'StrCategoryController@list')->name('category.list');
        Route::post('/create', 'StrCategoryController@store')->name('category.store');
        Route::get('/edit', 'StrCategoryController@edit')->name('category.edit');
        Route::post('/update', 'StrCategoryController@update')->name('category.update');
        Route::post('/delete', 'StrCategoryController@destroy')->name('category.destroy');

    });

    Route::group(['prefix' => 'uom'], function () {
        Route::get('/', 'StrUoMController@index')->name('uom.index');
        Route::get('/list', 'StrUoMController@list')->name('uom.list');
        Route::post('/create', 'StrUoMController@store')->name('uom.store');
        Route::get('/edit', 'StrUoMController@edit')->name('uom.edit');
        Route::post('/update', 'StrUoMController@update')->name('uom.update');
        Route::post('/delete', 'StrUoMController@destroy')->name('uom.destroy');

    });

    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', 'StrSuplaierController@index')->name('supplier.index');
        Route::get('/list', 'StrSuplaierController@list')->name('supplier.list');
        Route::post('/create', 'StrSuplaierController@store')->name('supplier.store');
        Route::get('/edit', 'StrSuplaierController@edit')->name('supplier.edit');
        Route::post('/update', 'StrSuplaierController@update')->name('supplier.update');
        Route::post('/delete', 'StrSuplaierController@destroy')->name('supplier.destroy');
        Route::get('users/export', 'StrSuplaierController@export')->name('supplier.export');
    });

    Route::get('/check-stock', 'CekStokController@checkStock');
    Route::get('/check-stock2', 'CekStokController@checkStock2');
    Route::get('/check-stock3', 'CekStokController@checkStock3');
    Route::get('/check-stock4', 'CekStokController@checkStock4');
    Route::get('/check-stock5', 'CekStokController@checkStock5');
    Route::get('/check-stock6', 'CekStokController@checkStock6');
    Route::get('/check-stock7', 'CekStokController@checkStock7');
    Route::get('/check-stock8', 'CekStokController@checkStock8');
    Route::get('/check-stock9', 'CekStokController@checkStock9');
    Route::get('/check-stock10', 'CekStokController@checkStock10');
    Route::get('/check-stock11', 'CekStokController@checkStock11');
    Route::get('/check-stock-becak', 'CekStokController@checkStockBecak');


    Route::group(['prefix' => 'stokatk'], function () {
        Route::get('/', 'StrStokAtkController@index')->name('stokatk.index');
        Route::get('/list', 'StrStokAtkController@list')->name('stokatk.list');
        Route::post('/create', 'StrStokAtkController@store')->name('stokatk.store');
        Route::get('/edit', 'StrStokAtkController@edit')->name('stokatk.edit');
        Route::post('/update', 'StrStokAtkController@update')->name('stokatk.update');
        Route::post('/delete', 'StrStokAtkController@destroy')->name('stokatk.destroy');
        Route::get('users/export', 'StrStokAtkController@export')->name('stokatk.export');
    });

    Route::group(['prefix' => 'stokrtk'], function () {
        Route::get('/', 'StrStokRtkController@index')->name('stokrtk.index');
        Route::get('/list', 'StrStokRtkController@list')->name('stokrtk.list');
        Route::post('/create', 'StrStokRtkController@store')->name('stokrtk.store');
        Route::get('/edit', 'StrStokRtkController@edit')->name('stokrtk.edit');
        Route::post('/update', 'StrStokRtkController@update')->name('stokrtk.update');
        Route::post('/delete', 'StrStokRtkController@destroy')->name('stokrtk.destroy');
        Route::get('users/export', 'StrStokRtkController@export')->name('stokrtk.export');
    });

    Route::group(['prefix' => 'stokconsum'], function () {
        Route::get('/', 'StrStokConsumController@index')->name('stokconsum.index');
        Route::get('/list', 'StrStokConsumController@list')->name('stokconsum.list');
        Route::post('/create', 'StrStokConsumController@store')->name('stokconsum.store');
        Route::get('/edit', 'StrStokConsumController@edit')->name('stokconsum.edit');
        Route::post('/update', 'StrStokConsumController@update')->name('stokconsum.update');
        Route::post('/delete', 'StrStokConsumController@destroy')->name('stokconsum.destroy');
        Route::get('users/export', 'StrStokConsumController@export')->name('stokconsum.export');
        Route::get('/stokconsum/export-summary', 'StrStokConsumController@exportSummary')->name('consum.export.summary');

    });

    Route::group(['prefix' => 'stokgas'], function () {
        Route::get('/', 'StrStokGasController@index')->name('stokgas.index');
        Route::get('/list', 'StrStokGasController@list')->name('stokgas.list');
        Route::post('/create', 'StrStokGasController@store')->name('stokgas.store');
        Route::get('/edit', 'StrStokGasController@edit')->name('stokgas.edit');
        Route::post('/update', 'StrStokGasController@update')->name('stokgas.update');
        Route::post('/delete', 'StrStokGasController@destroy')->name('stokgas.destroy');
        Route::get('users/export', 'StrStokGasController@export')->name('stokgas.export');
    });

    Route::group(['prefix' => 'stokti'], function () {
        Route::get('/', 'StrStokToolController@index')->name('stokti.index');
        Route::get('/list', 'StrStokToolController@list')->name('stokti.list');
        Route::post('/create', 'StrStokToolController@store')->name('stokti.store');
        Route::get('/edit', 'StrStokToolController@edit')->name('stokti.edit');
        Route::post('/update', 'StrStokToolController@update')->name('stokti.update');
        Route::post('/delete', 'StrStokToolController@destroy')->name('stokti.destroy');
        Route::get('users/export', 'StrStokToolController@export')->name('stokti.export');
    });

    Route::group(['prefix' => 'stokcuptip'], function () {
        Route::get('/', 'StrStokCuptipController@index')->name('stokcuptip.index');
        Route::get('/list', 'StrStokCuptipController@list')->name('stokcuptip.list');
        Route::post('/create', 'StrStokCuptipController@store')->name('stokcuptip.store');
        Route::get('/edit', 'StrStokCuptipController@edit')->name('stokcuptip.edit');
        Route::post('/update', 'StrStokCuptipController@update')->name('stokcuptip.update');
        Route::post('/delete', 'StrStokCuptipController@destroy')->name('stokcuptip.destroy');
        Route::get('users/export', 'StrStokCuptipController@export')->name('stokcuptip.export');
    });

    Route::group(['prefix' => 'strout'], function () {
        Route::get('/', 'StrOutController@index')->name('strout.index');
        Route::get('/list', 'StrOutController@list')->name('strout.list');
        // Route::get('/getdoc', 'StrOutController@getdoc')->name('strout.getdoc');
        Route::get('/listdetail', 'StrOutController@listdetail')->name('strout.listdetail');
        Route::post('/create', 'StrOutController@store')->name('strout.store');
        Route::get('/edit', 'StrOutController@edit')->name('strout.edit');
        Route::post('/delete', 'StrOutController@destroy')->name('strout.destroy');
        Route::post('/deleteline', 'StrOutController@destroyline')->name('strout.destroyline');
        Route::get('/export', 'StrOutController@export')->name('strout.export');
        Route::post('/update', 'StrOutController@update')->name('strout.update');
        Route::get('/update-price-items', 'StrOutController@updatePriceItems')->name('strout.updatePriceItems');

    });

    Route::group(['prefix' => 'strin'], function () {
        Route::get('/', 'StrInController@index')->name('strin.index');
        Route::get('/list', 'StrInController@list')->name('strin.list');
        Route::get('/getdoc', 'StrInController@getdoc')->name('strin.getdoc');
        Route::get('/listdetail', 'StrInController@listdetail')->name('strin.listdetail');
        Route::post('/create', 'StrInController@store')->name('strin.store');
        Route::get('/edit', 'StrInController@edit')->name('strin.edit');
        Route::post('/delete', 'StrInController@destroy')->name('strin.destroy');
        Route::post('/deleteline', 'StrInController@destroyline')->name('strin.destroyline');
        Route::get('/export', 'StrInController@export')->name('strin.export');
        // Route::get('/export', 'StrInController@export')->name('strout.export');
    });

    Route::group(['prefix' => 'dept'], function () {
        Route::get('/', 'DepartementController@index')->name('dept.index');
        Route::get('/list', 'DepartementController@list')->name('dept.list');
        Route::post('/create', 'DepartementController@store')->name('dept.store');
        Route::get('/edit', 'DepartementController@edit')->name('dept.edit');
        Route::post('/update', 'DepartementController@update')->name('dept.update');
        Route::post('/delete', 'DepartementController@destroy')->name('dept.destroy');

    });

    Route::group(['prefix' => 'exportall'], function () {
        Route::get('/', 'StrExportController@index')->name('exportall.index');
        Route::get('/export', 'StrExportController@export')->name('exportall.export');
        Route::get('/export2', 'StrExportController@export2')->name('exportall.export2');
        Route::get('/export3', 'StrExportController@export3')->name('exportall.export3');
        // Route::post('/delete', 'StrExportController@destroy')->name('spbb3.destroy');
    });

    Route::group(['prefix' => 'kanban'], function () {
        Route::get('/', 'StrKanbanController@index')->name('kanban.index');
        Route::get('/get-new-data', 'StrKanbanController@getNewData')->name('kanban.getNewData');
        Route::get('/getDetails', 'StrKanbanController@getDetails')->name('kanban.getDetails');
        // Route::get('/get-new-data3', 'StrKanbanController@getNewData3')->name('kanban.getNewData3');
        // Route::get('/getDetails3', 'StrKanbanController@getDetails3')->name('kanban.getDetails3');
        // Route::get('/kanban/save-selection', 'StrKanbanController@saveSelection')->name('kanban.saveSelection');
        Route::post('/kanban/save-selection', [StrKanbanController::class, 'saveSelection'])->name('kanban.saveSelection');
    });

    Route::group(['prefix' => 'strout2'], function () {
        Route::get('/', 'StrOut2Controller@index')->name('strout2.index');
        Route::get('/list', 'StrOut2Controller@list')->name('strout2.list');
        Route::get('/edit2', 'StrOut2Controller@edit2')->name('strout2.edit2');
        Route::get('/getdoc', 'StrOut2Controller@getdoc')->name('strout2.getdoc');
        Route::get('/listdetail', 'StrOut2Controller@listdetail')->name('strout2.listdetail');
        Route::get('/listdetail2', 'StrOut2Controller@listdetail2')->name('strout2.listdetail2');
        Route::get('/listdetail3', 'StrOut2Controller@listdetail3')->name('strout2.listdetail3');
        Route::post('/create', 'StrOut2Controller@store')->name('strout2.store');
        Route::post('/submit', 'StrOut2Controller@submit')->name('strout2.submit');
        Route::post('/delete_draft', 'StrOut2Controller@delete_draft')->name('strout2.delete_draft');
        Route::get('/edit', 'StrOut2Controller@edit')->name('strout2.edit');
        Route::post('/delete', 'StrOut2Controller@destroy')->name('strout2.destroy');
        Route::post('/deleteline', 'StrOut2Controller@destroyline')->name('strout2.destroyline');
        Route::post('/update', 'StrOut2Controller@update')->name('strout2.update');
        Route::post('/update2', 'StrOut2Controller@update2')->name('strout2.update2');
        Route::post('/approve', [StrOut2Controller::class, 'approve'])->name('strout2.approve');
        Route::post('/strout2/approve2', [StrOut2Controller::class, 'approve2'])->name('strout2.approve2');
        Route::post('/strout2/approve3', [StrOut2Controller::class, 'approve3'])->name('strout2.approve3');
        Route::get('/export', 'StrOut2Controller@export')->name('strout2.export');
        Route::get('/get-actual', [StrOut2Controller::class, 'getActual'])->name('strout2.getActual');
        Route::post('/saveChecked', 'StrOut2Controller@saveChecked')->name('strout2.saveChecked');
        Route::get('/strout2/export-summary', [StrOut2Controller::class, 'exportSummary'])->name('strout2.export.summary');



    });

    Route::group(['prefix' => 'strout3'], function () {
        Route::get('/', 'StrOut3Controller@index')->name('strout3.index');
        Route::get('/list', 'StrOut3Controller@list')->name('strout3.list');
        Route::get('/edit2', 'StrOut3Controller@edit2')->name('strout3.edit2');
        Route::get('/getdoc', 'StrOut3Controller@getdoc')->name('strout3.getdoc');
        Route::get('/listdetail', 'StrOut3Controller@listdetail')->name('strout3.listdetail');
        Route::get('/listdetail2', 'StrOut3Controller@listdetail2')->name('strout3.listdetail2');
        Route::get('/listdetail3', 'StrOut3Controller@listdetail3')->name('strout3.listdetail3');
        Route::post('/create', 'StrOut3Controller@store')->name('strout3.store');
        Route::post('/submit', 'StrOut3Controller@submit')->name('strout3.submit');
        Route::post('/delete_draft', 'StrOut3Controller@delete_draft')->name('strout3.delete_draft');
        Route::get('/edit', 'StrOut3Controller@edit')->name('strout3.edit');
        Route::post('/delete', 'StrOut3Controller@destroy')->name('strout3.destroy');
        Route::post('/deleteline', 'StrOut3Controller@destroyline')->name('strout3.destroyline');
        Route::post('/update', 'StrOut3Controller@update')->name('strout3.update');
        Route::post('/update2', 'StrOut3Controller@update2')->name('strout3.update2');
        Route::post('/approve', [StrOut3Controller::class, 'approve'])->name('strout3.approve');
        Route::post('/strout3/approve2', [StrOut3Controller::class, 'approve2'])->name('strout3.approve2');
        Route::post('/strout3/approve3', [StrOut3Controller::class, 'approve3'])->name('strout3.approve3');
        Route::get('/export', 'StrOut3Controller@export')->name('strout3.export');
        Route::get('/strout3/export-summary', [StrOut3Controller::class, 'exportSummary'])->name('strout3.export.summary');
        Route::get('/get-actual', [StrOut3Controller::class, 'getActual'])->name('strout3.getActual');
        Route::post('/saveChecked', 'StrOut3Controller@saveChecked')->name('strout3.saveChecked');

    });


    Route::group(['prefix' => 'strout4'], function () {
        Route::get('/', 'StrOut4Controller@index')->name('strout4.index');
        Route::get('/list', 'StrOut4Controller@list')->name('strout4.list');
        Route::get('/edit2', 'StrOut4Controller@edit2')->name('strout4.edit2');
        Route::get('/getdoc', 'StrOut4Controller@getdoc')->name('strout4.getdoc');
        Route::get('/listdetail', 'StrOut4Controller@listdetail')->name('strout4.listdetail');
        Route::get('/listdetail2', 'StrOut4Controller@listdetail2')->name('strout4.listdetail2');
        Route::get('/listdetail3', 'StrOut4Controller@listdetail3')->name('strout4.listdetail3');
        Route::post('/create', 'StrOut4Controller@store')->name('strout4.store');
        Route::post('/submit', 'StrOut4Controller@submit')->name('strout4.submit');
        Route::post('/delete_draft', 'StrOut4Controller@delete_draft')->name('strout4.delete_draft');
        Route::get('/edit', 'StrOut4Controller@edit')->name('strout4.edit');
        Route::post('/delete', 'StrOut4Controller@destroy')->name('strout4.destroy');
        Route::post('/deleteline', 'StrOut4Controller@destroyline')->name('strout4.destroyline');
        Route::post('/update', 'StrOut4Controller@update')->name('strout4.update');
        Route::post('/update2', 'StrOut4Controller@update2')->name('strout4.update2');
        Route::post('/approve', [StrOut4Controller::class, 'approve'])->name('strout4.approve');
        Route::post('/strout4/approve2', [StrOut4Controller::class, 'approve2'])->name('strout4.approve2');
        Route::post('/strout4/approve3', [StrOut4Controller::class, 'approve3'])->name('strout4.approve3');
        Route::get('/export', 'StrOut4Controller@export')->name('strout4.export');
        Route::get('/strout4/export-summary', [StrOut4Controller::class, 'exportSummary'])->name('strout4.export.summary');
        Route::get('/get-actual', [StrOut4Controller::class, 'getActual'])->name('strout4.getActual');
        Route::post('/saveChecked', 'StrOut4Controller@saveChecked')->name('strout4.saveChecked');

    });

    Route::group(['prefix' => 'strout5'], function () {
        Route::get('/', 'StrOut5Controller@index')->name('strout5.index');
        Route::get('/list', 'StrOut5Controller@list')->name('strout5.list');
        Route::get('/edit2', 'StrOut5Controller@edit2')->name('strout5.edit2');
        Route::get('/getdoc', 'StrOut5Controller@getdoc')->name('strout5.getdoc');
        Route::get('/listdetail', 'StrOut5Controller@listdetail')->name('strout5.listdetail');
        Route::get('/listdetail2', 'StrOut5Controller@listdetail2')->name('strout5.listdetail2');
        Route::get('/listdetail3', 'StrOut5Controller@listdetail3')->name('strout5.listdetail3');
        Route::post('/create', 'StrOut5Controller@store')->name('strout5.store');
        Route::post('/submit', 'StrOut5Controller@submit')->name('strout5.submit');
        Route::post('/delete_draft', 'StrOut5Controller@delete_draft')->name('strout5.delete_draft');
        Route::get('/edit', 'StrOut5Controller@edit')->name('strout5.edit');
        Route::post('/delete', 'StrOut5Controller@destroy')->name('strout5.destroy');
        Route::post('/deleteline', 'StrOut5Controller@destroyline')->name('strout5.destroyline');
        Route::post('/update', 'StrOut5Controller@update')->name('strout5.update');
        Route::post('/update2', 'StrOut5Controller@update2')->name('strout5.update2');
        Route::post('/approve', [StrOut5Controller::class, 'approve'])->name('strout5.approve');
        Route::post('/strout5/approve2', [StrOut5Controller::class, 'approve2'])->name('strout5.approve2');
        Route::post('/strout5/approve3', [StrOut5Controller::class, 'approve3'])->name('strout5.approve3');
        Route::get('/export', 'StrOut5Controller@export')->name('strout5.export');
        Route::get('/strout5/export-summary', [StrOut5Controller::class, 'exportSummary'])->name('strout5.export.summary');
        Route::get('/get-actual', [StrOut5Controller::class, 'getActual'])->name('strout5.getActual');
        Route::post('/saveChecked', 'StrOut5Controller@saveChecked')->name('strout5.saveChecked');
    });

    Route::group(['prefix' => 'strout6'], function () {
        Route::get('/', 'StrOut6Controller@index')->name('strout6.index');
        Route::get('/list', 'StrOut6Controller@list')->name('strout6.list');
        Route::get('/edit2', 'StrOut6Controller@edit2')->name('strout6.edit2');
        Route::get('/getdoc', 'StrOut6Controller@getdoc')->name('strout6.getdoc');
        Route::get('/listdetail', 'StrOut6Controller@listdetail')->name('strout6.listdetail');
        Route::get('/listdetail2', 'StrOut6Controller@listdetail2')->name('strout6.listdetail2');
        Route::get('/listdetail3', 'StrOut6Controller@listdetail3')->name('strout6.listdetail3');
        Route::post('/create', 'StrOut6Controller@store')->name('strout6.store');
        Route::post('/submit', 'StrOut6Controller@submit')->name('strout6.submit');
        Route::post('/delete_draft', 'StrOut6Controller@delete_draft')->name('strout6.delete_draft');
        Route::get('/edit', 'StrOut6Controller@edit')->name('strout6.edit');
        Route::post('/delete', 'StrOut6Controller@destroy')->name('strout6.destroy');
        Route::post('/deleteline', 'StrOut6Controller@destroyline')->name('strout6.destroyline');
        Route::post('/update', 'StrOut6Controller@update')->name('strout6.update');
        Route::post('/update2', 'StrOut6Controller@update2')->name('strout6.update2');
        Route::post('/approve', [StrOut6Controller::class, 'approve'])->name('strout6.approve');
        Route::post('/strout6/approve2', [StrOut6Controller::class, 'approve2'])->name('strout6.approve2');
        Route::post('/strout6/approve3', [StrOut6Controller::class, 'approve3'])->name('strout6.approve3');
        Route::get('/export', 'StrOut6Controller@export')->name('strout6.export');
        Route::get('/strout6/export-summary', [StrOut6Controller::class, 'exportSummary'])->name('strout6.export.summary');
        Route::get('/get-actual', [StrOut6Controller::class, 'getActual'])->name('strout6.getActual');
        Route::post('/saveChecked', 'StrOut6Controller@saveChecked')->name('strout6.saveChecked');
    });

    Route::group(['prefix' => 'strout7'], function () {
        Route::get('/', 'StrOut7Controller@index')->name('strout7.index');
        Route::get('/list', 'StrOut7Controller@list')->name('strout7.list');
        Route::get('/edit2', 'StrOut7Controller@edit2')->name('strout7.edit2');
        Route::get('/getdoc', 'StrOut7Controller@getdoc')->name('strout7.getdoc');
        Route::get('/listdetail', 'StrOut7Controller@listdetail')->name('strout7.listdetail');
        Route::get('/listdetail2', 'StrOut7Controller@listdetail2')->name('strout7.listdetail2');
        Route::get('/listdetail3', 'StrOut7Controller@listdetail3')->name('strout7.listdetail3');
        Route::post('/create', 'StrOut7Controller@store')->name('strout7.store');
        Route::post('/submit', 'StrOut7Controller@submit')->name('strout7.submit');
        Route::post('/delete_draft', 'StrOut7Controller@delete_draft')->name('strout7.delete_draft');
        Route::get('/edit', 'StrOut7Controller@edit')->name('strout7.edit');
        Route::post('/delete', 'StrOut7Controller@destroy')->name('strout7.destroy');
        Route::post('/deleteline', 'StrOut7Controller@destroyline')->name('strout7.destroyline');
        Route::post('/update', 'StrOut7Controller@update')->name('strout7.update');
        Route::post('/update2', 'StrOut7Controller@update2')->name('strout7.update2');
        Route::post('/approve', [StrOut7Controller::class, 'approve'])->name('strout7.approve');
        Route::post('/strout7/approve2', [StrOut7Controller::class, 'approve2'])->name('strout7.approve2');
        Route::post('/strout7/approve3', [StrOut7Controller::class, 'approve3'])->name('strout7.approve3');
        Route::get('/export', 'StrOut7Controller@export')->name('strout7.export');
        Route::get('/strout7/export-summary', [StrOut7Controller::class, 'exportSummary'])->name('strout7.export.summary');
        Route::get('/get-actual', [StrOut7Controller::class, 'getActual'])->name('strout7.getActual');
        Route::post('/saveChecked', 'StrOut7Controller@saveChecked')->name('strout7.saveChecked');

    });

    Route::group(['prefix' => 'strout8'], function () {
        Route::get('/', 'StrOut8Controller@index')->name('strout8.index');
        Route::get('/list', 'StrOut8Controller@list')->name('strout8.list');
        Route::get('/edit2', 'StrOut8Controller@edit2')->name('strout8.edit2');
        Route::get('/getdoc', 'StrOut8Controller@getdoc')->name('strout8.getdoc');
        Route::get('/listdetail', 'StrOut8Controller@listdetail')->name('strout8.listdetail');
        Route::get('/listdetail2', 'StrOut8Controller@listdetail2')->name('strout8.listdetail2');
        Route::get('/listdetail3', 'StrOut8Controller@listdetail3')->name('strout8.listdetail3');
        Route::post('/create', 'StrOut8Controller@store')->name('strout8.store');
        Route::post('/submit', 'StrOut8Controller@submit')->name('strout8.submit');
        Route::post('/delete_draft', 'StrOut8Controller@delete_draft')->name('strout8.delete_draft');
        Route::get('/edit', 'StrOut8Controller@edit')->name('strout8.edit');
        Route::post('/delete', 'StrOut8Controller@destroy')->name('strout8.destroy');
        Route::post('/deleteline', 'StrOut8Controller@destroyline')->name('strout8.destroyline');
        Route::post('/update', 'StrOut8Controller@update')->name('strout8.update');
        Route::post('/update2', 'StrOut8Controller@update2')->name('strout8.update2');
        Route::post('/approve', [StrOut8Controller::class, 'approve'])->name('strout8.approve');
        Route::post('/strout8/approve2', [StrOut8Controller::class, 'approve2'])->name('strout8.approve2');
        Route::post('/strout8/approve3', [StrOut8Controller::class, 'approve3'])->name('strout8.approve3');
        Route::get('/export', 'StrOut8Controller@export')->name('strout8.export');
        Route::get('/strout8/export-summary', [StrOut8Controller::class, 'exportSummary'])->name('strout8.export.summary');
        Route::get('/get-actual', [StrOut8Controller::class, 'getActual'])->name('strout8.getActual');
        Route::post('/saveChecked', 'StrOut8Controller@saveChecked')->name('strout8.saveChecked');

    });

    Route::group(['prefix' => 'strout9'], function () {
        Route::get('/', 'StrOut9Controller@index')->name('strout9.index');
        Route::get('/list', 'StrOut9Controller@list')->name('strout9.list');
        Route::get('/edit2', 'StrOut9Controller@edit2')->name('strout9.edit2');
        Route::get('/getdoc', 'StrOut9Controller@getdoc')->name('strout9.getdoc');
        Route::get('/listdetail', 'StrOut9Controller@listdetail')->name('strout9.listdetail');
        Route::get('/listdetail2', 'StrOut9Controller@listdetail2')->name('strout9.listdetail2');
        Route::get('/listdetail3', 'StrOut9Controller@listdetail3')->name('strout9.listdetail3');
        Route::post('/create', 'StrOut9Controller@store')->name('strout9.store');
        Route::post('/submit', 'StrOut9Controller@submit')->name('strout9.submit');
        Route::post('/delete_draft', 'StrOut9Controller@delete_draft')->name('strout9.delete_draft');
        Route::get('/edit', 'StrOut9Controller@edit')->name('strout9.edit');
        Route::post('/delete', 'StrOut9Controller@destroy')->name('strout9.destroy');
        Route::post('/deleteline', 'StrOut9Controller@destroyline')->name('strout9.destroyline');
        Route::post('/update', 'StrOut9Controller@update')->name('strout9.update');
        Route::post('/update2', 'StrOut9Controller@update2')->name('strout9.update2');
        Route::post('/approve', [StrOut9Controller::class, 'approve'])->name('strout9.approve');
        Route::post('/strout9/approve2', [StrOut9Controller::class, 'approve2'])->name('strout9.approve2');
        Route::post('/strout9/approve3', [StrOut9Controller::class, 'approve3'])->name('strout9.approve3');
        Route::get('/export', 'StrOut9Controller@export')->name('strout9.export');
        Route::get('/strout9/export-summary', [StrOut9Controller::class, 'exportSummary'])->name('strout9.export.summary');
        Route::get('/get-actual', [StrOut9Controller::class, 'getActual'])->name('strout9.getActual');
        Route::post('/saveChecked', 'StrOut9Controller@saveChecked')->name('strout9.saveChecked');

    });

    Route::group(['prefix' => 'strout10'], function () {
        Route::get('/', 'StrOut10Controller@index')->name('strout10.index');
        Route::get('/list', 'StrOut10Controller@list')->name('strout10.list');
        Route::get('/edit2', 'StrOut10Controller@edit2')->name('strout10.edit2');
        Route::get('/getdoc', 'StrOut10Controller@getdoc')->name('strout10.getdoc');
        Route::get('/listdetail', 'StrOut10Controller@listdetail')->name('strout10.listdetail');
        Route::get('/listdetail2', 'StrOut10Controller@listdetail2')->name('strout10.listdetail2');
        Route::get('/listdetail3', 'StrOut10Controller@listdetail3')->name('strout10.listdetail3');
        Route::post('/create', 'StrOut10Controller@store')->name('strout10.store');
        Route::post('/submit', 'StrOut10Controller@submit')->name('strout10.submit');
        Route::post('/delete_draft', 'StrOut10Controller@delete_draft')->name('strout10.delete_draft');
        Route::get('/edit', 'StrOut10Controller@edit')->name('strout10.edit');
        Route::post('/delete', 'StrOut10Controller@destroy')->name('strout10.destroy');
        Route::post('/deleteline', 'StrOut10Controller@destroyline')->name('strout10.destroyline');
        Route::post('/update', 'StrOut10Controller@update')->name('strout10.update');
        Route::post('/update2', 'StrOut10Controller@update2')->name('strout10.update2');
        Route::post('/approve', [StrOut10Controller::class, 'approve'])->name('strout10.approve');
        Route::post('/strout10/approve2', [StrOut10Controller::class, 'approve2'])->name('strout10.approve2');
        Route::post('/strout10/approve3', [StrOut10Controller::class, 'approve3'])->name('strout10.approve3');
        Route::get('/export', 'StrOut10Controller@export')->name('strout10.export');
        Route::get('/strout10/export-summary', [StrOut3Controller::class, 'exportSummary'])->name('strout10.export.summary');
        Route::get('/get-actual', [StrOut10Controller::class, 'getActual'])->name('strout10.getActual');
        Route::post('/saveChecked', 'StrOut10Controller@saveChecked')->name('strout10.saveChecked');

    });

    Route::group(['prefix' => 'strout11'], function () {
        Route::get('/', 'StrOut11Controller@index')->name('strout11.index');
        Route::get('/list', 'StrOut11Controller@list')->name('strout11.list');
        Route::get('/edit2', 'StrOut11Controller@edit2')->name('strout11.edit2');
        Route::get('/getdoc', 'StrOut11Controller@getdoc')->name('strout11.getdoc');
        Route::get('/listdetail', 'StrOut11Controller@listdetail')->name('strout11.listdetail');
        Route::get('/listdetail2', 'StrOut11Controller@listdetail2')->name('strout11.listdetail2');
        Route::get('/listdetail3', 'StrOut11Controller@listdetail3')->name('strout11.listdetail3');
        Route::post('/create', 'StrOut11Controller@store')->name('strout11.store');
        Route::post('/submit', 'StrOut11Controller@submit')->name('strout11.submit');
        Route::post('/delete_draft', 'StrOut11Controller@delete_draft')->name('strout11.delete_draft');
        Route::get('/edit', 'StrOut11Controller@edit')->name('strout11.edit');
        Route::post('/delete', 'StrOut11Controller@destroy')->name('strout11.destroy');
        Route::post('/deleteline', 'StrOut11Controller@destroyline')->name('strout11.destroyline');
        Route::post('/update', 'StrOut11Controller@update')->name('strout11.update');
        Route::post('/update2', 'StrOut11Controller@update2')->name('strout11.update2');
        Route::post('/approve', [StrOut11Controller::class, 'approve'])->name('strout11.approve');
        Route::post('/strout11/approve2', [StrOut11Controller::class, 'approve2'])->name('strout11.approve2');
        Route::post('/strout11/approve3', [StrOut11Controller::class, 'approve3'])->name('strout11.approve3');
        Route::get('/export', 'StrOut11Controller@export')->name('strout11.export');
        Route::get('/strout11/export-summary', [StrOut11Controller::class, 'exportSummary'])->name('strout11.export.summary');
        Route::get('/get-actual', [StrOut11Controller::class, 'getActual'])->name('strout11.getActual');
        Route::post('/saveChecked', 'StrOut11Controller@saveChecked')->name('strout11.saveChecked');

    });

    Route::group(['prefix' => 'strout12'], function () {
        Route::get('/', 'StrOut12Controller@index')->name('strout12.index');
        Route::get('/list', 'StrOut12Controller@list')->name('strout12.list');
        Route::get('/edit2', 'StrOut12Controller@edit2')->name('strout12.edit2');
        Route::get('/getdoc', 'StrOut12Controller@getdoc')->name('strout12.getdoc');
        Route::get('/listdetail', 'StrOut12Controller@listdetail')->name('strout12.listdetail');
        Route::get('/listdetail2', 'StrOut12Controller@listdetail2')->name('strout12.listdetail2');
        Route::get('/listdetail3', 'StrOut12Controller@listdetail3')->name('strout12.listdetail3');
        Route::post('/create', 'StrOut12Controller@store')->name('strout12.store');
        Route::post('/submit', 'StrOut12Controller@submit')->name('strout12.submit');
        Route::post('/delete_draft', 'StrOut12Controller@delete_draft')->name('strout12.delete_draft');
        Route::get('/edit', 'StrOut12Controller@edit')->name('strout12.edit');
        Route::post('/delete', 'StrOut12Controller@destroy')->name('strout12.destroy');
        Route::post('/deleteline', 'StrOut12Controller@destroyline')->name('strout12.destroyline');
        Route::post('/update', 'StrOut12Controller@update')->name('strout12.update');
        Route::post('/update2', 'StrOut12Controller@update2')->name('strout12.update2');
        Route::post('/approve', [StrOut12Controller::class, 'approve'])->name('strout12.approve');
        Route::post('/strout12/approve2', [StrOut12Controller::class, 'approve2'])->name('strout12.approve2');
        Route::post('/strout12/approve3', [StrOut12Controller::class, 'approve3'])->name('strout12.approve3');
        Route::get('/export', 'StrOut12Controller@export')->name('strout12.export');
        Route::get('/strout12/export-summary', [StrOut12Controller::class, 'exportSummary'])->name('strout12.export.summary');
        Route::get('/get-actual', [StrOut12Controller::class, 'getActual'])->name('strout12.getActual');
        Route::post('/saveChecked', 'StrOut12Controller@saveChecked')->name('strout12.saveChecked');
    });

    Route::group(['prefix' => 'strout13'], function () {
        Route::get('/', 'StrOut13Controller@index')->name('strout13.index');
        Route::get('/list', 'StrOut13Controller@list')->name('strout13.list');
        Route::get('/edit2', 'StrOut13Controller@edit2')->name('strout13.edit2');
        Route::get('/getdoc', 'StrOut13Controller@getdoc')->name('strout13.getdoc');
        Route::get('/listdetail', 'StrOut13Controller@listdetail')->name('strout13.listdetail');
        Route::get('/listdetail2', 'StrOut13Controller@listdetail2')->name('strout13.listdetail2');
        Route::get('/listdetail3', 'StrOut13Controller@listdetail3')->name('strout13.listdetail3');
        Route::post('/create', 'StrOut13Controller@store')->name('strout13.store');
        Route::post('/submit', 'StrOut13Controller@submit')->name('strout13.submit');
        Route::post('/delete_draft', 'StrOut13Controller@delete_draft')->name('strout13.delete_draft');
        Route::get('/edit', 'StrOut13Controller@edit')->name('strout13.edit');
        Route::post('/delete', 'StrOut13Controller@destroy')->name('strout13.destroy');
        Route::post('/deleteline', 'StrOut13Controller@destroyline')->name('strout13.destroyline');
        Route::post('/update', 'StrOut13Controller@update')->name('strout13.update');
        Route::post('/update2', 'StrOut13Controller@update2')->name('strout13.update2');
        Route::post('/approve', [StrOut13Controller::class, 'approve'])->name('strout13.approve');
        Route::post('/strout13/approve2', [StrOut13Controller::class, 'approve2'])->name('strout13.approve2');
        Route::post('/strout13/approve3', [StrOut13Controller::class, 'approve3'])->name('strout13.approve3');
        Route::get('/export', 'StrOut13Controller@export')->name('strout13.export');
        Route::get('/strout13/export-summary', [StrOut13Controller::class, 'exportSummary'])->name('strout13.export.summary');
        Route::get('/get-actual', [StrOut13Controller::class, 'getActual'])->name('strout13.getActual');
        Route::post('/saveChecked', 'StrOut13Controller@saveChecked')->name('strout13.saveChecked');
    });

    Route::group(['prefix' => 'strout14'], function () {
        Route::get('/', 'StrOut14Controller@index')->name('strout14.index');
        Route::get('/list', 'StrOut14Controller@list')->name('strout14.list');
        Route::get('/edit2', 'StrOut14Controller@edit2')->name('strout14.edit2');
        Route::get('/getdoc', 'StrOut14Controller@getdoc')->name('strout14.getdoc');
        Route::get('/listdetail', 'StrOut14Controller@listdetail')->name('strout14.listdetail');
        Route::get('/listdetail2', 'StrOut14Controller@listdetail2')->name('strout14.listdetail2');
        Route::get('/listdetail3', 'StrOut14Controller@listdetail3')->name('strout14.listdetail3');
        Route::post('/create', 'StrOut14Controller@store')->name('strout14.store');
        Route::post('/submit', 'StrOut14Controller@submit')->name('strout14.submit');
        Route::post('/delete_draft', 'StrOut14Controller@delete_draft')->name('strout14.delete_draft');
        Route::get('/edit', 'StrOut14Controller@edit')->name('strout14.edit');
        Route::post('/delete', 'StrOut14Controller@destroy')->name('strout14.destroy');
        Route::post('/deleteline', 'StrOut14Controller@destroyline')->name('strout14.destroyline');
        Route::post('/update', 'StrOut14Controller@update')->name('strout14.update');
        Route::post('/update2', 'StrOut14Controller@update2')->name('strout14.update2');
        Route::post('/approve', [StrOut14Controller::class, 'approve'])->name('strout14.approve');
        Route::post('/strout14/approve2', [StrOut14Controller::class, 'approve2'])->name('strout14.approve2');
        Route::post('/strout14/approve3', [StrOut14Controller::class, 'approve3'])->name('strout14.approve3');
        Route::get('/export', 'StrOut14Controller@export')->name('strout14.export');
        Route::get('/strout14/export-summary', [StrOut14Controller::class, 'exportSummary'])->name('strout14.export.summary');
        Route::get('/get-actual', [StrOut14Controller::class, 'getActual'])->name('strout14.getActual');
        Route::post('/saveChecked', 'StrOut14Controller@saveChecked')->name('strout14.saveChecked');

    });

    Route::group(['prefix' => 'strout15'], function () {
        Route::get('/', 'StrOut15Controller@index')->name('strout15.index');
        Route::get('/list', 'StrOut15Controller@list')->name('strout15.list');
        Route::get('/edit2', 'StrOut15Controller@edit2')->name('strout15.edit2');
        Route::get('/getdoc', 'StrOut15Controller@getdoc')->name('strout15.getdoc');
        Route::get('/listdetail', 'StrOut15Controller@listdetail')->name('strout15.listdetail');
        Route::get('/listdetail2', 'StrOut15Controller@listdetail2')->name('strout15.listdetail2');
        Route::get('/listdetail3', 'StrOut15Controller@listdetail3')->name('strout15.listdetail3');
        Route::post('/create', 'StrOut15Controller@store')->name('strout15.store');
        Route::post('/submit', 'StrOut15Controller@submit')->name('strout15.submit');
        Route::post('/delete_draft', 'StrOut15Controller@delete_draft')->name('strout15.delete_draft');
        Route::get('/edit', 'StrOut15Controller@edit')->name('strout15.edit');
        Route::post('/delete', 'StrOut15Controller@destroy')->name('strout15.destroy');
        Route::post('/deleteline', 'StrOut15Controller@destroyline')->name('strout15.destroyline');
        Route::post('/update', 'StrOut15Controller@update')->name('strout15.update');
        Route::post('/update2', 'StrOut15Controller@update2')->name('strout15.update2');
        Route::post('/approve', [StrOut15Controller::class, 'approve'])->name('strout15.approve');
        Route::post('/strout15/approve2', [StrOut15Controller::class, 'approve2'])->name('strout15.approve2');
        Route::post('/strout15/approve3', [StrOut15Controller::class, 'approve3'])->name('strout15.approve3');
        Route::get('/export', 'StrOut15Controller@export')->name('strout15.export');
        Route::get('/strout15/export-summary', [StrOut15Controller::class, 'exportSummary'])->name('strout15.export.summary');
        Route::get('/get-actual', [StrOut15Controller::class, 'getActual'])->name('strout15.getActual');
        Route::post('/saveChecked', 'StrOut15Controller@saveChecked')->name('strout15.saveChecked');

    });

    Route::group(['prefix' => 'strout16'], function () {
        Route::get('/', 'StrOut16Controller@index')->name('strout16.index');
        Route::get('/list', 'StrOut16Controller@list')->name('strout16.list');
        Route::get('/edit2', 'StrOut16Controller@edit2')->name('strout16.edit2');
        Route::get('/getdoc', 'StrOut16Controller@getdoc')->name('strout16.getdoc');
        Route::get('/listdetail', 'StrOut16Controller@listdetail')->name('strout16.listdetail');
        Route::get('/listdetail2', 'StrOut16Controller@listdetail2')->name('strout16.listdetail2');
        Route::get('/listdetail3', 'StrOut16Controller@listdetail3')->name('strout16.listdetail3');
        Route::post('/create', 'StrOut16Controller@store')->name('strout16.store');
        Route::post('/submit', 'StrOut16Controller@submit')->name('strout16.submit');
        Route::post('/delete_draft', 'StrOut16Controller@delete_draft')->name('strout16.delete_draft');
        Route::get('/edit', 'StrOut16Controller@edit')->name('strout16.edit');
        Route::post('/delete', 'StrOut16Controller@destroy')->name('strout16.destroy');
        Route::post('/deleteline', 'StrOut16Controller@destroyline')->name('strout16.destroyline');
        Route::post('/update', 'StrOut16Controller@update')->name('strout16.update');
        Route::post('/update2', 'StrOut16Controller@update2')->name('strout16.update2');
        Route::post('/approve', [StrOut16Controller::class, 'approve'])->name('strout16.approve');
        Route::post('/strout16/approve2', [StrOut16Controller::class, 'approve2'])->name('strout16.approve2');
        Route::post('/strout16/approve3', [StrOut16Controller::class, 'approve3'])->name('strout16.approve3');
        Route::get('/export', 'StrOut16Controller@export')->name('strout16.export');
        Route::get('/strout16/export-summary', [StrOut16Controller::class, 'exportSummary'])->name('strout16.export.summary');
        Route::get('/get-actual', [StrOut16Controller::class, 'getActual'])->name('strout16.getActual');
        Route::post('/saveChecked', 'StrOut16Controller@saveChecked')->name('strout16.saveChecked');

    });

    Route::group(['prefix' => 'strout17'], function () {
        Route::get('/', 'StrOut17Controller@index')->name('strout17.index');
        Route::get('/list', 'StrOut17Controller@list')->name('strout17.list');
        Route::get('/edit2', 'StrOut17Controller@edit2')->name('strout17.edit2');
        Route::get('/getdoc', 'StrOut17Controller@getdoc')->name('strout17.getdoc');
        Route::get('/listdetail', 'StrOut17Controller@listdetail')->name('strout17.listdetail');
        Route::get('/listdetail2', 'StrOut17Controller@listdetail2')->name('strout17.listdetail2');
        Route::get('/listdetail3', 'StrOut17Controller@listdetail3')->name('strout17.listdetail3');
        Route::post('/create', 'StrOut17Controller@store')->name('strout17.store');
        Route::post('/submit', 'StrOut17Controller@submit')->name('strout17.submit');
        Route::post('/delete_draft', 'StrOut17Controller@delete_draft')->name('strout17.delete_draft');
        Route::get('/edit', 'StrOut17Controller@edit')->name('strout17.edit');
        Route::post('/delete', 'StrOut17Controller@destroy')->name('strout17.destroy');
        Route::post('/deleteline', 'StrOut17Controller@destroyline')->name('strout17.destroyline');
        Route::post('/update', 'StrOut17Controller@update')->name('strout17.update');
        Route::post('/update2', 'StrOut17Controller@update2')->name('strout17.update2');
        Route::post('/approve', [StrOut17Controller::class, 'approve'])->name('strout17.approve');
        Route::post('/strout17/approve2', [StrOut17Controller::class, 'approve2'])->name('strout17.approve2');
        Route::post('/strout17/approve3', [StrOut17Controller::class, 'approve3'])->name('strout17.approve3');
        Route::get('/export', 'StrOut17Controller@export')->name('strout17.export');
        Route::get('/strout17/export-summary', [StrOut17Controller::class, 'exportSummary'])->name('strout17.export.summary');
        Route::get('/get-actual', [StrOut17Controller::class, 'getActual'])->name('strout17.getActual');
        Route::post('/saveChecked', 'StrOut17Controller@saveChecked')->name('strout17.saveChecked');

    });

    Route::group(['prefix' => 'strout18'], function () {
        Route::get('/', 'StrOut18Controller@index')->name('strout18.index');
        Route::get('/list', 'StrOut18Controller@list')->name('strout18.list');
        Route::get('/edit2', 'StrOut18Controller@edit2')->name('strout18.edit2');
        Route::get('/getdoc', 'StrOut18Controller@getdoc')->name('strout18.getdoc');
        Route::get('/listdetail', 'StrOut18Controller@listdetail')->name('strout18.listdetail');
        Route::get('/listdetail2', 'StrOut18Controller@listdetail2')->name('strout18.listdetail2');
        Route::get('/listdetail3', 'StrOut18Controller@listdetail3')->name('strout18.listdetail3');
        Route::post('/create', 'StrOut18Controller@store')->name('strout18.store');
        Route::post('/submit', 'StrOut18Controller@submit')->name('strout18.submit');
        Route::post('/delete_draft', 'StrOut18Controller@delete_draft')->name('strout18.delete_draft');
        Route::get('/edit', 'StrOut18Controller@edit')->name('strout18.edit');
        Route::post('/delete', 'StrOut18Controller@destroy')->name('strout18.destroy');
        Route::post('/deleteline', 'StrOut18Controller@destroyline')->name('strout18.destroyline');
        Route::post('/update', 'StrOut18Controller@update')->name('strout18.update');
        Route::post('/update2', 'StrOut18Controller@update2')->name('strout18.update2');
        Route::post('/approve', [StrOut18Controller::class, 'approve'])->name('strout18.approve');
        Route::post('/strout18/approve2', [StrOut18Controller::class, 'approve2'])->name('strout18.approve2');
        Route::post('/strout18/approve3', [StrOut18Controller::class, 'approve3'])->name('strout18.approve3');
        Route::get('/export', 'StrOut18Controller@export')->name('strout18.export');
        Route::get('/strout18/export-summary', [StrOut18Controller::class, 'exportSummary'])->name('strout18.export.summary');
        Route::get('/get-actual', [StrOut18Controller::class, 'getActual'])->name('strout18.getActual');
        Route::post('/saveChecked', 'StrOut18Controller@saveChecked')->name('strout18.saveChecked');

    });

    Route::group(['prefix' => 'strout19'], function () {
        Route::get('/', 'StrOut19Controller@index')->name('strout19.index');
        Route::get('/list', 'StrOut19Controller@list')->name('strout19.list');
        Route::get('/edit2', 'StrOut19Controller@edit2')->name('strout19.edit2');
        Route::get('/getdoc', 'StrOut19Controller@getdoc')->name('strout19.getdoc');
        Route::get('/listdetail', 'StrOut19Controller@listdetail')->name('strout19.listdetail');
        Route::get('/listdetail2', 'StrOut19Controller@listdetail2')->name('strout19.listdetail2');
        Route::get('/listdetail3', 'StrOut19Controller@listdetail3')->name('strout19.listdetail3');
        Route::post('/create', 'StrOut19Controller@store')->name('strout19.store');
        Route::post('/submit', 'StrOut19Controller@submit')->name('strout19.submit');
        Route::post('/delete_draft', 'StrOut19Controller@delete_draft')->name('strout19.delete_draft');
        Route::get('/edit', 'StrOut19Controller@edit')->name('strout19.edit');
        Route::post('/delete', 'StrOut19Controller@destroy')->name('strout19.destroy');
        Route::post('/deleteline', 'StrOut19Controller@destroyline')->name('strout19.destroyline');
        Route::post('/update', 'StrOut19Controller@update')->name('strout19.update');
        Route::post('/update2', 'StrOut19Controller@update2')->name('strout19.update2');
        Route::post('/approve', [StrOut19Controller::class, 'approve'])->name('strout19.approve');
        Route::post('/strout19/approve2', [StrOut19Controller::class, 'approve2'])->name('strout19.approve2');
        Route::post('/strout19/approve3', [StrOut19Controller::class, 'approve3'])->name('strout19.approve3');
        Route::get('/export', 'StrOut19Controller@export')->name('strout19.export');
        Route::get('/strout19/export-summary', [StrOut19Controller::class, 'exportSummary'])->name('strout19.export.summary');
        Route::get('/get-actual', [StrOut19Controller::class, 'getActual'])->name('strout19.getActual');
        Route::post('/saveChecked', 'StrOut19Controller@saveChecked')->name('strout19.saveChecked');

    });

    Route::group(['prefix' => 'strout20'], function () {
        Route::get('/', 'StrOut20Controller@index')->name('strout20.index');
        Route::get('/list', 'StrOut20Controller@list')->name('strout20.list');
        Route::get('/edit2', 'StrOut20Controller@edit2')->name('strout20.edit2');
        Route::get('/getdoc', 'StrOut20Controller@getdoc')->name('strout20.getdoc');
        Route::get('/listdetail', 'StrOut20Controller@listdetail')->name('strout20.listdetail');
        Route::get('/listdetail2', 'StrOut20Controller@listdetail2')->name('strout20.listdetail2');
        Route::get('/listdetail3', 'StrOut20Controller@listdetail3')->name('strout20.listdetail3');
        Route::post('/create', 'StrOut20Controller@store')->name('strout20.store');
        Route::post('/submit', 'StrOut20Controller@submit')->name('strout20.submit');
        Route::post('/delete_draft', 'StrOut20Controller@delete_draft')->name('strout20.delete_draft');
        Route::get('/edit', 'StrOut20Controller@edit')->name('strout20.edit');
        Route::post('/delete', 'StrOut20Controller@destroy')->name('strout20.destroy');
        Route::post('/deleteline', 'StrOut20Controller@destroyline')->name('strout20.destroyline');
        Route::post('/update', 'StrOut20Controller@update')->name('strout20.update');
        Route::post('/update2', 'StrOut20Controller@update2')->name('strout20.update2');
        Route::post('/approve', [StrOut20Controller::class, 'approve'])->name('strout20.approve');
        Route::post('/strout20/approve2', [StrOut20Controller::class, 'approve2'])->name('strout20.approve2');
        Route::post('/strout20/approve3', [StrOut20Controller::class, 'approve3'])->name('strout20.approve3');
        Route::get('/export', 'StrOut20Controller@export')->name('strout20.export');
        Route::get('/strout20/export-summary', [StrOut20Controller::class, 'exportSummary'])->name('strout20.export.summary');
        Route::get('/get-actual', [StrOut20Controller::class, 'getActual'])->name('strout20.getActual');
        Route::post('/saveChecked', 'StrOut20Controller@saveChecked')->name('strout20.saveChecked');

    });


});









