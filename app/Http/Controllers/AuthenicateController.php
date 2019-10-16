<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Project;

class AuthenicateController extends Controller
{

    protected $server;
    protected $tokens;
    protected $jwt;

    public function __construct(
        AuthorizationServer $server,
        TokenRepository $tokens,
        JwtParser $jwt
    ) {
        $this->jwt = $jwt;
        $this->server = $server;
        $this->tokens = $tokens;
    }

    public function new(UserRequest $request)
    {

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return new UserResource($user);
    }


    public function register(UserRequest $request)
    {

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        $project = new Project;

        $project->user_id = $user->id;
        $project->name = "Inbox";
        $project->comments = "This is your starter project, to organize your task. Click on the New Project tab to make your own!";
        $project->color = "#efefef";
        $project->save();


        return new UserResource($user);
    }

    public function login(ServerRequestInterface $request)
    {

        $controller = new AccessTokenController($this->server, $this->tokens, $this->jwt);

        $request = $request->withParsedBody($request->getParsedBody() +
            [
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
            ]);

        try {
            return with(new AccessTokenController($this->server, $this->tokens, $this->jwt))
                ->issueToken($request);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server, please try again later.', $e->getCode());
        }
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response('Logged out', 200);
    }
}
