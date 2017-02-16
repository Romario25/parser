<?php

namespace App\Policies;

use App\User;
use App\Proxy;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProxyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the proxy.
     *
     * @param  \App\User  $user
     * @param  \App\Proxy  $proxy
     * @return mixed
     */
    public function view(User $user, Proxy $proxy)
    {
        //
    }

    /**
     * Determine whether the user can create proxies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the proxy.
     *
     * @param  \App\User  $user
     * @param  \App\Proxy  $proxy
     * @return mixed
     */
    public function update(User $user, Proxy $proxy)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the proxy.
     *
     * @param  \App\User  $user
     * @param  \App\Proxy  $proxy
     * @return mixed
     */
    public function delete(User $user, Proxy $proxy)
    {
        //
    }
}
