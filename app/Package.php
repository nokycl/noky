<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    public function formatSizeUnits($bytes)
    {
       if ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' GB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes. ' MB';
        }
        else
        {
            $bytes = '0 MB';
        }

        return $bytes;
    }

    public function currency () {
        return $this->belongsTo(GlobalCurrency::class, 'currency_id');
    }
}
