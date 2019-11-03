<?php

namespace App\Http\Controllers\Member;

use App\EmployeeDetails;
use App\Helper\Reply;
use App\Http\Requests\User\UpdateProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class MemberProfileController extends MemberBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.profileSettings';
        $this->pageIcon = 'icon-user';
    }

    public function index() {
        $this->userDetail = auth()->user();
        $this->employeeDetail = EmployeeDetails::where('user_id', '=', $this->userDetail->id)->first();
        return view('member.profile.edit', $this->data);
    }

    public function update(UpdateProfile $request, $id) {
        config(['filesystems.default' => 'local']);

        $user = User::withoutGlobalScope('active')->findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        if($request->password != ''){
            $user->password = Hash::make($request->input('password'));
        }
        $user->mobile = $request->input('mobile');

        if ($request->hasFile('image')) {
            File::delete('user-uploads/avatar/'.$user->image);

            $user->image = $request->image->hashName();
            $request->image->store('user-uploads/avatar');

            // resize the image to a width of 300 and constrain aspect ratio (auto height)
            $img = Image::make('user-uploads/avatar/'.$user->image);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }

        $user->save();

        $validate = Validator::make(['address' => $request->address], [
            'address' => 'required'
        ]);

        if($validate->fails()){
            return Reply::formErrors($validate);
        }

        $employee = EmployeeDetails::where('user_id', '=', $user->id)->first();
        if(empty($employee)){
            $employee = new EmployeeDetails();
            $employee->user_id = $user->id;
        }
        $employee->address = $request->address;
        $employee->save();

        $this->logUserActivity($user->id, __('messages.updatedProfile'));
        return Reply::redirect(route('member.profile.index'), __('messages.profileUpdated'));
    }

    public function updateOneSignalId(Request $request){
        $user = User::find($this->user->id);
        $user->onesignal_player_id = $request->userId;
        $user->save();
    }
}
