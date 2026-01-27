<?php

use App\Http\Controllers\Api\AliyunICE\BatchMediaProducingJobController;
use App\Http\Controllers\Api\AliyunICE\CallbackController;
use App\Http\Controllers\Api\AliyunICE\MediaController;
use App\Http\Controllers\Api\AliyunICE\MediaProducingJobController;
use App\Http\Controllers\Api\AliyunOSS\UploadController;
use App\Http\Controllers\Api\AliyunICE\TemplateController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\UserFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name("login");
});
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('status', [AuthController::class, 'status']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::group(['prefix' => 'file-upload'], function () {
        Route::post('simple', [FileUploadController::class, 'simple']);
        Route::get('index', [FileUploadController::class, 'index']);
        Route::post('upload-video-to-aliyun-oss', [FileUploadController::class, 'uploadVideoToAliyunOss']);
        Route::post('credential', [FileUploadController::class, 'credential']);
    });
    Route::group(['prefix' => 'aliyun-oss'], function () {
        Route::post('sign-url', [UploadController::class, 'signUrl']);
    });
    Route::group(['prefix' => 'user-file'], function () {
        Route::post('store', [UserFileController::class, 'store']);
        Route::post('update', [UserFileController::class, 'update']);
    });
    Route::group(['prefix' => 'aliyun-ice'], function () {
        Route::post('register', [MediaController::class, 'registerMedia']);

        // /api/aliyun-ice/batch-media-producing-job/create
        Route::group(['prefix' => 'batch-media-producing-job'], function () {
            Route::post('create', [BatchMediaProducingJobController::class, 'create']);
            Route::post('submit', [BatchMediaProducingJobController::class, 'submit']);
            Route::post('sync', [BatchMediaProducingJobController::class, 'sync']);
            Route::post('delete', [BatchMediaProducingJobController::class, 'delete']);
            Route::post('list', [BatchMediaProducingJobController::class, 'list']);
            Route::post('show', [BatchMediaProducingJobController::class, 'show']);
            Route::post('update', [BatchMediaProducingJobController::class, 'update']);
        });
        Route::group(['prefix' => 'media-producing-job'], function () {
            Route::post('create', [MediaProducingJobController::class, 'create']);
            Route::post('sync', [MediaProducingJobController::class, 'sync']);
        });
        Route::group(['prefix' => 'media'], function () {
            Route::post('register', [MediaController::class, 'register']);
            Route::post('sync', [MediaController::class, 'sync']);
            Route::post('sync-list', [MediaController::class, 'syncList']);
            Route::post('delete', [MediaController::class, 'delete']);
        });
        Route::group(['prefix' => 'template'], function () {
            Route::post('add', [TemplateController::class, 'create']);
            Route::get('list', [TemplateController::class, 'index']);
            Route::post('sync', [TemplateController::class, 'sync']);
        });
    });
});

Route::group(['prefix' => 'aliyun-oss'], function () {
    Route::post('sign-url-test', [UploadController::class, 'signUrl']);
});
Route::group(['middleware' => 'aliyun.ice.callback.verify', 'prefix' => 'aliyun-ice'], function () {
    Route::any('callback', [CallbackController::class, 'index']);
    Route::group(['prefix' => 'batch-media-producing-job'], function () {
        Route::any('hook', [BatchMediaProducingJobController::class, 'hook']);
    });
    Route::group(['prefix' => 'media-producing-job'], function () {
        Route::any('hook', [MediaProducingJobController::class, 'hook']);
    });
    Route::group(['prefix' => 'media'], function () {
        // Route::any('hook', [MediaController::class, 'hook']);
        Route::any('hook', [CallbackController::class, 'index']);
    });
});
