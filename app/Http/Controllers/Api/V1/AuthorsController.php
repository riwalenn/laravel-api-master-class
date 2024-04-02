<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\AuthorFilter;
use App\Models\User;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;

class AuthorsController extends ApiController
{
    /**
     * Get authors.
     * 
     * Retrieves all users that created a ticket.
     * 
     * @group Showing Authors
     */
    public function index(AuthorFilter $filters)
    {
        return UserResource::collection(
            User::select('users.*')
                ->join('tickets', 'users.id', '=', 'tickets.user_id')
                ->filter($filters)
                ->distinct()
                ->paginate()
        );
    }

    /**
     * Get an author.
     * 
     * Retrieves all users that created a ticket.
     * 
     * @group Showing Authors
     */
    public function show(User $author)
    {
        if ($this->include('tickets')) {
            return new UserResource($author->load('tickets'));
        }

        return new UserResource($author);
    }
}
