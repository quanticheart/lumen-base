<?php
    
    namespace App\Models;
    
    use Illuminate\Auth\Authenticatable;
    use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Laravel\Lumen\Auth\Authorizable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class Usuario extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject {
        use Authenticatable, Authorizable, HasFactory;
    
        /**
         * @var string table name
         */
        protected $table = 'usuario';
    
        /**
         * @var bool for block update timestamp updated_at and created_at
         */
//        public $timestamps = false;
        
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'id', 'usuario', 'email',
        ];
        
        /**
         * The attributes excluded from the model's JSON form.
         *
         * @var array
         */
        protected $hidden = [
            'password',
        ];
        
        /**
         * Get the identifier that will be stored in the subject claim of the JWT.
         *
         * @return mixed
         */
        public function getJWTIdentifier() {
            return $this->getKey();
        }
        
        /**
         * Return a key value array, containing any custom claims to be added to the JWT.
         *
         * @return array
         */
        public function getJWTCustomClaims() {
            return [];
        }
    }
