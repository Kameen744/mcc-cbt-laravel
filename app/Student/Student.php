<?php

namespace App\Student;

use App\Cbt\ExamScore;
use App\Cbt\ExamAtempt;
use App\Cbt\Recommendation;
use App\Student\StuExamTime;
use Yadakhov\InsertOnDuplicateKey;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Student extends Authenticatable
{
    use Notifiable;
    use LaravelVueDatatableTrait;
    use InsertOnDuplicateKey;
    
    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'app_number' => [
            'searchable' => true,
        ],
        'fullname' => [
            'searchable' => true,
        ],
        'mode_of_entry' => [
            'searchable' => true,
        ],
        'first_choice' => [
            'searchable' => true,
        ],
        'state_of_origin' => [
            'searchable' => true,
        ],
        'lga_of_origin' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ]
    ];


    protected $guard = 'student';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    
    // Students Attempts
    public function attempts()
    {
        return $this->hasMany(ExamAtempt::class);
    }

    // public function exams() {
    //     return $this->belongsToMany(Exam::class, 'student_exams');
    // }

    public function scores()
    {
        return $this->hasMany(ExamScore::class, 'student_id');
    }

    public function recommendation() {
        return $this->hasOne(Recommendation::class);
    }

    public function examTime() {
        return $this->hasOne(StuExamTime::class);
    }
}
