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
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the Admin can view the admin.
     *
     * @param  \App\Admin  $admin
     * @param  \App\Admin  $admin
     * @return mixed
     */

    /**
     * Determine whether the Admin can create admins.
     *
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        return in_array($admin->supervisor, [1]);
    }

    /**
     * Determine whether the Admin can update the admin.
     *
     * @param  \App\Admin  $admin
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function update(Admin $admin)
    {
        return in_array($admin->supervisor, [1]);
    }

    /**
     * Determine whether the Admin can delete the admin.
     *
     * @param  \App\Admin  $admin
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function delete(Admin $admin)
    {
        return in_array($admin->supervisor, [1]);
    }

    /**
     * Determine whether the Admin can restore the admin.
     *
     * @param  \App\Admin  $admin
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function restore(Admin $admin)
    {
        return in_array($admin->supervisor, [1]);
    }

    /**
     * Determine whether the Admin can permanently delete the admin.
     *
     * @param  \App\Admin  $admin
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function forceDelete(Admin $admin)
    {
        return in_array($admin->supervisor, [1]);
    }

}
