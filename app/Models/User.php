<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LakM\Comments\Concerns\Commenter;
use LakM\Comments\Contracts\CommenterContract;

class User extends Authenticatable implements FilamentUser, CommenterContract
{
    use HasFactory, Notifiable, Commenter;

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->is_admin, true);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function subscribe_transactions()
    {
        return $this->hasMany(SubscribeTransaction::class);
    }

    public function hasActiveSubscription()
    {
        $latestSubscription = $this->subscribe_transactions()
            ->where('status', 'Success')
            ->latest('updated_at')
            ->first();

        if (!$latestSubscription) {
            return false;
        }

        $subscriptionEndDate = Carbon::parse($latestSubscription->subscription_start_date)->addYear(1);
        return Carbon::now()->lessThanOrEqualTo($subscriptionEndDate);
    }

    public static function getActiveSubscribersCount()
    {
        $activeSubscribers = User::whereHas('subscribe_transactions', function ($query) {
            $query->where('status', 'Success')
                ->where('subscription_start_date', '<=', now()) // Ensure subscription started before now
                ->where('subscription_start_date', '>=', now()->subYear(1)); // Check if subscription is within the last year
        })->count();

        return $activeSubscribers;
    }

    public function userTodoProgresses()
    {
        return $this->hasMany(UserTodoProgress::class);
    }

    public function userProgresses()
    {
        return $this->hasMany(UserProgress::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $todoItems = TodoChecklistItem::all();
            $subModules = SubModule::all();

            foreach ($todoItems as $item) {
                UserTodoProgress::create([
                    'user_id' => $user->id,
                    'todo_checklist_item_id' => $item->id,
                    'is_checked' => false,
                ]);
            }
            foreach ($subModules as $subModule) {
                UserProgress::create([
                    'user_id' => $user->id,
                    'sub_module_id' => $subModule->id,
                    'is_completed' => false,
                ]);
            }
        });
    }

    // Relasi ke komisi referral
    public function referralCommissions()
    {
        return $this->hasMany(ReferralCommission::class, 'referrer_id');
    }

    // Relasi ke user yang direferensikan
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by', 'referral_code');
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by', 'referral_code');
    }
}
