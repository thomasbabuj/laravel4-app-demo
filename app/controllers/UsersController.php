<?php

class UsersController extends BaseController {

    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function getNewaccount()
    {
        return View::make('users.newaccount');
    }

    public function postCreate()
    {
        $validator = Validator::make(Input::all(), User::$rules);

        if ( $validator )
        {
            $user = new User;
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->password = Hash::make( Input::get('password') );
            $user->telephone = Input::make('telephone');
            $user->save();

            return Redirect::to('users/signin')
                    ->with('message', 'Thank you for creating a new account. Please sing in');
        }

        return Redirect::to('users/newaccount')
                ->with('message', 'Something went wrong')
                ->withErrors($validator)
                ->withInput();
    }

    public function getSignin()
    {
        return View::make('users.signin');
    }

    public function postSignin()
    {
        if( Auth::attempt(array(
            'email' => Input::get('email'),
            'password' => Input::get('password')
        )))
        {
            return View::make('/')->with('message', 'Thanks for signing in');
        }

        return View::make('users/signin')
                ->with('message', 'Your email/password combo was incorrect');
    }

    public function getSignout()
    {
        Auth::logout();
        return Redirect::to('users/signin')
                ->with('message', 'You have been signed out');
    }
}