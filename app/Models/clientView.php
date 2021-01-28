<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientView extends Model
{    protected $primaryKey = 'id';
    protected $table = 'client_view';
    protected $fillable = ['topicDisplay'];

}
