<?php
    
    namespace App\Models;
    
    use Illuminate\Auth\Authenticatable;
    use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Laravel\Lumen\Auth\Authorizable;

    /**
     * @property mixed id
     * @method static where(string $string, $input)
     * @method static find($sub)
     */
    class User extends Model implements AuthenticatableContract, AuthorizableContract {
        use Authenticatable, Authorizable, HasFactory;
        
        /**
         * @var string table name
         */
        protected string $table = 'usuario';
        
        /**
         * @var bool for block update timestamp updated_at and created_at
         */
//        public $timestamps = false;
        
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected array $fillable = [
            'id', 'usuario', 'email',
        ];
        
        /**
         * The attributes excluded from the model's JSON form.
         *
         * @var array
         */
        protected array $hidden = [
            'password', 'verificado', 'updated_at', 'created_at'
        ];

//        /**
//         * The attributes to cast include in database
//         *
//         * @var array
//         */
//        protected $casts = [
//            'date_column' => 'Timestamp'
//        ];
    }
