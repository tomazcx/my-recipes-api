<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateLocationRequest;
use Src\Domain\Users\Services\AbstractUpdateLocation;
use Src\Implementation\Users\Dto\UpdateLocationDto;

class UpdateLocationController extends Controller{

	protected AbstractUpdateLocation $service;

	public function __construct(AbstractUpdateLocation $service)
	{
		$this->service = $service;	
	}

	public function handle(UpdateLocationRequest $request){

		$dto = new UpdateLocationDto($request->validated());

		$user = $this->service->execute($dto, auth('api')->user()->id);

		return response()->json($user, 200);
	}

}
