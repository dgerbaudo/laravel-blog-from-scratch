<?php

namespace App;


use Carbon\Carbon;

class Post extends Model
{

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($body)
    {
//        Comment::create([
//            'body' => request('body'),
//            'post_id' => $this->id
//        ]);

        $this->comments()->create(compact('body'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $filters)
    {
        if ($month = $filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }

        if ($year = $filters['year']) {
            $query->whereYear('created_at', $year);
        }
    }

    public static function archives() {
        return Post::selectRaw('date_part(\'year\', created_at) as year, 
                            to_char(to_timestamp (date_part(\'month\',created_at)::text, \'MM\'), \'Month\') as month,
                            count(*) as published')
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toArray();
    }

}
