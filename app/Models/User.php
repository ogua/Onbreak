<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Auth\Authenticatable as Authenticatables ;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\hasRole;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract
{
    use HasApiTokens,HasFactory, HasRoles, Notifiable, Authenticatables, DefaultDatetimeFormat;


    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


    public $guard_name = 'admin';

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
    ];

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    // protected function username()
    // {
    //     return 'username';
    // }


    public function studentinfo()
    {
        return $this->hasOne(Studentinfo::class,'user_id');
    }


    public function studentclass()
    {
        return $this->belongsToMany(Studentclass::class,'studentclass_users','user_id','studentclass_id');
    }

    public function stsubject()
    {
        return $this->belongsToMany(Subject::class,'stsubject_users','user_id','subject_id');
    }


    public function staff()
    {
        return $this->hasOne(Staff::class,'user_id');
    }


    public function staffs()
    {
        return $this->hasMany(Staff::class,'uniqueid','uniqueid');
    }

    public function schools()
    {
        return $this->hasOne(School::class,'uniqueid','uniqueid');
    }

    public function school()
    {
        return $this->hasOne(School::class,'uniqueid','uniqueid');
    }

    // public function plan()
    // {
    //     return $this->belongsto(Plan::class,'plan_id');
    // }

    public function apikey()
    {
        return $this->hasOne(Apikeys::class,'uniqueid','uniqueid');
    }

    public function notifyuser()
    {
        return $this->hasOne(Notifyalert::class,'uniqueid','uniqueid');
    }

     /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.users_table'));

        parent::__construct($attributes);
    }

    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if (url()->isValidUrl($avatar)) {
            return $avatar;
        }

        $disk = config('admin.upload.disk');

        if ($avatar && array_key_exists($disk, config('filesystems.disks'))) {
            return Storage::disk(config('admin.upload.disk'))->url($avatar);
        }

        $default = config('admin.default_avatar') ?: '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg';

        return admin_asset($default);
    }


    /**
     * If User can see menu item.
     *
     * @param Menu $menu
     *
     * @return bool
     */
    public function canSeeMenu($menu)
    {
        return true;
    }


    /**
     * If user can access route.
     *
     * @param Route $route
     *
     * @return bool
     */
    public function canAccessRoute(Route $route)
    {
        
        //dd($route);

        return true;
    }


    public function academicterm()
    {
        return $this->hasOne(Academicyear::class,'uniqueid','uniqueid')
        ->where('status',1);
    }

    public function academicterms()
    {
        return $this->hasMany(Academicyear::class,'uniqueid','uniqueid')
        ->where('status',1);
    }

    public function owings()
    {
        return $this->hasMany(Pupilschoolfee::class,'uniqueid','uniqueid')
        ->where('status','No')
        ->sum('owed');
    }


    public function theme()
    {
        return $this->hasOne(Osmstheme::class,'uniqueid','uniqueid');
    }

    public function mailsettings()
    {
        return $this->hasOne(Mailsetting::class,'uniqueid','uniqueid');
    }



}
