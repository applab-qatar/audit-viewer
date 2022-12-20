<?php

use Illuminate\Support\Facades\Route;
use SeinOxygen\AuditViewer\Http\Controllers\AuditController;

Route::get('/', [AuditController::class, 'index'])->name('audit-viewer.audit.index');
Route::get('/model/{model}/{id?}', [AuditController::class, 'model'])->name('audit-viewer.audit.model');
Route::get('/audit/{id}', [AuditController::class, 'show'])->name('audit-viewer.audit.show');
Route::post('/audit/{id}/rollback/{field?}', [AuditController::class, 'rollback'])->name('audit-viewer.audit.rollback');