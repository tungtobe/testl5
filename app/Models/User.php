<?php



use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract{

  
        use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'User';

    

    //Define relationship between User-Comments
    public function comment() {
        return $this->hasMany('Comment', 'user_id');
    }

    //Define relationship between User-Votes
    public function vote() {
        return $this->hasMany('Vote', 'user_id');
    }
    

    //Define relationship between User-Bill
    public function bill() {
        return $this->hasMany('Bill', 'user_id');
    }


    //Define relationship between User-Favorite
    public function favoriteitems() {
        return $this->hasMany('Favoriteitem', 'user_id');
    }


    public static function validate($input) {
        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );
        
        return Validator::make($input, $rules);
    }

}
