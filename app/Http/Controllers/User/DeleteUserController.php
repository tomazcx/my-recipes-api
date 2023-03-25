<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Src\Domain\Users\Services\AbstractDeleteUser;

class DeleteUserController extends Controller{

	protected AbstractDeleteUser $service;

	public function __construct(AbstractDeleteUser $service)
	{
		$this->service = $service;
	}

	public function handle(){
		$this->service->execute(auth('api')->user()->id);
		return response()->json([], 204);
	}


}

