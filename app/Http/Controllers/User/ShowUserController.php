<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Src\Domain\Users\Services\AbstractShowUser;

class ShowUserController extends Controller
{
	protected AbstractShowUser $service;

	public function __construct(AbstractShowUser $service)
	{
		$this->service = $service;	
	}

	public function __invoke($id)
	{
		$user = $this->service->execute($id);	

		return response()->json(['user' => $user], 200);
	}
   
}
