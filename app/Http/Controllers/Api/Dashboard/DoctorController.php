<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreDoctorRequest;
use App\Http\Requests\Api\Dashboard\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DoctorController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return DoctorResource::collection(Doctor::filter()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\StoreDoctorRequest  $request
     * @return Response
     */
    public function store(StoreDoctorRequest $request)
    {
        $doctor=Doctor::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $doctor->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Doctor::MEDIA_COLLECTION_NAME);
        }
        return $doctor->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Doctor  $doctor
     * @return DoctorResource
     */
    public function show(Doctor $doctor)
    {
        return $doctor->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDoctorRequest  $request
     * @param  Doctor  $doctor
     * @return DoctorResource
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $doctor->clearMediaCollection(Doctor::MEDIA_COLLECTION_NAME);
            $doctor->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Doctor::MEDIA_COLLECTION_NAME);
        }

        return $doctor->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Doctor  $doctor
     * @return Response
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Doctor $doctor
     * @return Application|ResponseFactory|Response
     */
    public function block(Doctor $doctor)
    {
        $doctor->block();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Doctor $doctor
     * @return Application|ResponseFactory|Response
     */
    public function active(Doctor $doctor)
    {
        $doctor->active();
        return $this->success(__('auth.success_operation'));
    }
}
