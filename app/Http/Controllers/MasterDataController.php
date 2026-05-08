<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\EmploymentStatus;
use App\Models\Personil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterDataController extends Controller
{
    public function createBidang()
    {
        $this->ensureAdmin();

        return view('master-data.bidang-form', [
            'bidang' => new Bidang(),
            'formAction' => route('bidang.store'),
            'formMethod' => 'POST',
            'pageTitle' => 'Tambah Bidang',
        ]);
    }

    public function storeBidang(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:bidangs,name',
        ]);

        Bidang::create($data);

        return redirect()->route('dashboard.index')->with('success', 'Bidang berhasil ditambahkan');
    }

    public function editBidang(Bidang $bidang)
    {
        $this->ensureAdmin();

        return view('master-data.bidang-form', [
            'bidang' => $bidang,
            'formAction' => route('bidang.update', $bidang),
            'formMethod' => 'PUT',
            'pageTitle' => 'Edit Bidang',
        ]);
    }

    public function updateBidang(Request $request, Bidang $bidang)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bidangs', 'name')->ignore($bidang->id),
            ],
        ]);

        $bidang->update($data);

        return redirect()->route('dashboard.index')->with('success', 'Bidang berhasil diperbarui');
    }

    public function createPersonil()
    {
        $this->ensureAdmin();

        return view('master-data.personil-form', [
            'bidangs' => Bidang::orderBy('name')->get(),
            'employmentStatuses' => EmploymentStatus::orderBy('name')->get(),
            'personil' => new Personil(),
            'formAction' => route('personil.store'),
            'formMethod' => 'POST',
            'pageTitle' => 'Tambah Nama',
        ]);
    }

    public function storePersonil(Request $request)
    {
        $this->ensureAdmin();

        $data = $this->validatePersonil($request);

        Personil::create($data);

        return redirect()->route('dashboard.index')->with('success', 'Nama personil berhasil ditambahkan');
    }

    public function editPersonil(Personil $personil)
    {
        $this->ensureAdmin();

        return view('master-data.personil-form', [
            'bidangs' => Bidang::orderBy('name')->get(),
            'employmentStatuses' => EmploymentStatus::orderBy('name')->get(),
            'personil' => $personil,
            'formAction' => route('personil.update', $personil),
            'formMethod' => 'PUT',
            'pageTitle' => 'Edit Nama',
        ]);
    }

    public function updatePersonil(Request $request, Personil $personil)
    {
        $this->ensureAdmin();

        $data = $this->validatePersonil($request, $personil);

        $personil->update($data);

        return redirect()->route('dashboard.index')->with('success', 'Nama personil berhasil diperbarui');
    }

    private function validatePersonil(Request $request, ?Personil $personil = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('personils', 'name')
                    ->where('bidang_id', $request->input('bidang_id'))
                    ->ignore($personil?->id),
            ],
            'bidang_id' => 'required|exists:bidangs,id',
            'employment_status_id' => 'required|exists:employment_statuses,id',
        ]);
    }

    private function ensureAdmin(): void
    {
        if (!session('admin_logged_in')) {
            redirect()->route('login')->send();
            exit;
        }
    }
}
