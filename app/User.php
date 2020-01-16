<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

class User extends Authenticatable
{
    protected $table = 'users';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('users');
		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS users.id'),
                                    'users.id as DT_RowId',
                                    'users.id as id',
                                    'users.name',
                                    'users.phone',
                                    'users.email',
                                    ));
		if($length != '-1'){
			$query->skip($start)->take($length);
		}
        
        if ($filter){
            if(isset($filter['search']) && strlen($filter['search']) > 0){
                $searchQ = $filter['search'];
                
                $query->where(function ($query) use ($searchQ) {
                    $query->where('name','LIKE',"%{$searchQ}%")
                        ->orWhere('phone','LIKE',"%{$searchQ}%")
                        ->orWhere('email','LIKE',"%{$searchQ}%");
                });
            }

		}
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();
        
		// foreach ($data as $d) {
        //     $d->DT_RowId = "row_".$d->DT_RowId;
        //     $d->rate = $d->rate."$";
        //     $d->fee = $d->fee."$";
        //     $d->admin_fee = $d->admin_fee."$";
        //     $d->current_mortgage = $d->current_mortgage."$";
        //     $d->mortgage_amount = $d->mortgage_amount."$";
        //     $d->referral_source_name = $d->referral_source_name."<i class='fa fa-angle-down'></i>";

        //     $d->status = $d->status == 1 ? 'Active' : 'Completed';
		// }
		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }
}
