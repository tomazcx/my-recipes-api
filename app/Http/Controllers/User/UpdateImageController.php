<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateImageRequest;
use Src\Domain\Users\Services\AbstractUpdateImage;

class UpdateImageController extends Controller{

	protected AbstractUpdateImage $service;

	public function __construct(AbstractUpdateImage $service)
	{
		$this->service = $service;	
	}

	public function handle(UpdateImageRequest $request){
		$data = $request->validated();
		$image = $data['image']->store('users');

		$user = $this->service->execute($image, auth('api')->user()->id);

		return response()->json($user, 200);
	}

}
