<?php

namespace App\Observers;

use App\StorageSetting;

class StorageSettingObserver
{

    public function saving(StorageSetting $storage)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $storage->company_id = company()->id;
        }
    }

}
