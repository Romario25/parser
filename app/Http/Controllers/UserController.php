<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function listUsers()
    {
        $this->authorize('user');
        

        $users = User::paginate(15);

        return view('user.list', [
            'users' => $users
        ]);
    }

    public function addForm()
    {
        $this->authorize('user');
        return view('user.form');
    }

    public function add(Request $request)
    {
        $this->authorize('user');
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('/user/add')->withErrors($validator)->withInput();
        }

        // save user
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),

        ]);


        $user->role = $data['role'];
        $user->save();

        return redirect('/user')->with('status', 'Юзер успешно добавлен');
    }

    public function update(Request $request, $id)
    {
        $this->authorize('user');
        $user = User::findOrFail($id);

        if ($request->isMethod('delete')) {
            $user->delete();
            return redirect('user')->with('status', 'Юзер удален');
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,
                'username' => 'required|max:255|unique:users,username,'.$user->id,
            ]);

            if ($validator->fails()) {
                return redirect()->route('edit-user', ['id' => $user->id])->withErrors($validator)->withInput();
            }

            // update
            $user->fill($data);
            //
            if ($user->update()) {
                $user->role = $data['role'];
                $user->save();
                return redirect('user')->with('status', 'Страница обновлена');
            }

        }

        return view('user.edit-form', [
            'user' => $user
        ]);
    }
}
