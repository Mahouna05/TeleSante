<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardPatientController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\PaiementController;

Route::get('/dashboard', [DashboardPatientController::class, 'index'])->name('dashboard');

Route::prefix('rendez-vous')->name('rendez-vous.')->group(function () {
    Route::get('/', [RendezVousController::class, 'index'])->name('index');
    Route::get('/create', [RendezVousController::class, 'create'])->name('create');
    Route::post('/', [RendezVousController::class, 'store'])->name('store');
    Route::get('/{rendezVous}/edit', [RendezVousController::class, 'edit'])->name('edit');
    Route::put('/{rendezVous}', [RendezVousController::class, 'update'])->name('update');
    Route::delete('/{rendezVous}', [RendezVousController::class, 'destroy'])->name('destroy');
});
Route::prefix('consultations')->name('consultations.')->group(function () {
    Route::get('/', [ConsultationController::class, 'index'])->name('index');
    Route::get('/{consultation}', [ConsultationController::class, 'show'])->name('show');
    Route::get('/join/{rendezVous}', [ConsultationController::class, 'join'])->name('join');
});
Route::prefix('medicaments')->name('medicaments.')->group(function () {
    Route::get('/', [MedicamentController::class, 'index'])->name('index');
    Route::get('/ordonnances/{ordonnance}', [MedicamentController::class, 'showOrdonnance'])->name('ordonnance.show');
    Route::post('/commander', [MedicamentController::class, 'commander'])->name('commander');
    Route::get('/ordonnances/{ordonnance}/imprimer', [MedicamentController::class, 'imprimerOrdonnance'])->name('ordonnance.imprimer');
});
Route::prefix('dossier-medical')->name('dossier-medical.')->group(function () {
    Route::get('/', [DossierMedicalController::class, 'index'])->name('index');
    Route::get('/details', [DossierMedicalController::class, 'details'])->name('details');
    Route::get('/consultations/{consultation}', [DossierMedicalController::class, 'showConsultation'])->name('consultation');
    Route::get('/telecharger', [DossierMedicalController::class, 'telecharger'])->name('telecharger');
});
Route::prefix('paiements')->name('paiements.')->group(function () {
    Route::get('/', [PaiementController::class, 'index'])->name('index');
    Route::get('/effectuer/{consultation}', [PaiementController::class, 'effectuer'])->name('effectuer');
    Route::post('/process', [PaiementController::class, 'process'])->name('process');
    Route::get('/recu/{paiement}', [PaiementController::class, 'recu'])->name('recu');
});