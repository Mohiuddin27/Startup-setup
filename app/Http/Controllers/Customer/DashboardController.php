<?php

namespace App\Http\Controllers\Customer;

use App\Models\Type;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\District;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('frontend.user.dashboard');
    }
    public function postYourAd(){
        $types=Type::where('status',1)->get();
        $categories=Category::where('status',1)->get();
        $districts=District::get();
        if(Auth::user() && Auth::user()->role=='customer'){
            return view('frontend.user.post-you-ad',compact('types','categories','districts'));
        }
        else{

            return redirect()->route('customer.login');
        }
    }

    public function postYourAdSubmit(Request $request){
        // dd($request->all());
        try {
            $this->validate($request, [
                'title' => 'required|unique:products',
                'description'=>'required',
                'districts'=>'required',
                'type_id'=>'required',
                'category_id'=>'required',
                'thumbnail'=>'required',


            ]);

            $data = new Product();
            $data->added_by = Auth::user()->id;
            $data->title = $request->title;
            $data->slug = Str::slug($request->title);
            $data->user_id = Auth::user()->id;
            $data->type_id = $request->type_id;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->whatsapp = $request->whatsapp;
            $data->website = $request->website;
            $data->category_id = $request->category_id;
            $data->price = $request->price;
            $data->seller_name = $request->seller_name;
            $data->featured = $request->featured;
            $data->qty = $request->qty;
            $data->sort_description = $request->sort_description;
            $data->description = $request->description;
            $data->address = $request->address;
            $data->status = 0;
            $image = $request->file('thumbnail');
            if ($image) {
                $image_name = Str::slug($request->name) . '_' . str::random(5);
                $ext = strtolower($image->getClientOriginalExtension());
                $image_full_name = uniqid() . '-' . $image_name . '.' . $ext;
                $upload_path = 'product/';
                $image_url = $upload_path . $image_full_name;
                $success = $image->move($upload_path, $image_full_name);
                if ($success)
                    $data->thumbnail = $image_url;
            }
            $multipleImages = [];
            $images = $request->file('multiple_img');
            if ($images) {
                foreach ($images as $image) {
                    $image_name = Str::slug($request->name) . '_' . Str::random(5);
                    $ext = strtolower($image->getClientOriginalExtension());
                    $image_full_name = uniqid() . '-' . $image_name . '.' . $ext;
                    $upload_path = 'product/images/';
                    $image_url = $upload_path . $image_full_name;
                    $success = $image->move($upload_path, $image_full_name);
                    if ($success) {
                        $multipleImages[] = $image_url;
                    }
                }
            }


            // Convert the array of multiple images to JSON format
            $data->multiple_img = json_encode($multipleImages);
            $data->meta_title = $request->meta_title;
            $data->meta_description = $request->meta_description;
            $data->meta_keyword = $request->meta_keyword;
            $data->save();
            $selectedDistrictIds = $request->input('districts', []);

            // Save the relationships to the pivot table
            $data->districts()->sync($selectedDistrictIds);
            Toastr::success('Product has been Saved successfully :-)', 'Success');

            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::warning($e->getMessage(), 'Failed');

            return redirect()->back();
        }
    }
    public function affiliate(){
        $user = User::find(Auth::user()->id);
        $roleId = 3;
        $hasRole = $user->roles()->where('role_id', $roleId)->exists();
        if($hasRole) {
            $role =  $user->roles()->where('role_id', $roleId)->first();
            $user->role = $role->role;
            $user->save();
        }
        return redirect()->back();
    }

    public function seller(){
        $user = User::find(Auth::user()->id);
        $roleId = 4;
        $hasRole = $user->roles()->where('role_id', $roleId)->exists();
        if($hasRole) {
            $role =  $user->roles()->where('role_id', $roleId)->first();
            $user->role = $role->role;
            $user->save();
        }
        return redirect()->back();
    }

    public function allPost(){
        $posts=Product::where('added_by',Auth::user()->id)->get();

        return view('frontend.user.all-post',compact('posts'));
    }
    public function pendingPost(){
        $posts=Product::where('added_by',Auth::user()->id)->where('status',0)->get();

        return view('frontend.user.pending-post',compact('posts'));
    }
    public function approvedPost(){
        $posts=Product::where('added_by',Auth::user()->id)->where('status',1)->get();

        return view('frontend.user.approved-post',compact('posts'));
    }
    public function editProfile(){
        return view('frontend.user.edit-profile');
    }
    public function updatePassword(Request $request)
    {
        $user = Auth::user(); // Assuming you are using Laravel's built-in authentication

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|min:6'

        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            Toastr::success('Password updated successfully :-)', 'Success');

            return redirect()->back();
        } else {
            Toastr::error('Current password is incorrect :-)', 'Error');

            return redirect()->back();
        }
    }


    public function updateProfile(Request $request)
    {

        $user = Auth::user();



        $image = $request->file('image');
        if ($image) {
            $image_name = Str::slug($request->name) . '_' . str::random(5);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = uniqid() . '-' . $image_name . '.' . $ext;
            $upload_path = 'user/';
            $image_url = $upload_path . $image_full_name;
            $success = $image->move($upload_path, $image_full_name);
            if ($success)
                $user->image = $image_url;
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->website = $request->input('website');
        $user->whatsapp_number = $request->input('whatsapp_number');
        $user->address = $request->input('address');
        $user->facebook = $request->input('facebook');
        $user->linkedin = $request->input('linkedin');
        $user->twitter = $request->input('twitter');
        $user->youtube = $request->input('youtube');

        $user->save();
        Toastr::success('Profile Updated Successfully :-)', 'success');

        return redirect()->back();
    }
    public function order(){
        return view('frontend.user.order');
    }
}
