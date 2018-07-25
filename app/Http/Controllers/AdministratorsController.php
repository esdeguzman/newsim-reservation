<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\AdministratorRole;
use App\Branch;
use App\Department;
use function App\Helper\admin;
use App\HistoryDetail;
use App\Position;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdministratorsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can.access'])->except('login', 'store');
    }

    public function login()
    {
        return view('pages.login', [
            'branches' => Branch::all(),
            'departments' => Department::all(),
            'positions' => Position::all(),
        ]);
    }

    public function index()
    {
        $administrators = null;

        $administrators = Administrator::all();

        return view('administrators.index', compact('administrators'));
    }

    public function show($admin)
    {
        return view('administrators.show', [
            'administrator' => Administrator::withTrashed()->where('id', $admin)->first(),
            'branches' => Branch::all(),
            'departments' => Department::all(),
            'positions' => Position::all(),
            'roles' => Role::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request['username'] = $request->desired_username;
        $request['password'] = $request->desire_password;

        $userDetails = $request->validate([
            'desired_username' => 'required|min:3|unique:users,username',
            'email' => 'required|unique:users',
            'desired_password' => 'required|min:6|confirmed',
        ]);

        $adminInfo = $request->validate([
            'branch_id' => 'required',
            'department_id' => 'required',
            'position_id' => 'required',
            'employee_id' => 'required',
            'full_name' => 'required',
        ]);

        $request->validate([
            'reason' => 'required|min:15'
        ]);

        $userDetails['password'] = bcrypt($request->desired_password);
        $userDetails['username'] = $request->desired_username;

        $user = User::create(array_except($userDetails, ['desired_username', 'desired_password']));

        $adminInfo['user_id'] = $user->id; // add user_id to adminInfo to facilitate the use of create method

        $admin = Administrator::create($adminInfo);

        HistoryDetail::create([
            'log' => $request->reason,
            'remarks' => "$request->full_name is requesting an admin account, please see log",
            'updated_by' => 1,
        ]);

        $request->session()->flash('info', [
            'success' => 'Request successfully submitted! You will receive an email verification ' .
                            'after the administrator has confirmed your request.'
        ] );

        return back();
    }

    public function update(Administrator $administrator, Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                Rule::unique('users')->ignore($administrator->user->id)
            ],
            'employee_id' => [
                'required',
                Rule::unique('administrators')->ignore($administrator->id)
            ],
            'full_name' => 'required|min:6',
            'branch_id' => 'required',
            'department_id' => 'required',
            'position_id' => 'required',
        ]);

        try {
            $user = $administrator->user;
            $user->email = $request->email;
            $user->save();
        } catch (\Exception $exception) {
            Log::error('admin update error', $exception->errorInfo);
        }

        try {
            $administrator->employee_id = $request->employee_id;
            $administrator->save();
        } catch (\Exception $exception) {
            Log::error('admin update error', $exception->errorInfo);
        }

        HistoryDetail::create([
            'administrator_id' => $administrator->id,
            'log' => "updated admin info {$administrator->full_name} -> {$request->full_name},"
                    . " {$administrator->branch_id} -> {$request->branch_id}, {$administrator->department_id} ->"
                    . " {$request->department_id} and {$administrator->position_id} -> {$request->position_id}",
            'remarks' => 'role has been revoked',
            'updated_by' => admin()->id,
        ]);

        $administrator->full_name = $request->full_name;
        $administrator->branch_id = $request->branch_id;
        $administrator->department_id = $request->department_id;
        $administrator->position_id = $request->position_id;
        $administrator->save();

        $oldAdministratorRoles = AdministratorRole::where('administrator_id', $administrator->id)->get();

        if ($request->has('roles')) {
            try {
                $newAdministratorRoles = Role::find($request->roles);

                if ($oldAdministratorRoles) {
                    foreach ($oldAdministratorRoles as $oldAdministratorRole) {
                        if (count($newAdministratorRoles) == 0 || ! $newAdministratorRoles
                                                                    ->contains('id', $oldAdministratorRole->role_id)) {
                            $oldAdministratorRole->revoked_by = admin()->id;
                            $oldAdministratorRole->save();

                            HistoryDetail::create([
                                'administrator_role_id' => $oldAdministratorRole->id,
                                'log' => 'revoked (' . $oldAdministratorRole->role->name . ') role',
                                'remarks' => 'role has been revoked',
                                'updated_by' => admin()->id,
                            ]);
                        }
                    }
                }

                if (count($newAdministratorRoles) > 0) {
                    foreach ($newAdministratorRoles as $newAdministratorRole) {
                        $adminRole = AdministratorRole::where('administrator_id', $administrator->id)
                            ->where('role_id', $newAdministratorRole->id)->first();

                        if ($adminRole) {
                          $adminRole->revoked_by = null;
                          $adminRole->save();
                        } else {
                            $adminRole = AdministratorRole::create([
                                'administrator_id' => $administrator->id,
                                'role_id' => $newAdministratorRole->id,
                                'assigned_by' => admin()->id,
                            ]);
                        }

                        HistoryDetail::create([
                            'administrator_role_id' => $adminRole->id,
                            'log' => 'assigned (' . $adminRole->role->name . ') role',
                            'remarks' => 'role has been assigned',
                            'updated_by' => admin()->id,
                        ]);
                    }
                }
            } catch (\Exception $exception) {
                return $exception;
            }
        } else {
            if ($oldAdministratorRoles) {
                foreach ($oldAdministratorRoles as $oldAdministratorRole) {
                    $oldAdministratorRole->revoked_by = admin()->id;
                    $oldAdministratorRole->save();

                    HistoryDetail::create([
                        'administrator_role_id' => $oldAdministratorRole->id,
                        'log' => 'revoked (' . $oldAdministratorRole->role->name . ') role',
                        'remarks' => 'role has been revoked',
                        'updated_by' => admin()->id,
                    ]);
                }
            }
        }

        $request->session()->flash('info', [
            'title' => 'Admin Info Updated!',
            'type' => 'success',
            'text' => 'Admin information has been successfully updated!',
            'confirmButtonColor' => '#8db600',
            'confirmButtonText' => 'OKAY, COOL!',
        ]);

        return back();
    }

    public function updateStatus(Administrator $administrator, Request $request)
    {
        $request->validate([
            'status' => 'required',
            'remarks' => 'required|min:10',
        ]);

        $oldStatus = $administrator->status;
        $administrator->status = $request->status;
        $administrator->save();

        HistoryDetail::create([
            'administrator_id' => $administrator->id,
            'log' => "updated admin status from {$oldStatus} to {$administrator->status}, please see remarks",
            'remarks' => $request->remarks,
            'updated_by' => admin()->id
        ]);

        $request->session()->flash('info', [
            'title' => 'Admin Status Updated!',
            'type' => 'success',
            'text' => 'Admin status has been successfully updated!',
            'confirmButtonColor' => '#8db600',
            'confirmButtonText' => 'OKAY, COOL!',
        ]);

        return back();
    }
}
