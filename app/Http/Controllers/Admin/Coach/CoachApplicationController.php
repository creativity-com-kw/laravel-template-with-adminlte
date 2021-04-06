<?php

namespace App\Http\Controllers\Admin\Coach;

use App\CoachApplication;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use View;

class CoachApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CoachApplication::whereStatus($request->status);
            $items = $query->get();

            $data = [];
            foreach ($items as $key => $item) {
                $nestedData['id'] = $key + 1;
                $nestedData['avatar_url'] = $item->avatar_url ? "<img src='{$item->avatar_url}' class='img-circle' width='40px' height='40px' alt=''>" : null;
                $nestedData['name'] = $item->full_name;
                $nestedData['email'] = $item->email;
                $nestedData['mobile'] = $item->mobile;
                $nestedData['date'] = $item->created_at->format('dS M Y');
                $nestedData['options'] = (string)View::make('admin.coach-application.options-template', ['application' => $item])->render();;

                $data[$key] = $nestedData;
            }

            $json_data = [
                'draw' => $request->query('draw'),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => $data
            ];

            return response()->json($json_data);
        } else {
            return View('admin.coach-application.index');
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoachApplication  $coachApplication
     * @return \Illuminate\Http\Response
     */
    public function show(CoachApplication $coachApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoachApplication  $coachApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(CoachApplication $coachApplication)
    {
        return View('admin.coach-application.edit', compact('coachApplication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoachApplication  $coachApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoachApplication $coachApplication)
    {
        $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'first_name' => ['required', 'string'],
            'middle_name' => ['nullable', 'string'],
            'last_name' => ['required', 'string'],
            'civil_id_number' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($coachApplication) {
                    if($coachApplication->email != $value){
                        $exists = User::whereType(2)->whereEmail($value)->exists();

                        if ($exists) {
                            $fail('Email is already exist');
                        }
                    }
                }
            ],
            'mobile' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($coachApplication) {
                    if($coachApplication->mobile != $value){
                        $exists = User::whereType(2)->whereMobile($value)->exists();

                        if ($exists) {
                            $fail('Mobile is already exist');
                        }
                    }
                }
            ],
            'gender' => ['required', 'integer'],
            'password' => ['nullable', 'size:8'],
            'confirm_password' => ['nullable', 'same:password'],
            'status' => ['required', 'integer']
        ]);

        // update
        if ($request->hasFile('avatar')) {
            Storage::delete($coachApplication->avatar);
            $coachApplication->avatar = $request->file('avatar')->store('avatars');
            Image::make('storage/' . $coachApplication->avatar)->resize(1000, 1000)->save('storage/' . $coachApplication->avatar);
        }
        if (!empty($request->password)) {
            $coachApplication->password = Hash::make($request->password);
        }
        $coachApplication->first_name = $request->first_name;
        $coachApplication->middle_name = $request->middle_name;
        $coachApplication->last_name = $request->last_name;
        $coachApplication->civil_id_number = $request->civil_id_number;
        $coachApplication->email = $request->email;
        $coachApplication->mobile = $request->mobile;
        $coachApplication->gender = $request->gender;
        $coachApplication->status = $request->status;
        $coachApplication->save();

        if($request->type == 1){
            return redirect()->route('admin.coachApplications.pending')->with('status', 'Coach application updated successfully!');
        }else {
            return redirect()->route('admin.coachApplications.rejected')->with('status', 'Coach application updated successfully!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoachApplication  $coachApplication
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, CoachApplication $coachApplication)
    {
        $coachApplication->status = $request->status;
        $coachApplication->save();

        // if accept
        if ($coachApplication->status == 2) {
            $user = new User();
            $user->type = 2;
            $user->coach_type = 3;
            $user->coach_application_id = $coachApplication->id;
            $user->avatar = $coachApplication->avatar;
            $user->civil_id_number = $coachApplication->civil_id_number;
            $user->first_name = $coachApplication->first_name;
            $user->middle_name = $coachApplication->middle_name;
            $user->last_name = $coachApplication->last_name;
            $user->email = $coachApplication->email;
            $user->mobile = $coachApplication->mobile;
            $user->password = $coachApplication->password;
            $user->gender = $coachApplication->gender;
            $user->status = 1;
            $user->save();
        }

        return back()->with('status', 'Status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoachApplication  $coachApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoachApplication $coachApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Package $package
     * @return \Illuminate\Http\Response
     */
    public function destroyAvatar(CoachApplication $coachApplication)
    {
        Storage::delete($coachApplication->avatar);

        $coachApplication->avatar = null;
        $coachApplication->save();

        return back()->with('status', 'Avatar removed successfully!');
    }
}
