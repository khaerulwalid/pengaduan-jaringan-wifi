<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SLAService;
use App\Http\Requests\CreateSLARequest;
use App\Http\Requests\UpdateSLARequest;

class SLAController extends Controller
{
    protected $slaService;

    public function __construct(SLAService $slaService)
    {
        $this->slaService = $slaService;
    }

    // Menampilkan daftar SLA
    public function index()
    {
        $slas = $this->slaService->getAllSLAs(10);
        return view('sla.index', compact('slas'));
    }

    // Menampilkan form tambah SLA
    public function create()
    {
        return view('sla.create');
    }

    // Menyimpan SLA baru
    public function store(CreateSLARequest $request)
    {
        $result = $this->slaService->createSLA($request->validated());

        if (isset($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('sla.index')->with('success', 'SLA created successfully.');
    }

    // Menampilkan form edit SLA
    public function edit($id)
    {
        $sla = $this->slaService->getSLAById($id);

        if (!$sla) {
            return redirect()->route('sla.index')->with('error', 'SLA not found.');
        }

        return view('sla.edit', compact('sla'));
    }

    // Update SLA
    public function update(UpdateSLARequest $request, $id)
    {
        $result = $this->slaService->updateSLA($id, $request->validated());

        if (isset($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('sla.index')->with('success', 'SLA updated successfully.');
    }

    // Hapus SLA
    public function destroy($id)
    {
        $sla = $this->slaService->getSLAById($id);

        if (!$sla) {
            return redirect()->route('sla.index')->with('error', 'SLA not found.');
        }

        try {
            $this->slaService->deleteSLA($id);
            return redirect()->route('sla.index')->with('success', 'SLA deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('sla.index')->with('error', 'Failed to delete SLA. It may be in use.');
        }
    }
}
