<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Customer extends Model {
 protected $guarded=[]; protected $casts=['nid'=>'encrypted','paid_until'=>'date'];
 protected static function booted(): void { static::creating(fn($c)=>$c->license_key ??= Str::random(32)); }
 public function payments(){ return $this->hasMany(Payment::class); }
 public function overdue(): bool { return $this->plan==='monthly' && $this->paid_until && $this->paid_until->lt(today()); }
}
