<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Todo;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function show()
    {
        $groups = Group::get();

        $data = [
            'groups' => $groups
        ];

        return view('pages.group.show', $data);
    }
}
