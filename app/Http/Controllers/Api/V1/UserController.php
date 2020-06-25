<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserForm;
use App\Http\Requests\UserEmployeeForm;
use App\User;
use App\UserAction;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Ldap;

/** @resource User
 *
 * Resource to retrieve, show, update and destroy User data
 */

class UserController extends Controller
{
  /**
   * Display User's data.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::where('active', true)->with('roles')->whereNotNull('employee_id')->with('employee')->orderBy('username')->get();
    foreach ($users as $i => $user) {
      $permissions_list = $user->allPermissions()->pluck('id');
      unset($user['permissions']);
      $user->permissions = $permissions_list;
    }
    return $users;
  }

  /**
   * Stores a user.
   *
   * @param  \App\Employee  $employee
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $employee = Employee::findOrFail($request->employee_id);
    $user = new User();
    $user->username = strtolower($employee->first_name);
    $user->active = true;
    $user->employee_id = $employee->id;
    $user->password = Hash::make($employee->identity_card);
    $user->save();
    return $user;
  }

  /**
   * Display the specified user.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::findOrFail($id);
    if ($user->active) {
      $user->employee;
      return $user;
    }
    abort(404);
  }

  /**
   * Update the specified user in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(UserForm $request, $id)
  {
    $user = User::findOrFail($id);
    if (!Hash::check(request('oldPassword'), Auth::user()->password) || $user->id != $id) {
      return response()->json([
        'message' => 'Contraseña incorrecta',
        'errors' => [
          'type' => ['Contraseña anterior incorrecta'],
        ],
      ], 400);
    } else {
      $user = User::find(Auth::user()->id);
      $user->password = Hash::make(request('newPassword'));
      $user->save();
      return $user;
    }
  }

  /**
   * Remove the specified user from storage.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (UserAction::where('user_id', $id)->count() == 0) {
      $user = User::findOrFail($id);
      if ($user->username != 'admin') {
        $user->active = false;
        $user->save();
        return $user;
      } else {
        return response()->json([
          'message' => 'Bad Request Error',
          'errors' => [
            'type' => ['Este usuario no se puede eliminar'],
          ],
        ], 400);
      }
    } else {
      return response()->json([
        'message' => 'Bad Request Error',
        'errors' => [
          'type' => ['El usuario tiene acciones registradas'],
        ],
      ], 400);
    }
  }

  public function switch_active(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $user->active = !$user->active;
    $user->save();
    return $user;
  }
}
