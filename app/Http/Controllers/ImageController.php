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
    public function upload_external(Request $request)
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

    public function decode_qr_image($file_url)
    {
        // http://api.qrserver.com/v1/read-qr-code/?fileurl=http%3A%2F%2Fapi.qrserver.com%2Fv1%2Fcreate-qr-code%2F%3Fdata%3DHelloWorld
        $response = Http::get('http://api.qrserver.com/v1/read-qr-code/?fileurl='. urlencode($file_url));

        dd($file_url, $response);
    }

    public function changeProfilePicture($id, Request $request)
    {
        $id = $id == 'me' ? Auth::id() : $id;

        try {
            $imageUrl = $this->upload_external($request);

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

    public function delete($id) {
        $id = $id == 'me' ? Auth::id() : $id;

        DB::table('users')
            ->where('id', $id)
            ->update(['profile_picture_path' => null]);

        return back()->with('message', 'Delete  profile picture success');
    }
}
