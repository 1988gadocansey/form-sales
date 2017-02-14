<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {

	public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
    public function date($value)
    {
        $this->attributes['created_at'] = date("d/m/Y", strtotime($value));
    }
}
