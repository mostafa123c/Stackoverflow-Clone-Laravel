<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail , HasLocalePreference
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'type'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notification_options' => 'json',
    ];

    protected $appends = [
        'photo_url',  //getPhotoUrlAttribute
    ];

    public function questions()
    {
        return $this->hasMany(Question::class , 'user_id' , 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class , 'user_id' , 'id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class , 'user_id' , 'id')
            ->withDefault();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class , 'role_user');
    }

    //if I don't have field email in users table(another name) , and I want to use email field to send notification
    public function routeNotificationForMail()
    {
        return $this->email; //name of field in users table
    }

    public function routeNotificationForVonage()
    {
        return $this->mobile; //name of field in users table
    }

//    //Notification Language
    public function preferredLocale(): string
    {
        return $this->language ?? 'en';
    }

    //$user->photo_url
    public function getPhotoUrlAttribute()
    {
        if($this->profile_photo_path){
            return asset('storage/'.$this->profile_photo_path);
        }

        return 'https://ui-avatars.com/api/?name='.$this->name;

    }

    public function hasAbility($ability){
        foreach ($this->roles as $role) {
            if (in_array($ability , $role->abilities)) {
                return true;
            }
        }
        return false;
    }
}
