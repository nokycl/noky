<?php

namespace App\Observers;


use App\Project;

class ProjectObserver
{

    public function saving(Project $project)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $project->company_id = company()->id;
        }
    }

}
