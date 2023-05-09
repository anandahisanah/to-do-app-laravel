<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RegistrationController extends Controller
{
    public function show()
    {
        return view('auth.registration');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'birthdate' => 'required',
            'address' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);

        try {
            DB::beginTransaction();

            User::create([
                'uuid' => Uuid::uuid1(),
                'name' => $request->name,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            DB::commit();
            return redirect('group')
                ->with('alert', [
                    'status' => 'success',
                    'message' => 'Your account has been successfully created.'
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
