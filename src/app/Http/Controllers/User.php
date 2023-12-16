<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserProfileUpdate;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\User\UserStore;
use App\Http\Requests\User\UserUpdate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = ModelsUser::where('id', '!=', auth()->user()->id)->orderBy('id', 'DESC')->select([
            '*',
            // DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y %H:%i') AS created_at")
        ])->get();

        // dd($users);
        return view('pages.dashboard.users.read', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
        $payload = $request->safe()->only(['name', 'email', 'password']);
        $payload['password'] = Hash::make($payload['password']);

        $user = ModelsUser::create($payload);

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = ModelsUser::findOrFail($id);

        return view('pages.dashboard.users.update', compact('user'));
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
    public function update(UserUpdate $request, int $id)
    {
        $payload = $request->safe()->only(['name', 'email', 'password']);
        $payload['password'] = Hash::make($payload['password']);

        $update = ModelsUser::where('id', $id)->update($payload);

        if ($update) {
            return redirect()->back()->with('updated', true);
        }

        return redirect()->back()->withInput()->with('updated', false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $user_id)
    {
        $user = ModelsUser::where('id', $user_id)->first();

        $delete = $user->delete();

        if (!$delete) {
            return redirect()->back()->with('delete_error', true);
        }

        return redirect()->back();
    }

    /**
     * Displays the authenticated user's profile data
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showAuthUserProfile()
    {
        $user = ModelsUser::where('id', '=', auth()->user()->id)->first();

        return view('pages.dashboard.users.profile', compact('user'));
    }

    public function updateAuthUserProfile(UserProfileUpdate $request)
    {
        $payload = $request->safe()->only(['name', 'email', 'password']);

        $inputs = array_filter($payload, fn($input) => !is_null($input));

        if (sizeof($inputs)) {

            if (array_key_exists('password', $inputs)) {
                $inputs['password'] = Hash::make($inputs['password']);
            }

            $update = ModelsUser::where('id', '=', auth()->user()->id)->update($inputs);
            return redirect()->back()->with('updated', true);
        }

        // nothing to update
        return redirect()->back();
    }
}
