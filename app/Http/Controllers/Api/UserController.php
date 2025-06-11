<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Application\Command\CreateUser\CreateUserUseCase;
use App\Application\Command\CreateUser\CreateUserCommand;
use App\Domain\User\Repository\UserRepository;

class UserController extends Controller
{
    public function __construct(
        private CreateUserUseCase $createUserUseCase,
        private UserRepository $userRepository
    ) {}

    /**
     * Create a new user.
     */
    public function create(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $command = new CreateUserCommand(
            $validated['email'],
            $validated['password'],
            $validated['name']
        );

        $user = $this->createUserUseCase->execute($command);

        return response()->json([
            'id'         => $user->id,
            'email'      => $user->email->value,
            'name'       => $user->name->value,
            'created_at' => now(),
        ], 201);
    }

    /**
     * Get a paginated list of users.
     */
    public function getUsers(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'page'   => 'integer|min:1',
            'sortBy' => 'nullable|string|in:name,email,created_at',
        ]);

        $result = $this->userRepository->searchPaginated(
            $request->query('search'),
            $request->query('page', 1),
            $request->query('sortBy'),
            auth('api')->user()
        );

        return response()->json($result, 200);
    }
}
