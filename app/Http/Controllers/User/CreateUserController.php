<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Services\AbstractCreateUser;
use Src\Implementation\Users\Dto\CreateUserDto;

class CreateUserController extends Controller
{
	protected AbstractCreateUser $service;
	protected AbstractCreateUserDto $dto;

	public function __construct(AbstractCreateUser $service)
	{
		$this->service = $service;	
	}

	public function handle(CreateUserRequest $request)
	{
		$dto = new CreateUserDto($request->validated());
		$user = $this->service->execute($dto);	

		return response()->json($user, 201);
	}
   
}
