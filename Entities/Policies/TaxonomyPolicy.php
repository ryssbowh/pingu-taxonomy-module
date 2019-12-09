<?php

namespace Pingu\Taxonomy\Entities\Policies;

use Pingu\Entity\Support\BaseEntityPolicy;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\User\Entities\User;

class TaxonomyPolicy extends BaseEntityPolicy
{
    protected function userOrGuest(?User $user)
    {
        return $user ? $user : \Permissions::guestRole();
    }

    public function index(?User $user)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view taxonomies vocabularies');
    }

    public function view(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view taxonomies vocabularies');
    }

    public function edit(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('edit taxonomies vocabularies');
    }

    public function delete(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('delete taxonomies vocabularies');
    }

    public function create(?User $user)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('edit taxonomies vocabularies');
    }

    public function editItems(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view taxonomies terms');
    }
}