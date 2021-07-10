<?php

use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\ChecklistGroupController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Task;
use App\Notifications\SendReminderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'welcome')->name('home');

Auth::routes();


Route::group((['middleware' => ['auth', 'save_last_action']]), function () {
    Route::get('/welcome', [App\Http\Controllers\PageController::class, 'welcome'])->name('welcome');
    Route::get('/consultation', [App\Http\Controllers\PageController::class, 'consultaion'])->name('consultation');

    Route::get('checklist/{checklist}', [\App\Http\Controllers\User\ChecklistController::class, 'show'])->name('users.checklist.show');

    Route::get('task_list/{list_ype}', [\App\Http\Controllers\User\ChecklistController::class, 'taskList'])->name('users.checklist.tasklist');

    Route::get('/packages', [\App\Http\Controllers\User\PackageController::class, 'index'])->name('users.packages');

    Route::get('/{package_id}/payment', [\App\Http\Controllers\User\PackageController::class, 'payment'])->name('users.payment.create');

    Route::post('/{package_id}/payment', [\App\Http\Controllers\User\PackageController::class, 'storePayment'])->name('users.payment.store');

    Route::get('/billing-portal', function (Request $request) {
        return $request->user()->redirectToBillingPortal();
    })->name('users.billing_portal');

    Route::prefix('admin')->middleware(['is_admin'])->name('admin.')->group(function () {

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('checklist_groups', ChecklistGroupController::class)->except(['index', 'show']);

        Route::resource('checklist_groups.checklists', ChecklistController::class)->except(['show', 'index']);

        Route::resource('checklists.tasks', TaskController::class)->except(['index', 'show', 'create']);

        Route::resource('pages', PageController::class)->only(['store', 'edit', 'update']);

        Route::get('users', [UserController::class, 'index'])->name('users.index');

        Route::post('/cke-editor/image/uploads', [\App\Http\Controllers\Admin\ImageUpload::class, 'ckeEditorImageUpload'])->name('cke.editor.image.upload');
    });


    Route::get('/reminder/send', function () {

        $tasks = Task::query()->with('user')
            ->where('reminder_at', '<=', now()->toDateTimeString())
            ->get();

        foreach ($tasks as $task) {
            $task->user->notify(new SendReminderNotification($task));
            $task->update(['reminder_at' => null]);
        }

    });
});


