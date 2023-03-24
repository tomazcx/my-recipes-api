<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use Src\Domain\Auth\Services\AbstractAuthenticate;
use Src\Implementation\Auth\Dto\AuthenticateDto;

class AuthenticateController extends Controller{

	protected AbstractAuthenticate $service;

	public function __construct(AbstractAuthenticate $service)
	{
		$this->service = $service;	
	}

	public function handle(AuthenticateRequest $request)
	{
		$authenticateDto = new AuthenticateDto($request->validated());

		$tokenObj = $this->service->execute($authenticateDto);

		return response()->json($tokenObj, 200);
	}

} 

