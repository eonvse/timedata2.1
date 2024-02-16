<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [ 'name',
                            'autor_id',
                            'team_id',
                            'color_id',
                            'day',
                            'start',
                            'end',
                            'content',
                            'isDone',
                            'dateDone',];
    protected $primaryKey = 'id';

    public function getCreatedAttribute()
    {

        return date('d.m.Y H:i', strtotime($this->created_at));

    }

    public function getUpdatedAttribute()
    {

        return date('d.m.Y H:i', strtotime($this->updated_at));

    }

    public function setDayAttribute($day)
    {

        $this->attributes['day'] = $day ?: null;

    }

    public function setStartAttribute($start)
    {

       $this->attributes['start'] = $start ?: null;

    }

    public function setEndAttribute($end)
    {

        $this->attributes['end'] = $end ?: null;

    }

    public function setContentAttribute($content)
    {

         $this->attributes['content'] = trim($content) ?: null;

    }

    public function color()
    {
        return $this->hasOne(Color::class,'id','color_id');
    }

    public function autor()
    {
        return $this->hasOne(User::class,'id','autor_id');
    }

}
