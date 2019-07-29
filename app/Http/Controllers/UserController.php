<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
       // $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(25);
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ]);


        return redirect()->route('users.index')
            ->with('flash_success', 'Пользователь успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
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
        try {
            $user = User::findOrFail($id);
            $this->validate($request, [
                'name' => 'required|max:120',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:6|confirmed'
            ]);


            $user->name = $request->input('name');
            $user->email = $request->input('email');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input("password"));
            }

            $user->save();

            if (isset($roles)) {
                $user->roles()->sync($roles);
            } else {
                $user->roles()->detach();
            }

        } catch (\Exception $ex) {
            return redirect()->back()->with('flash_error', $ex->getMessage());
        }

        return redirect()->route('users.index')
            ->with('flash_success', 'Пользователь успешно сохранен.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Exception $ex) {
            return redirect()->back()->with('flash_error', $ex->getMessage());
        }

        return redirect()->route('users.index')
            ->with('flash_success', 'Пользователь успешно удален');
    }
}
