<?php namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $guarded = ['id'];

    public function module(){
      return $this->belongsTo(Module::class, 'module_id');
    }
}