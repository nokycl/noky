<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\StorageSetting;
use Illuminate\Http\Request;

class StorageSettingsController extends AdminBaseController
{

    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.storageSettings';
        $this->pageIcon = 'icon-settings';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->dropboxCredentials = StorageSetting::where('filesystem', 'dropbox')->first();
        $this->awsCredentials = StorageSetting::where('filesystem', 'aws')->first();
        $this->googleCredentials = StorageSetting::where('filesystem', 'google')->first();
        $this->localCredentials = StorageSetting::where('filesystem', 'local')->first();

        if(!is_null($this->awsCredentials)){
            $authKeys = json_decode($this->awsCredentials->auth_keys);
            $this->awsCredentials->driver = $authKeys->driver;
            $this->awsCredentials->key = $authKeys->key;
            $this->awsCredentials->secret = $authKeys->secret;
            $this->awsCredentials->region = $authKeys->region;
            $this->awsCredentials->bucket = $authKeys->bucket;
        }

        if(!is_null($this->googleCredentials)){
            $authKeys = json_decode($this->googleCredentials->auth_keys);
            $this->googleCredentials->driver = $authKeys->driver;
            $this->googleCredentials->clientId = $authKeys->clientId;
            $this->googleCredentials->clientSecret = $authKeys->clientSecret;
            $this->googleCredentials->refreshToken = $authKeys->refreshToken;
        }

        return view('admin.storage-settings.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storageData = StorageSetting::all();
        if(count($storageData) > 0) {
            foreach ($storageData as $data) {
                $data->status = 'disabled';
                $data->save();
            }
        }

        $storage = StorageSetting::firstorNew(['filesystem' => $request->storage]);

        switch ($request->storage) {
            case 'local':
                $storage->filesystem = $request->storage;
                $storage->status = 'enabled';
                break;
            case 'aws':
                $storage->filesystem = $request->storage;
                $json = '{"driver": "s3", "key": "'.$request->aws_key.'", "secret": "'.$request->aws_secret.'", "region": "'.$request->aws_region.'", "bucket": "'.$request->aws_bucket.'"}';
                $storage->auth_keys = $json;
                $storage->status = 'enabled';
                break;
            case 'google':
                $storage->filesystem = $request->storage;
                $json = '{"driver": "'.$request->storage.'", "clientId": "'.$request->google_client_id.'", "clientSecret": "'.$request->google_client_secret.'", "refreshToken": "'.$request->google_refresh_token.'"}';
                $storage->auth_keys = $json;
                $storage->status = 'enabled';
                break;
            case 'dropbox':
                $storage->filesystem = $request->storage;
                $storage->auth_keys = $request->dropbox_token;
                $storage->status = 'enabled';
                break;
        }
        $storage->save();

        return Reply::success(__('messages.settingsUpdated'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
