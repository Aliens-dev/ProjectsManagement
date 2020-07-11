<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function projects() {
        return $this->hasMany(Project::class, 'owner_id')->latest('updated_at');
    }

    public function invitedProjects(){
        return $this->belongsToMany(Project::class , 'project_members');
    }

    public function accessibleProjects()
    {
        return $this->projects->merge($this->invitedProjects);

        // Or
//        $projects = Project::all();
//        $projectArray = auth()->user()->projects;
//        foreach ($projects as $project) {
//            if($project->members->contains(auth()->user())) {
//                $projectArray->push($project);
//            }
//        }
//        return $projectArray;
    }
}
