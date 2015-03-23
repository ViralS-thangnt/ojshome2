<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Lib\Prototype\Interfaces\UserInterface;
use Illuminate\Support\Facades\Session;
use Input;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userRepo;

    public function __construct(UserInterface $userRepo)
    {
        Session::put(REQUIRE_PERMISSION, ADMIN);
        //$this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->userRepo->all();

        return view('users.index', compact('users'));
    }

    public function form($id = null)
    {
        if ($id) {
            $user = $this->userRepo->getById($id);
        } else {
            $user = $this->userRepo;
        }

        return view('users.form', compact('user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UserRequest $request, $id = null)
    {
        $this->userRepo->formModify(Input::all(), $id);

        return redirect('admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->userRepo->delete($id);
        Session::flash(SUCCESS_MESSAGE, 'Delete user successfully');

        return redirect('admin/user');
    }
}
