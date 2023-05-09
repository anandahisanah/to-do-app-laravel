<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Status;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TodoController extends Controller
{
    public function show($group)
    {
        $group = Group::where('uuid', $group)->firstOrFail();

        $todos = Todo::where('group_id', $group->id)->with('status')->orderBy('status_id')->get()
            ->groupBy('status.name');

        $data = [
            'group' => $group,
            'todos' => $todos,
        ];

        return view('pages.group.todo.show', $data);
    }

    public function add($group, $status)
    {
        $group = Group::where('uuid', $group)->with('members.user')->firstOrFail();

        $status = Status::where('uuid', $status)->firstOrFail();

        $data = [
            'group' => $group,
            'status' => $status,
        ];
        return view('pages.group.todo.add', $data);
    }

    public function create($group, $status, Request $request)
    {
        $request->validate([
            'assignee_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $group = Group::where('uuid', $group)->firstOrFail();

        $status = Status::where('uuid', $status)->firstOrFail();

        try {
            DB::beginTransaction();

            Todo::create([
                'uuid' => Uuid::uuid1(),
                'group_id' => $group->id,
                'created_user_id' => Auth::user()->id,
                'assignee_id' => $request->assignee_id,
                'status_id' => $status->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('group.todo.show', ['group' => $group->uuid])
                ->with('alert', [
                    'status' => 'success',
                    'message' => 'Todo Created.'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('alert', [
                    'status' => 'danger',
                    'message' => $th->getMessage()
                ]);
        }
    }

    public function edit($group, $status, $todo)
    {
        $group = Group::where('uuid', $group)->with('members.user')->firstOrFail();

        $status = Status::where('uuid', $status)->firstOrFail();

        $todo = Todo::where('uuid', $todo)->with('assignee')->firstOrFail();

        $data = [
            'group' => $group,
            'status' => $status,
            'todo' => $todo,
        ];
        return view('pages.group.todo.edit', $data);
    }

    public function update($group, $status, $todo, Request $request)
    {
        $request->validate([
            'assignee_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $group = Group::where('uuid', $group)->firstOrFail();

        $status = Status::where('uuid', $status)->firstOrFail();

        try {
            DB::beginTransaction();

            Todo::where('uuid', $todo)->update([
                'group_id' => $group->id,
                'created_user_id' => Auth::user()->id,
                'assignee_id' => $request->assignee_id,
                'status_id' => $status->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('group.todo.show', ['group' => $group->uuid])
                ->with('alert', [
                    'status' => 'success',
                    'message' => 'Todo Updated.'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('alert', [
                    'status' => 'danger',
                    'message' => $th->getMessage()
                ]);
        }
    }

    public function delete($group, $todo)
    {
        try {
            DB::beginTransaction();
            Todo::where('uuid', $todo)->delete();

            DB::commit();
            return redirect()
                ->back()
                ->with('alert', [
                    'status' => 'warning',
                    'message' => 'Berhasil Dihapus'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('alert', [
                    'status' => 'danger',
                    'message' => $th->getMessage()
                ]);
        }
    }
}
