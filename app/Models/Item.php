<?php 
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Eloquent {

    protected $dates = ['deleted_at'];

    protected $table = 'Item';

    public static function validate($input) {
        $rules = array(
            'name' => 'required'
        );
        
        return Validator::make($input, $rules);
    }

    //Define relationship between Item-Comments
    public function comment() {
        return $this->hasMany('Comment', 'item_id');
    }

}