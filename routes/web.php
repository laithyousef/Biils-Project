<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/page', [AdminController::class, 'index'])->name('index');

    Route::get('/index', [HomeController::class, 'index'])->name('index');


    Route::resource('sections' ,SectionController::class, ['except' => ['create', 'show', 'edit']]);
    Route::resource('products', ProductController::class, ['except' => ['create','show', 'edit']]);
    Route::get('section/{id}', [InvoicesController::class, 'getProducts']);


    Route::resource('invoices' ,InvoicesController::class);
    Route::get('show_status/{id}', [InvoicesController::class, 'show_status'])->name('invoices.show_status');
    Route::put('update_status/{id}', [InvoicesController::class, 'update_status'])->name('invoices.update_status');
    Route::get('Print_invoice/{id}', [InvoicesController::class, 'print_invoice']);
    Route::get('invoicesInfo/{id}', [InvoicesController::class, 'show']);
    Route::get('invoices.MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');


    Route::get('View_file/{invoice_number}/{file_name}', [InvoiceAttachmentsController::class, 'showFile']);
    Route::get('download/{invoice_number}/{file_name}', [InvoiceAttachmentsController::class, 'downloadFile']);
    Route::resource('invoicesInfo/invoices_Attachments', InvoiceAttachmentsController::class, ['except' => ['index','create','show', 'edit']]);


    Route::get('paid_invoices', [InvoiceDetailsController::class, 'show_paid_invoices'])->name('paid_invoices');
    Route::get('unpaid_invoices', [InvoiceDetailsController::class, 'show_unpaid_invoices'])->name('unpaid_invoices');
    Route::get('partial_paid_invoices', [InvoiceDetailsController::class, 'show_partial_paid_invoices'])->name('partial_paid_invoices');

    Route::resource('Archive_invoices', InvoicesArchiveController::class, ['except' => ['create','edit','show','store']]);


    Route::get('invoices_report', [ReportController::class, 'index'])->name('invoices_report');
    Route::post('Search_invoices', [ReportController::class, 'Search_invoices'])->name('Search_invoices');
    Route::get('custormers_report', [ReportController::class, 'show_custormers_report'])->name('custormers_report');
    Route::post('Search_customers_invoices', [ReportController::class, 'Search_customers_invoices'])->name('Search_customers_invoices');



    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('users/{id}', [UserController::class, 'show_user_roles'])->name('show_user_roles');

});