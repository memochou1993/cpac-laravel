<?php

namespace App\Http\GraphQL\Queries;

use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UserQuery
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue
     * @param  array  $args
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext|null  $context
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo
     * @return mixed
     */
    public function fetchUsers($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        return User::paginate($args['pagination'] ?? config('default.pagination'));
    }
}
