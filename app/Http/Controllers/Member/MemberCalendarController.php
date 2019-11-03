<?php

namespace App\Http\Controllers\Member;

use App\Task;
use App\TaskboardColumn;

class MemberCalendarController extends MemberBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.taskCalendar';
        $this->pageIcon = 'icon-calender';
        $this->middleware(function ($request, $next) {
            if(!in_array('tasks',$this->user->modules)){
                abort(403);
            }
            return $next($request);
        });

    }

    public function index() {
        $taskBoardColumn = TaskboardColumn::where('slug', 'incomplete')->first();
        $this->tasks = Task::where('tasks.board_column_id', $taskBoardColumn->id)->where('user_id', $this->user->id)->get();
        return view('member.task-calendar.index', $this->data);
    }

    public function show($id) {
        $this->task = Task::findOrFail($id);
        return view('member.task-calendar.show', $this->data);
    }
}
