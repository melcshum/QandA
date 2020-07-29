<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $fillable = ['body', 'user_id'];
    //
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function getCreatedDateAttribute()
    {
        // ->format("d/m/Y)
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        // ->format("d/m/Y)
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
    }



    public static function boot()
    {
        parent::boot();
        static::created(function ($answer) {
            // echo 'Answer created\n';
            $answer->question->increment('answers_count');
            //     $answer->question->save();

        });
        static::deleted(function ($answer) {

            $question = $answer->question;
            $question->decrement('answers_count');

            //     $answer->question->save();

        });
        // static::saved (function($answer)
        // {
        //     echo 'Answer saved\n';
        // });
    }
}
