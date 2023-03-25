<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use Src\Domain\Users\Services\AbstractUpdateUser;
use Src\Implementation\Users\Dto\UpdateUserDto;

class UpdateUserController extends Controller{

	protected AbstractUpdateUser $service;

	public function __construct(AbstractUpdateUser $service)
	{
		$this->service = $service;
	}

	public function handle(UpdateUserRequest $request){
		$updateUserDto = new UpdateUserDto($request->validated());
		$user = $this->service->execute($updateUserDto, auth('api')->user()->id);

		return response()->json($user, 200);
	}

}
