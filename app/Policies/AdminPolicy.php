<?php

namespace App\Policies;

use App\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the Admin can view any admins.
     *
     * @param  \App\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        //
    }

    /**
     * Determine whether the Admin can view the admin.
     *
     * @param  \App\Admin  $user
     * @param  \App\Admin\Admin  $admin
     * @return mixed
     */
    public function view(Admin $user, Admin $admin)
    {
        if(in_array($user->supervisor, [1]) || $user->id === $admin->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the Admin can create admins.
     *
     * @param  \App\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return in_array($user->supervisor, [1]);
    }

    /**
     * Determine whether the Admin can update the admin.
     *
     * @param  \App\Admin  $user
     * @param  \App\Admin\Admin  $admin
     * @return mixed
     */
    public function update(Admin $user, Admin $admin)
    {
        if(in_array($user->supervisor, [1]) || $user->id === $admin->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the Admin can delete the admin.
     *
     * @param  \App\Admin  $user
     * @param  \App\Admin\Admin  $admin
     * @return mixed
     */
    public function delete(Admin $user, Admin $admin)
    {
        return in_array($user->supervisor, [1]);
    }

    /**
     * Determine whether the Admin can restore the admin.
     *
     * @param  \App\Admin  $user
     * @param  \App\Admin\Admin  $admin
     * @return mixed
     */
    public function restore(Admin $user, Admin $admin)
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the admin.
     *
     * @param  \App\Admin  $user
     * @param  \App\Admin\Admin  $admin
     * @return mixed
     */
    public function forceDelete(Admin $user, Admin $admin)
    {
        //
    }
}
