<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Lib\Prototype\Interfaces\UserInterface as UserRepository;

class UserComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $user;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        // Dependencies automatically resolved by service container...
        $this->user = $user;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $permissions = $this->user->getPermissions();
        $view->with('permissions', $permissions);
    }

}