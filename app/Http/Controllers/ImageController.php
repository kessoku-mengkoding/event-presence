<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public static function upload_external(Request $request)
    {
        $apiKey = env('IMGBB_API_KEY');

        $response = Http::withoutVerifying()->attach(
            'image',
            file_get_contents($request->file('image')->path()),
            $request->file('image')->getClientOriginalName()
        )->post('https://api.imgbb.com/1/upload?key=' . $apiKey);

        $imageUrl = json_decode($response->getBody())->data->url;

        return $imageUrl;
    }

    public static function generateQrUrl($string)
    {
        $response = Http::post(env('QR_SERVICE_URL') . "/write", [
            'string' => $string
        ]);
        return $response->body();
    }

    public function changeProfilePicture($id, Request $request)
    {
        $id = $id == 'me' ? Auth::id() : $id;

        try {
            $imageUrl = $this::upload_external($request);

            if ($imageUrl) {
                DB::table('users')
                    ->where('id', Auth::id())
                    ->update(['profile_picture_path' => $imageUrl]);

                return back()->with('message', 'Change profile picture success');
            } else {
                return back()->with('error', 'Image upload failed');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $id = $id == 'me' ? Auth::id() : $id;

        DB::table('users')
            ->where('id', $id)
            ->update(['profile_picture_path' => null]);

        return back()->with('message', 'Delete  profile picture success');
    }
}
