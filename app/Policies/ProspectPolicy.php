<?php

namespace App\Policies;

use App\User;
use App\Prospect;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProspectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any customers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return $user->hasAnyRole(['admin','manager','user']);
    }

    /**
     * Determine whether the user can view the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Prospect  $customer
     * @return mixed
     */
    public function view(User $user, Prospect $customer)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can create customers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->hasAnyRole(['admin','manager','user']);
    }

    /**
     * Determine whether the user can update the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Prospect  $customer
     * @return mixed
     */
    public function update(User $user, Prospect $customer)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can delete the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Prospect  $customer
     * @return mixed
     */
    public function delete(User $user, Prospect $customer)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can restore the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Prospect  $customer
     * @return mixed
     */
    public function restore(User $user, Prospect $customer)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can permanently delete the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Prospect  $customer
     * @return mixed
     */
    public function forceDelete(User $user, Prospect $customer)
    {
      return $user->hasAnyRole(['admin','manager']);
    }
}