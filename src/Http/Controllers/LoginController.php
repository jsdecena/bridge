<?php

namespace Jsdecena\Bridge\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jsdecena\Bridge\Repository\UserRepository;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @var UserRepository
     */
    private $user;

    /**
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * LoginController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('guest', ['except' => 'logout']);

        $this->user = $user;
    }

    /**
     * @return View
     */
    public function index() : View
    {
        return view('bridge::login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        $this->protectLogin($credentials);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin');
        }
    }

    /**
     * @return string
     */
    public function username() : string
    {
        return 'username';
    }

    /**
     * @return RedirectResponse
     */
    public function logout() : RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * @param $data
     * @return RedirectResponse
     * @throws Exception
     */
    private function protectLogin($data)
    {
        if (!$this->user->fetchOne('username', $data['username'])) {

            $user = $this->user->call('auth/', ['uname' => $data['username'], 'password' => $data['password']]);

            try {

                //Todo: Create mapping method for the legacy property to the new User property
                $this->user->create([
                    'name'     => $user->pn_name,
                    'username' => $user->pn_uname,
                    'email'    => $user->pn_email,
                    'password' => Hash::make($data['password'])
                ]);

                //Login the newly created user
                $newUser = $this->user->fetchOne('username', $data['username']);
                Auth::login($newUser);

                return redirect()->intended('admin');
            } catch (Exception $e) {
                throw new Exception('Username / Password combination incorrect');
            }
        }
    }
}