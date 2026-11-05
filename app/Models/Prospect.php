<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Prospect extends Model { protected $guarded=[]; protected $casts=['last_contact_at'=>'datetime']; }
