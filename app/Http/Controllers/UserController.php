<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $this->authorize('admin');
    return User::withRole()->paginate(10);

    // For custom response

    // $response = Gate::inspect('admin');
    // if ($response->allowed()) {
    //   return User::withRole()->paginate(10);
    // } else {
    //   return response(['message' => 'Only admin have the access.']);
    // }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    $this->authorize('admin');
    return User::withRole()->paginate(10);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user) {
    $this->authorize('delete', $user);
    return User::withRole()->paginate(10);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user) {
    $this->authorize('delete', $user);
    $user->delete();
    return response(['user' => $user]);
  }
}
