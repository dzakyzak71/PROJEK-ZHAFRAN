<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\IpLog;
use App\Models\User;


class User extends Authenticatable
{

    use HasFactory, Notifiable;
    use HasRoles;

    public function index(Request $request)
    {
        $userId = $request->user_id;
        $users = User::all();

        $ipLogs = IpLog::with('user')
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->get();

        return view('superadmin.pages.components.tracking-ip', compact('ipLogs', 'users'));
    }

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
            

}
