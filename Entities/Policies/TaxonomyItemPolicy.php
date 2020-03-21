<?php

namespace Pingu\Taxonomy\Entities\Policies;

use Pingu\Core\Support\Policy;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\Entity;
use Pingu\Taxonomy\Entities\TaxonomyItem;
use Pingu\User\Entities\User;

class TaxonomyItemPolicy extends Policy
{
    protected function userOrGuest(?User $user)
    {
        return $user ? $user : \Permissions::guestRole();
    }

    public function index(?User $user)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view taxonomy terms');
    }

    public function view(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view taxonomy terms');
    }

    public function edit(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('edit taxonomy terms');
    }

    public function delete(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('delete taxonomy terms');
    }

    public function create(?User $user, ?BundleContract $bundle = null)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('edit taxonomy terms');
    }
}