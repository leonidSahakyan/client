<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Clients extends Model
{
    protected $table = 'clients';

    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){//,
    	$query = DB::table('clients');
		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS clients.id'),
                                    'clients.id as DT_RowId',
                                    'clients.id as id',
                                    'clients.renewal_date',
                                    'clients.closing_date',
                                    'clients.address',
                                    'clients.dob',
                                    'clients.phone',
                                    'clients.email',
                                    'clients.rate',
                                    'clients.fee',
                                    'clients.admin_fee',
                                    'clients.mortgage_amount',
                                    'clients.current_mortgage',
                                    'clients.status',
                                    'clients.term',
                                    'agents.name as agent_name',
                                    'agents.email as agent_email',
                                    'agents.phone as agent_phone',
                                    ));

        $query->leftJoin('agents', 'clients.agent_id', '=', 'agents.id');

		if($length != '-1'){
			$query->skip($start)->take($length);
		}
        
        if ($filter){
            if(isset($filter['search']) && strlen($filter['search']) > 0){
                $searchQ = $filter['search'];
                
                $query->where(function ($query) use ($searchQ) {
                    $query->where('address','LIKE',"%{$searchQ}%")
                        ->orWhere('phone','LIKE',"%{$searchQ}%")
                        ->orWhere('email','LIKE',"%{$searchQ}%")
                        ->orWhere('phone','LIKE',"%{$searchQ}%")
                        ->orWhere('agent.name','LIKE',"%{$searchQ}%");
                });
            }

            if(strlen($filter['status']) && $filter['status'] != '-1'){
                $query->where('status','=',$filter['status']);
            }

		}
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();
        
		foreach ($data as $d) {
            $d->DT_RowId = "row_".$d->DT_RowId;
            $d->rate = $d->rate."$";
            $d->fee = $d->fee."$";
            $d->admin_fee = $d->admin_fee."$";
            $d->current_mortgage = $d->current_mortgage."$";
            $d->mortgage_amount = $d->mortgage_amount."$";
            $d->agent_name = $d->agent_name."<i data-id=".$d->id." data-toggle='modal' data-target='#agentPopup' class='fa fa-angle-down agent-popup-trigger'></i>";

            // $d->status = $d->status == 1 ? 'Active' : 'Completed';
		}
		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }
}
