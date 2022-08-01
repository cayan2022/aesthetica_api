<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\{
    CountryController,
    RolesController,
    CategoryController,
    ServiceController,
    OfferController,
    DoctorController,
    SourceController,
    BranchController,
    StatusController,
    SubStatusController,
    SettingController,
    TestimonialController,
    AboutController,
    ProfileController,
    ChangePasswordController

};
//route naming is need to make check_permissions middleware
Route::as('dashboard.')
    ->middleware(['auth:sanctum','check_permissions'])
    ->prefix('dashboard')
    ->group(function () {

        //profile
        Route::as('profiles.')
            ->prefix('profile')->group(function () {
                Route::get('all', [ProfileController::class, 'index'])->name('index');
                Route::get('show/{user}', [ProfileController::class, 'show'])->name('show');
                Route::post('store', [ProfileController::class, 'store'])->name('store');
                Route::post('update/{user}', [ProfileController::class, 'update'])->name('update');
                Route::post('change-password', ChangePasswordController::class)->name('changepassword');
                Route::post('logout/{user}', [ProfileController::class, 'logout'])->name('logout');
                Route::post('block/{user}', [ProfileController::class, 'block'])->name('block');
                Route::post('active/{user}', [ProfileController::class, 'active'])->name('active');
            });

        //Roles
        Route::as('roles.')
            ->prefix('roles')->group(function () {
                Route::get('get-roles', [RolesController::class, 'getRoles'])->name('index');
                Route::get('get-role-permissions', [RolesController::class, 'getRolePermissions'])->name('show');
                Route::post('add-role', [RolesController::class, 'addRole'])->name('store');
                Route::post('assignRoleToUser', [RolesController::class, 'assignRoleToUser'])->name('assign');
            });

        //Permissions
        Route::as('permissions.')
            ->prefix('permissions')->group(function () {
                Route::get('get-permissions', [RolesController::class, 'getPermissions'])->name('index');
                Route::post('add-permission', [RolesController::class, 'addPermission'])->name('store');
            });

        //pages
        Route::as('pages.')
            ->prefix('pages')->group(function () {
                /*doctors*/
                Route::group([], function (){
                    Route::put('doctors/{doctor}/block',[DoctorController::class,'block'])->name('doctors.block');
                    Route::put('doctors/{doctor}/active',[DoctorController::class,'active'])->name('doctors.active');
                    Route::post('doctors/{doctor}',[DoctorController::class,'update'])->name('doctors.update');
                    Route::apiResource('doctors',DoctorController::class)->except('update');
                });
                /*testimonials*/
                Route::group([], function (){
                    Route::put('testimonials/{testimonial}/block',[TestimonialController::class,'block'])->name('testimonials.block');
                    Route::put('testimonials/{testimonial}/active',[TestimonialController::class,'active'])->name('testimonials.active');
                    Route::post('testimonials/{testimonial}',[TestimonialController::class,'update'])->name('testimonials.update');
                    Route::apiResource('testimonials',TestimonialController::class)->except('update');
                });
                Route::apiResources([
                    'categories' => CategoryController::class,
                    'services' => ServiceController::class,
                    'offers' => OfferController::class,
                    'sources' => SourceController::class,
                    'branches' => BranchController::class,
                    'statuses' => StatusController::class,
                    'substatuses' => SubStatusController::class,
                    'settings' => SettingController::class,
                    'abouts' => AboutController::class,
                    'countries' => CountryController::class
                ]);
            });
    });
