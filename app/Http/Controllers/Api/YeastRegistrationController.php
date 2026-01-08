<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreYeastRegistrationRequest;
use App\Http\Resources\YeastRegistrationResource;
use App\Models\YeastRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class YeastRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $registrations = YeastRegistration::query()
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Yeast registrations retrieved successfully',
            'data' => YeastRegistrationResource::collection($registrations)->response()->getData(true),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreYeastRegistrationRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle file uploads
        if ($request->hasFile('identification_document')) {
            $data['identification_document_path'] = $request->file('identification_document')
                ->store('registrations/identifications', 'public');
        }

        if ($request->hasFile('certificates')) {
            $data['certificates_path'] = $request->file('certificates')
                ->store('registrations/certificates', 'public');
        }

        if ($request->hasFile('passport_photograph')) {
            $data['passport_photograph_path'] = $request->file('passport_photograph')
                ->store('registrations/photographs', 'public');
        }

        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')
                ->store('registrations/cvs', 'public');
        }

        if ($request->hasFile('supporting_documents')) {
            $data['supporting_documents_path'] = $request->file('supporting_documents')
                ->store('registrations/supporting-documents', 'public');
        }

        // Set declaration date
        $data['declaration_date'] = now();

        // Create registration
        $registration = YeastRegistration::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Registration submitted successfully',
            'data' => new YeastRegistrationResource($registration),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(YeastRegistration $yeastRegistration): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Registration retrieved successfully',
            'data' => new YeastRegistrationResource($yeastRegistration),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YeastRegistration $yeastRegistration): JsonResponse
    {
        $data = $request->all();

        // Handle file uploads if present
        if ($request->hasFile('identification_document')) {
            if ($yeastRegistration->identification_document_path) {
                Storage::disk('public')->delete($yeastRegistration->identification_document_path);
            }
            $data['identification_document_path'] = $request->file('identification_document')
                ->store('registrations/identifications', 'public');
        }

        if ($request->hasFile('certificates')) {
            if ($yeastRegistration->certificates_path) {
                Storage::disk('public')->delete($yeastRegistration->certificates_path);
            }
            $data['certificates_path'] = $request->file('certificates')
                ->store('registrations/certificates', 'public');
        }

        if ($request->hasFile('passport_photograph')) {
            if ($yeastRegistration->passport_photograph_path) {
                Storage::disk('public')->delete($yeastRegistration->passport_photograph_path);
            }
            $data['passport_photograph_path'] = $request->file('passport_photograph')
                ->store('registrations/photographs', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($yeastRegistration->cv_path) {
                Storage::disk('public')->delete($yeastRegistration->cv_path);
            }
            $data['cv_path'] = $request->file('cv')
                ->store('registrations/cvs', 'public');
        }

        if ($request->hasFile('supporting_documents')) {
            if ($yeastRegistration->supporting_documents_path) {
                Storage::disk('public')->delete($yeastRegistration->supporting_documents_path);
            }
            $data['supporting_documents_path'] = $request->file('supporting_documents')
                ->store('registrations/supporting-documents', 'public');
        }

        $yeastRegistration->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Registration updated successfully',
            'data' => new YeastRegistrationResource($yeastRegistration->fresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YeastRegistration $yeastRegistration): JsonResponse
    {
        // Delete associated files
        $filePaths = [
            $yeastRegistration->identification_document_path,
            $yeastRegistration->certificates_path,
            $yeastRegistration->passport_photograph_path,
            $yeastRegistration->cv_path,
            $yeastRegistration->supporting_documents_path,
        ];

        foreach ($filePaths as $filePath) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        $yeastRegistration->delete();

        return response()->json([
            'success' => true,
            'message' => 'Registration deleted successfully',
        ]);
    }
}
