<?php

namespace App\Http\Controllers;

use App\Model\Dish;
use App\Model\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class HomeController extends Controller
{

    /**
     * Show the dashboard /home
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the root or base view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function welcome()
    {
        if(config('restaurant.hasInstall') == 1){
            return view('welcome');
        }else{
            return redirect()->to('/install');
        }
    }


    /**
     * Change user password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        if(Hash::check($request->get('current_password'),auth()->user()->password)){
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->get('new_password'));
            if ($user->save()) {
                return response()->json('Ok',200);
            }
        }else{
            return response()->json('Ok',500);
        }
    }

    /**
     * View user profile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileInfo()
    {
        return view('user.profile.profile');
    }

    /**
     * View user information edit page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileEdit()
    {
        return view('user.profile.edit-profile');
    }

    /**
     * Update user profile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        if ($request->hasFile('thumbnail')) {
            $user->image = $request->file('thumbnail')
                ->move('uploads/employee', rand(100000, 900000) . '.' . $request->thumbnail->extension());
        }
        if($user->save()){
            $employee = Employee::where('user_id',$user->id)->first();
            $employee->name = $user->name;
            $employee->phone = $request->get('phone');
            $employee->email = $user->email;
            $employee->address = $request->get('address');
            if($employee->save()){
                return response()->json('Ok',200);
            }

        }
    }

    /**
     * Update admin profile info
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminProfileUpdate(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        if ($request->hasFile('thumbnail')) {
            $user->image = $request->file('thumbnail')
                ->move('uploads/employee', rand(100000, 900000) . '.' . $request->thumbnail->extension());
        }
        if($user->save()){
            return response()->json('Ok',200);
        }
    }


    /**
     * View account disable page if user account is disable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accountDisable()
    {
        return view('other.disable-account');
    }

    /**
     * Install this application
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function install()
    {
        if(config('restaurant.hasInstall') == 0){
            return view('install');
        }else{
            return redirect()->to('/install-success');
        }
    }

    /**
     * Show install success when install is success
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function installSuccess()
    {
        if(config('restaurant.hasInstall') == 1){
            return view('install-success');
        }else{
            return redirect()->to('/install');
        }
    }


}
