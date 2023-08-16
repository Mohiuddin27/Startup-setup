<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SiteSetting::first();
        return view('admin.site-setting.edit',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'title' => 'required',
                'logo' => 'required',
                'favicon' => 'required',
                'domain' => 'required',
            ]);

            $data = new SiteSetting();
            $data->title= $request->title;
            $image = $request->file('logo');
            if($image)
            {
                $image_name= Str::slug($request->title).'_'.str::random(5);
                $ext = strtolower($image->getClientOriginalExtension());
                $image_full_name = uniqid().'-'.$image_name. '.' .$ext;
                $upload_path = 'images/setting/';
                $image_url = $upload_path.$image_full_name;
                $success = $image->move($upload_path, $image_full_name);
                if($success) {
                    $data->logo = $image_url;
                }
            }
            $favicon = $request->file('favicon');
            if($favicon)
            {
                $image_name= Str::slug($request->title).'_'.str::random(5);
                $ext = strtolower($favicon->getClientOriginalExtension());
                $image_full_name = uniqid().'-'.$image_name. '.' .$ext;
                $upload_path = 'images/setting/';
                $image_url = $upload_path.$image_full_name;
                $success = $favicon->move($upload_path, $image_full_name);
                if($success) {
                    $data->favicon = $image_url;
                }
            }
            $data->address= $request->address;
            $data->phone= $request->phone;
            $data->email= $request->email;
            $data->domain= $request->domain;
            $data->user_id= Auth::user()->id;
            $data->save();
            Toastr::success('Site Setting has been Updated successfully :-)','Success');
            return redirect()->back();
        }catch (\Exception $e) {
            Toastr::warning($e->getMessage(),'Failed');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validatedData = $request->validate([
                'title' => 'required',
                'domain' => 'required',
                'email' => 'email',
            ]);

            $data = SiteSetting::find($id);
            $data->title= $request->title;
            $image = $request->file('logo');
            if($image)
            {
                $image_name= Str::slug($request->title).'_'.str::random(5);
                $ext = strtolower($image->getClientOriginalExtension());
                $image_full_name = uniqid().'-'.$image_name. '.' .$ext;
                $upload_path = 'images/setting/';
                $image_url = $upload_path.$image_full_name;
                $success = $image->move($upload_path, $image_full_name);
                if($success) {
                    $data->logo = $image_url;
                }
            }
            $favicon = $request->file('favicon');
            if($favicon)
            {
                $image_name= Str::slug($request->title).'_'.str::random(5);
                $ext = strtolower($favicon->getClientOriginalExtension());
                $image_full_name = uniqid().'-'.$image_name. '.' .$ext;
                $upload_path = 'images/setting/';
                $image_url = $upload_path.$image_full_name;
                $success = $favicon->move($upload_path, $image_full_name);
                if($success) {
                    $data->favicon = $image_url;
                }
            }
            $data->address= $request->address;
            $data->phone= $request->phone;
            $data->email= $request->email;
            $data->domain= $request->domain;
            $data->user_id= Auth::user()->id;
            $data->save();
            Toastr::success('Site Setting has been Updated successfully :-)','Success');
            return redirect()->back();
        }catch (\Exception $e) {
            Toastr::warning($e->getMessage(),'Failed');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
