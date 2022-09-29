<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Image;

class BannerController extends Controller
{
    public function upload(Request $request){
        $file = $request->file('image');
        $fileName = Carbon::now()->timestamp . '.' . $file->extension();
        #YY-MM-DD
        $now = Carbon::now()->toDateTimeString();
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $day = Carbon::now()->format('d');

        #.jpg,.cgv,...
        $extension = $file->getClientOriginalExtension();

        #name
        $fileName = rand(11111, 99999) . '.' . $extension;

        #size
        $size = $file->getSize();

        #$path
        $storage = Storage::disk('public')->url('');

        $url = URL::to('/') . Storage::url('images/' . $fileName);
        $path =('images/' . $fileName);
        $getimagesize = getimagesize($file);
        Storage::disk('public')->put('/images/' . $fileName, $file->getContent());
//        dd($fileName);
        #sau khi lưu ảnh vào storage bắt đầu xử lý ảnh.
        $pathStorage = Storage::disk('public')->url('/');
        #đường dẫn ảnh
        $pathImage = $pathStorage.'images/'.$fileName;
        #size
        $size = Storage::disk('public')->size('images/'.$fileName);
        #get width and height in storage
        $getimagesizeStorage = getimagesize($pathImage);

        #check width > 400 or heigh > 600 resize
        if($getimagesizeStorage[0] > 600 || $getimagesizeStorage[1]> 400){
            $resize_image = Image::make($pathImage);
            $resize_image->resize(600,400);
//            $resize_image->save(storage_path("app/public/images/".$fileName));
            $resize_image->save($pathStorage.'public/images/'.$fileName);

        }
//        dd('resize thanh công');
        $data = [
            "file" => $path
        ];


        $banner = new Banner();
        $banner->image = $path;
        $banner->save();

        $data = array_merge([
            'code' => 200,
            'success' => true
        ], $banner->toArray());
        return response()->json($data, 200);


    }
}
