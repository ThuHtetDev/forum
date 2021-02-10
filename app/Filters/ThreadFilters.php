<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters{

    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function apply($builder){
        if($this->request->has('by')){
            $user = User::where('name',$this->request->by)->firstOrFail();
            $builder->where('user_id',$user->id);
        }

        if($this->request->has('sort')){
            if($this->request->sort == 'asc'){
                $builder->getQuery()->orders = [];
                $builder->orderBy('created_at','asc');
            }else{
                $builder->orderBy('created_at','desc');
            }
        }

        return $builder;
    }

}