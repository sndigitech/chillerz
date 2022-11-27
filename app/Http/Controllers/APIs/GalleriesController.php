<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\Gallery;
use Symfony\Component\HttpFoundation\Response;

class GalleriesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    { 
        return new GalleryResource(Gallery::all());
    }

    public function store(StoreGalleryRequest $request)
    {
        $gallery = Gallery::create($request->all());

        if ($request->input('photos', false)) {
            $gallery->addMedia(storage_path('tmp/uploads/' . $request->input('photos')))->toMediaCollection('photos');
        }

        return (new GalleryResource($gallery))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Gallery $gallery)
    {        

        return new GalleryResource($gallery);
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->all());

        if ($request->input('photos', false)) {
            if (!$gallery->photos || $request->input('photos') !== $gallery->photos->file_name) {
                $gallery->addMedia(storage_path('tmp/uploads/' . $request->input('photos')))->toMediaCollection('photos');
            }
        } elseif ($gallery->photos) {
            $gallery->photos->delete();
        }

        return (new GalleryResource($gallery))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Gallery $gallery)
    {       

        $gallery->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

