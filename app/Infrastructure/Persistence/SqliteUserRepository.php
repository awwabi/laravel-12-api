<?php

namespace App\Infrastructure\Persistence;

use App\Domain\User\Entity\User as DomainUser;
use App\Domain\User\Repository\UserRepository;
use App\Models\User as AppUser;
use Illuminate\Support\Facades\DB;

class SqliteUserRepository implements UserRepository
{
    public function save(DomainUser $userModel): void
    {
        $user = new AppUser();
        $user->email = $userModel->email->value;
        $user->name = $userModel->name->value;
        $user->password = bcrypt($userModel->password->value);
        $user->role = $userModel->role;
        $user->active = true; // New users are active by default
        $user->save();

        $userModel->id = $user->id;
    }

    public function findById(int $id): ?DomainUser
    {
        $user = AppUser::find($id);

        if (! $user) {
            return null;
        }

        return new DomainUser(
            $user->id,
            new \App\Domain\User\ValueObject\Email($user->email),
            new \App\Domain\User\ValueObject\Name($user->name),
            new \App\Domain\User\ValueObject\Password($user->password),
            $user->role,
            $user->active
        );
    }

    public function searchPaginated(?string $search, int $page, ?string $sortBy, AppUser $currentUser)
    {
        $sortBy = in_array($sortBy, ['name', 'email', 'created_at']) ? $sortBy : 'created_at';
        $perPage = config('pagination.per_page', 15);

        $usersQuery = DB::table('users')
            ->select([
                'id',
                'email',
                'name',
                'role',
                'created_at'
            ])
            ->where('active', true);

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $usersQuery->orderBy($sortBy);

        $users = $usersQuery
            ->forPage($page, $perPage)
            ->get();

        $userIds = $users->pluck('id');

        // Optimizing the query to count orders for the users
        // using a single separated query instead of subquery inside the user query
        $orderCounts = DB::table('orders')
            ->select('user_id', DB::raw('COUNT(*) as orders_count'))
            ->whereIn('user_id', $userIds)
            ->groupBy('user_id')
            ->pluck('orders_count', 'user_id');

        $users = $users->map(function ($user) use ($currentUser, $orderCounts) {
            return $this->transformUser($user, $currentUser, $orderCounts);
        });
        

        return [
            'page'  => $page,
            'users' => $users->toArray()
        ];
    }

    private function transformUser($user, AppUser $currentUser, $orderCounts)
    {
        $user->orders_count = $orderCounts[$user->id] ?? 0;
        $user->can_edit = match ($currentUser->role) {
            'admin'   => true,
            'manager' => $user->role === 'user',
            'user'    => $currentUser->id === $user->id,
            default   => false,
        };
        return $user;
    }
}
