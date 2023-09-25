<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    // public function upload(Request $request)
    // {
    //     $apiKey = env('IMGBB_API_KEY');
    //     $client = new Client();

    //     $response = $client->post('https://api.imgbb.com/1/upload', [
    //         'headers' => [
    //             'Authorization' => 'Bearer ' . $apiKey,
    //         ],
    //         'multipart' => [
    //             [
    //                 'name' => 'image',
    //                 'contents' => fopen($request->file('image')->path(), 'r'),
    //             ],
    //         ],
    //     ]);

    //     $responseData = json_decode($response->getBody());

    //     return response()->json($responseData);
    // }

    public function upload(Request $request)
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

    public function changeProfilePicture($id, Request $request)
    {
        $id = $id == 'me' ? Auth::id() : $id;

        try {
            $imageUrl = $this->upload($request);

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
