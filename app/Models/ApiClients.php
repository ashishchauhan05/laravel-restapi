<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiClients extends Model
{
	use SoftDeletes;
    protected $table = 'api_clients';
    protected $fillable = [
		'name', 'token', 'description'
	];

}
