<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['url', 'avater'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        // return route("questions.show", $this->id);
        return '#';
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getAvaterAttribute()
    {
        // ->format("d/m/Y)
        $email = $this->email;
        //  $default = "https://www.somewhere.com/homestar.jpg";
        $size = 32;

        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=" . $size;

        return $grav_url;
    }

    public function favorites()
    {
        // return $this->belongsToMany(Question::class, 'favorites', 'user_id', 'question_id'); ok
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }

    // relationship method
    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');
    }


    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    // custom method
    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions =  $this->voteQuestions();
        return  $this->_vote($voteQuestions, $question, $vote);
        // if ($voteQuestions->where('votable_id', $question->id)->exists()) {
        //     $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
        // } else {
        //     $voteQuestions->attach($question, ['vote' => $vote]);
        // }


        // $question->load('votes');

        // $downVotes = (int) $question->downVotes()->sum('vote');
        // $upVotes = (int) $question->upVotes()->sum('vote');

        // $question->votes_count = $upVotes + $downVotes;
        // $question->save();
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAsnwers =  $this->voteAnswers();
        return  $this->_vote($voteAsnwers, $answer, $vote);
    }

    private function _vote($relationship, $model, $vote)
    {
        if ($relationship->where('votable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        } else {
            $relationship->attach($model, ['vote' => $vote]);
        }


        $model->load('votes');

        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');

        $model->votes_count = $upVotes + $downVotes;
        $model->save();

        return $model->votes_count;
    }
}
