<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\UploadImage;

class ImageController extends Controller
{
    public function index()
    {
        $allImages = UploadImage::orderBy('id')->get()->groupBy('name');
        return view('image.index', compact('allImages'));
    }

    public function uploadImage(Request $request)
    {
       $validatedData = $request->validate([
        'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
       ]);
       //get file extension
       $extension = $request->file('image')->getClientOriginalExtension();

       //filename to store
        $filenametostore = time().'.'.$extension;

        //small thumbnail name
        $smallthumbnail = time().'_small.'.$extension;

        //medium thumbnail name
        $mediumthumbnail = time().'_medium.'.$extension;

        //large thumbnail name
        $largethumbnail = time().'_large.'.$extension;

        //Upload File
        $originalPath = $request->file('image')->storeAs('public/images', $filenametostore);
        $imagePath = 'storage/images/'.$filenametostore;
        $this->createThumbnail($filenametostore, 1024, 768, 'original', $imagePath, $filenametostore);

        $request->file('image')->storeAs('public/images/thumbnail', $smallthumbnail);
        $smallPath = 'storage/images/thumbnail/'.$smallthumbnail;

        $request->file('image')->storeAs('public/images/thumbnail', $mediumthumbnail);
        $mediumPath = 'storage/images/thumbnail/'.$mediumthumbnail;

        $request->file('image')->storeAs('public/images/thumbnail', $largethumbnail);
        $largetPath = 'storage/images/thumbnail/'.$largethumbnail;


        //create small thumbnail
        $smallthumbnailpath = public_path('storage/images/thumbnail/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 150, 93, 'small', $smallPath, $filenametostore);

        //create medium thumbnail
        $mediumthumbnailpath = public_path('storage/images/thumbnail/'.$mediumthumbnail);
        $this->createThumbnail($mediumthumbnailpath, 300, 185, 'medium', $mediumPath, $filenametostore);

        //create large thumbnail
        $largethumbnailpath = public_path('storage/images/thumbnail/'.$largethumbnail);
        $this->createThumbnail($largethumbnailpath, 550, 340, 'large', $largetPath, $filenametostore);

        return redirect('image')->with('success', "Image uploaded successfully.");
    }

    /**
     * Create a thumbnail of specified size
     *
     * @param string $path path of thumbnail
     * @param int $width
     * @param int $height
     */
    public function createThumbnail($path, $width, $height, $size , $storePath, $filenametostore)
    {
        if ($size != 'original') {
          $img = Image::make($path)->resize($width, $height, function ($constraint) {
              $constraint->aspectRatio();
          });
          $img->save($path);
          UploadImage::create([
              'name' => $filenametostore,
              'path' => $storePath,
              'size' => $size
          ]);

        } else {
          UploadImage::create([
              'name' => $filenametostore,
              'path' => $storePath,
              'size' => $size
          ]);
        }
    }
}
