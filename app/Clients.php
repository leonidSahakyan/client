<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Clients extends Model
{
    protected $table = 'clients';

    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('clients');
		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS clients.id'),
                                    'clients.id as DT_RowId',
                                    'clients.id as id',
                                    'clients.renewal_date',
                                    'clients.start_date',
                                    'clients.closing_date',
                                    'clients.payment_type',
                                    'clients.iad as iad',
                                    'clients.name as client_name',
                                    'clients.dob',
                                    'clients.phone as phone',
                                    'clients.email as email',
                                    'clients.rate',
                                    'clients.amount as mortgage_amount',
                                    'clients.status',
                                    'clients.term',
                                    'clients.amortization_period',
                                    ));

        $query->leftJoin('agents', 'clients.agent_id', '=', 'agents.id');

		if($length != '-1'){
			$query->skip($start)->take($length);
		}

        if ($filter){
            if(isset($filter['search']) && strlen($filter['search']) > 0){
                $searchQ = $filter['search'];

                $query->where(function ($query) use ($searchQ) {
                    $query
                        ->where('clients.phone','LIKE',"%_".$searchQ."")
                        ->orWhere('clients.email','LIKE',"%".$searchQ."%")
                        ->orWhere('clients.name','LIKE',"%".$searchQ."%");
                });
            }

            if(strlen($filter['status']) && $filter['status'] != '-1'){
                $query->where('status','=',$filter['status']);
            }

            foreach ($filter as $key =>  $val) {
                if ($key !== 'status' && $val){
                    $query->where("$key",'=',$val);
                }
            }

		}
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();

		foreach ($data as $d) {
            $d->DT_RowId = "row_".$d->DT_RowId;
            $d->rate = ($d->rate)?$d->rate." %":'';
            $d->mortgage_amount = ($d->mortgage_amount)?"$ ".$d->mortgage_amount:'';
		}
		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }

    public function getAmountAttribute($value){
        return intval($value);
    }
}
