<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Enums\Bucket;
use App\Models\Image;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Ticket\TicketService;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\TicketCreateRequest;

class TicketController extends Controller {

    /**
     * Define public form object TicketCreateRequest $form
     */
    public TicketCreateRequest $form;

    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketService $service, Request $request) {

        $request->validate([
            'request_title'       => 'required',
            'request_description' => 'required',
            'category_id'         => 'required',
            'priority'            => 'required',
            'requester_name'      => 'required',
            'requester_email'     => 'required',
            'source_id'           => 'required',
            'ticket_status_id'    => 'required',
            'created_by'          => 'required',
            'attachments'         => 'nullable|array',
            'attachments.*'       => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,ppt|max:3024',
        ]);
        try {

            $isCreate = $service->store($request->all());

            if (!empty($request->attachments)) {
                foreach ($request->attachments as $file) {

                    $fileData = base64_decode($file['file']);

                    $filename = uniqid() . '-+' . '.jpg';

                    $size = 0 . ' bytes';
                    $url  = asset('storage/tickets/' . $filename);

                    $filePath = 'tickets/' . $filename;
                    Storage::put($filePath, $fileData);

                    $imageDatabase = Image::create([
                        'image_type' => 'jpg',
                        'image_id'   => $isCreate->getKey(),
                        'filename'   => $filename,
                        'disk'       => 'local',
                        'path'       => Bucket::TICKET,
                        'url'        => $url,
                        'size'       => $size,
                    ]);

                }
            }

            return response()->json([
                'message' => 'Request Created!',
            ]);
        } catch (Exception $e) {
            return response()->json([$e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
