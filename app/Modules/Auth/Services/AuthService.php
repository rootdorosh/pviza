<?php

namespace App\Modules\Auth\Services;

use Illuminate\Support\Str;
use App\Modules\Auth\Http\Requests\RemindPasswordEmail;
use App\Modules\Auth\Models\PasswordReset;
use App\Modules\Event\Services\EventService;
use App\Modules\User\Models\User;

/**
 * @package App\Modules\Auth
 */
class AuthService
{
    /*
     * @var EventService
     */
    private $eventService;
    
    /*
     * @param EventService $authService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /*
     * @param RemindPasswordEmail $request
     * 
     * @return int
     */
    public function remindPasswordSendCode(RemindPasswordEmail $request): int
    {
        $code = rand(10000, 999999);
        
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => $code]
        );
        
        $this->eventService->addToQueue('auth.remind_password', [
            'email' => $request->email,
            'code' => $code,
        ]);
        
        return $code;
    }

    /*
     * @param int $token
     * @param string $password
     * @return void
     */
    public function setPassword(int $token, string $password): void
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        $user = User::where('email', $passwordReset->email)->first();
        $user->password = $password;
        $user->save();
        
        //remove code
        $passwordReset->delete();
    }

    /*
     * @param User $user
     * @return string
     */
    public function login(User $user): string
    {
        $token = (string) Str::random(60);

        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save(); 
        
        return $token;
    }
    
    /*
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->api_token = null;
        $user->save();
    }
    
    /*
     * @param string $email
     * @return string|null
     */
    public function getApiToken(string $email): ?string
    {
        return User::where('email', $email)->first()->api_token;
    }
    
    /*
     * @param string $email
     * @return string|null
     */
    public function getPasswordResetCode(string $email): ?string
    {
        return PasswordReset::where('email', $email)->first()->token;
    }

}
