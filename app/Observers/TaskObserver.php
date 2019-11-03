<?php

namespace App\Observers;

use App\Task;
use App\TaskboardColumn;

class TaskObserver
{

    public function saving(Task $task)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $task->company_id = company()->id;
        }
    }

    public function creating(Task $task)
    {
        $taskBoard = TaskboardColumn::orderBy('id', 'asc')->first();
        $task->board_column_id = $taskBoard->id;

    }

    public function updating (Task $task)
    {
        if ($task->isDirty('status')) {
            $status = $task->status;

            if ($status == 'completed') {
                $task->board_column_id = TaskboardColumn::where('priority', 2)->first()->id;
                $task->column_priority = 1;
            } elseif ($status == 'incomplete') {
                $task->board_column_id = TaskboardColumn::where('priority', 1)->first()->id;
                $task->column_priority = 1;
            }
        }

        if ($task->isDirty('board_column_id') && $task->column_priority != 2) {
            $task->status = 'incomplete';
        }
    }

}
