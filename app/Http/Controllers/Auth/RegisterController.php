<?php

namespace App\Http\Controllers\Auth;

use App\ConfirmUsers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => User::CUSTOMER
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        // Присваиваем роль
        if($user){
            $user->role = User::CUSTOMER;
            $user->save();

            $model=new ConfirmUsers; //создаем экземпляр нашей модели
            $model->email = $user->email; //вставляем в таблицу email
            $model->token = str_random(32); //вставляем в таблицу токен
            $model->save();      // сохраняем все данные в таблицу

            //отправляем ссылку с токеном пользователю
            Mail::send('emails.confirm',['token' => $model->token],function($u) use ($user)
            {
                $u->from('admin@site.ru');
                $u->to($user->email);
                $u->subject('Confirm registration');
            });
        }

        
        // send email
        

        return redirect('home');
    }

    public function confirm($token)
    {
        $model = ConfirmUsers::where('token','=',$token)->firstOrFail(); 
        $user = User::where('email','=',$model->email)->first(); 
        $user->status=1; 
        $user->save();  
        $model->delete(); 
        
        return view('auth.confirm');
    }
}
