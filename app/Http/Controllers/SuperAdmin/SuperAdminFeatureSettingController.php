<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Feature;
use App\Helper\Reply;
use App\Http\Requests\SuperAdmin\FeatureSetting\StoreRequest;
use App\Http\Requests\SuperAdmin\FeatureSetting\UpdateRequest;
use App\Http\Requests\SuperAdmin\FrontSetting\UpdateFrontSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SuperAdminFeatureSettingController extends SuperAdminBaseController
{
    /**
     * SuperAdminInvoiceController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'Front Feature Settings';
        $this->pageIcon = 'icon-settings';
    }

    /**
     * Display edit form of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->type = $request->type;
        $this->features = Feature::where('type', $this->type)->get();

        return view('super-admin.feature-settings.index', $this->data);
    }

    /**
     * Display edit form of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->type = $request->type;
        $this->features = Feature::all();

        return view('super-admin.feature-settings.create', $this->data);
    }

    /**
     * @param UpdateFrontSettings $request
     * @param $id
     * @return array
     */
    public function store(StoreRequest $request)
    {
        $feature = new Feature();
        $type =  $request->type;
        $feature->title = $request->title;
        $feature->type = $request->type;
        $feature->description = $request->description;
        if($request->has('icon')){
            $feature->icon = $request->icon;
        }
        else{
            if ($request->hasFile('image')) {
                $feature->image = $request->image->hashName();
                $request->image->store('front-uploads/feature');
            }
        }

        $feature->save();

        return Reply::redirect(route('super-admin.feature-settings.index').'?type='.$type, 'messages.feature.addedSuccess');

    }

    /**
     * Display edit form of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->feature = Feature::findOrFail($id);
        $this->type = $request->type;
//        $this->type = 'image';

        return view('super-admin.feature-settings.edit', $this->data);
    }

    /**
     * @param UpdateFrontSettings $request
     * @param $id
     * @return array
     */
    public function update(UpdateRequest $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $oldImage = $feature->image;

        $feature->title = $request->title;
        $feature->type = $request->type;
        $feature->description = $request->description;
        if($request->has('icon')){
            $feature->icon = $request->icon;
        }
        else{
            if ($request->hasFile('image')) {
                $feature->image = $request->image->hashName();
                $request->image->store('front-uploads/feature');
                if($oldImage){ File::delete('front-uploads/feature/'.$oldImage); }
            }
        }

        $type =  $request->type;
        $feature->save();

        return Reply::redirect(route('super-admin.feature-settings.index').'?type='.$type, 'messages.feature.addedSuccess');

    }


    /**
     * @param UpdateFrontSettings $request
     * @param $id
     * @return array
     */
    public function destroy(Request $request, $id)
    {
        $type =  $request->type;
        Feature::destroy($id);
        return Reply::redirect(route('super-admin.feature-settings.index').'?type='.$type, 'messages.feature.deletedSuccess');

    }
}
