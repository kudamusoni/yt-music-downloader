<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_YouTube;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class FileController extends Controller
{
    private $client;
    public $array;
    private $param;
    public $token;
    public $request;

    public function __construct(Google_Client $client, Request $request)
    {
        $this->request = $request;
        $this->client = $client;
        $this->client->setApplicationName('music-downloader');
        $this->client->setScopes([
            'https://www.googleapis.com/auth/youtube.readonly',
        ]);
        $file = storage_path('app/secret/client_secret_489242533956-irm4lgn5o89ci2n7qbueiq83hpeaei6n.apps.googleusercontent.com.json');
        $this->client->setAuthConfig($file);
        $this->client->setAccessType('offline');
    }

    public function redirect()
    {
        return redirect($this->client->createAuthUrl());
    }

    public function get()
    {
        if ($this->request->input('code')) {
            return $this->formatPlaylistResponse();
        } else {
            return view('welcome');
        }
    }

    public function formatPlaylistResponse()
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($this->request->input('code'));
        session(['code' => $this->request->input('code'), 'token' => $accessToken['access_token']]);
        $this->client->setAccessToken($accessToken);
        $service = new Google_Service_YouTube($this->client);
        $queryParams = [
            'maxResults' => 25,
            'mine' => true
        ];
        $response = $service->playlists->listPlaylists('snippet, contentDetails', $queryParams);
        $this->array = [];
        foreach ($response['items'] as $value) {
            array_push($this->array, [
                'title' => $value['snippet']['localized']['title'], 
                'thumbnail' => $value['snippet']['thumbnails']['medium']['url'],
                'id' => $value['id']
            ]);
        }
        $this->param = 'playlists';
        return $this->returnView();
    }

    public function formatItemsResponse($id)
    {
        $code = session('code');
        $token = session('token');
        $this->client->setAccessToken($token);
        $service = new Google_Service_YouTube($this->client);
        $queryParams = [
            'playlistId' => $id
        ];
        $response = $service->playlistItems->listPlaylistItems('snippet, contentDetails', $queryParams);
        $this->array = array();
        foreach ($response['items'] as $value) {
            array_push($this->array, ['title' => $value['snippet']['title'], 'id' => $value['snippet']['resourceId']['videoId']]);
        }
        $this->param = 'file';
        return $this->returnView();
    }

    public function returnView()
    {
        return view($this->param)->with($this->param, $this->array);
    }
}