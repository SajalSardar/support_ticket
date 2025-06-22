<?php

namespace App\LocaleStorage;

use App\Enums\Bucket;
use App\Models\Image;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class Fileupload
{
    /**
     * Define public method upload() to upload the file server and database
     * @param array|object $request
     * @param Bucket $bucket
     * @param int $model_id int
     * @param $model
     * @param int $width
     * @param int $height
     * @param $request
     * @return array|object|bool|string
     */
    public static function upload(array|object $request, Bucket $bucket, int $model_id, $model, int $width, int $height): array|object|bool|string
    {
        $filename = Str::slug($request->name) . '-' . uniqid() . '-' . $request->image->getClientOriginalName();
        $size = $request->image->getSize() . 'bytes';
        $image = ImageManager::gd()->read($request->image);
        $final_image = $image->resize($width, $height);
        $isUpload = $final_image->save(storage_path('app/public/' . $bucket->toString() . '/' . $filename));
        $url = asset('storage/' . $bucket->toString() . '/' . $filename);

        if ($isUpload) {
            $imageDatabase = Image::create(
                [
                    'image_id' => $model_id,
                    'image_type' => $model,
                    'name'  => $filename,
                    'path' => $bucket->toString(),
                    'disk' => 'local',
                    'url' => $url,
                    'mime' => $request->image->getClientOriginalExtension(),
                    'size' => $size,
                ]
            );
            return $imageDatabase;
        } else {
            return false;
        }
    }

    /**
     * Define public method fileupload to upload the file server and database
     * @param array|object $request
     * @param int $model_id int
     * @param $oldCategory
     * @param $model
     * @param int $width
     * @param int $height
     * @param $request
     * @return array|object|bool|string|null
     */
    public static function update(array|object $request, Bucket $bucket, $oldItem, int $model_id, $model, int $width, int $height)
    {
        if ($request->image) {
            if (!empty($oldItem?->image?->path) && !empty($oldItem?->image?->filename)) {
                $fileToDelete = storage_path('app/public/' . $oldItem->image->path . '/' . $oldItem->image->filename);
                if (file_exists($fileToDelete)) {
                    unlink($fileToDelete);
                }
            }
            $filename = Str::slug($request->name) . '-' . uniqid() . '-' . $request->image->getClientOriginalName();
            $size = $request->image->getSize() . 'bytes';
            $image = ImageManager::gd()->read($request->image);
            $final_image = $image->resize($width, $height);
            $isUpload = $final_image->save(storage_path('app/public/' . $bucket->toString() . '/' . $filename));
            $url = asset('storage/' . $bucket->toString() . '/' . $filename);

            if ($isUpload) {
                $imageDatabase = Image::where('image_type', $model)->updateOrCreate(
                    [
                        'image_id' => $oldItem->id
                    ],
                    [
                        'image_id' => $model_id,
                        'image_type' => $model,
                        'name'  => $filename,
                        'path' => $bucket->toString(),
                        'disk' => 'local',
                        'url' => $url,
                        'mime' => $request->image->getClientOriginalExtension(),
                        'size' => $size,
                    ]
                );
                return $imageDatabase;
            } else {
                return false;
            }
        }
    }

    /**
     * Define public method uploadFile() to uploadFile the file server and database
     * @param array|object $request
     * @param Bucket $bucket
     * @param int $model_id int
     * @param $model
     * @return array|object|bool|string
     */
    public static function uploadFile(array|object $request, Bucket $bucket, int $model_id, $model): array|object|bool|string
    {
        $filename = uniqid() . '-+' . $request->request_attachment->getClientOriginalName();
        $size = $request->request_attachment->getSize() . ' bytes';
        $isUpload = $request->request_attachment->storeAs($bucket->toString(), $filename, 'public');
        $url = asset('storage/' . $bucket->toString() . '/' . $filename);

        if ($isUpload) {
            $imageDatabase = Image::create(
                [
                    'image_id' => $model_id,
                    'image_type' => $model,
                    'name'  => $filename,
                    'path' => $bucket->toString(),
                    'disk' => 'local',
                    'url' => $url,
                    'mime' => $request->request_attachment->getClientOriginalExtension(),
                    'size' => $size,
                ]
            );
            return $imageDatabase;
        } else {
            return false;
        }
    }

    /**
     * Define public method uploadFiles() to uploadFile the file server and database
     * @param array|object $request
     * @param Bucket $bucket
     * @param int $model_id int
     * @param $model
     * @return array|object|bool|string
     */
    public static function uploadFiles(array|object $request, Bucket $bucket, int $model_id, $model)
    {
        $uploadedImages = [];

        foreach ($request->request_attachment as $key => $file) {
            $filename = uniqid() . '-+' . $file->getClientOriginalName();
            $size = $file->getSize() . ' bytes';
            $isUpload = $file->storeAs($bucket->toString(), $filename, 'public');
            $url = asset('storage/' . $bucket->toString() . '/' . $filename);

            if ($isUpload) {
                $imageDatabase = Image::create([
                    'image_id' => $model_id,
                    'image_type' => $model,
                    'name'  => $filename,
                    'path' => $bucket->toString(),
                    'disk' => 'local',
                    'url' => $url,
                    'mime' => $request->request_attachment->getClientOriginalExtension(),
                    'size' => $size,
                ]);

                $uploadedImages[] = $imageDatabase;
            } else {
                return false;
            }
        }

        return $uploadedImages;
    }


    /**
     * Define public method uploadFile() to uploadFile the file server and database
     * @param array|object $request
     * @param Bucket $bucket
     * @param int $model_id int
     * @param $model
     * @return array|object|bool|string
     */
    public static function updateFile(array|object $request, Bucket $bucket, $oldItem, $model_id, $model): array|object|bool|string
    {
        if (!empty($oldItem?->image?->path) && !empty($oldItem?->image?->filename)) {
            $fileToDelete = storage_path('app/public/' . $oldItem->image->path . '/' . $oldItem?->image?->filename);
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }

        $filename = uniqid() . '-+' . $request->request_attachment->getClientOriginalName();
        $size = $request->request_attachment->getSize() . ' bytes';
        $isUpload = $request->request_attachment->storeAs($bucket->toString(), $filename, 'public');
        $url = asset('storage/' . $bucket->toString() . '/' . $filename);
        if ($isUpload) {
            $imageDatabase = Image::updateOrCreate(
                ['image_id' => $model_id],
                [
                    'image_id' => $model_id,
                    'image_type' => $model,
                    'name'  => $filename,
                    'path' => $bucket->toString(),
                    'disk' => 'local',
                    'url' => $url,
                    'mime' => $request->request_attachment?->getClientOriginalExtension(),
                    'size' => $size,
                ]
            );

            return $imageDatabase;
        } else {
            return false;
        }
    }
}
