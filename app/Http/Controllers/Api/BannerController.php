<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

        Storage::disk('public')->put('/images/' . $fileName, $file->getContent());

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
