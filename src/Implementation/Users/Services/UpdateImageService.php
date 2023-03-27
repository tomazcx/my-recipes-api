<?php

namespace Src\Implementation\Users\Services;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractUpdateImage;
use Src\Implementation\Common\Error\NotFoundError;

class UpdateImageService extends AbstractUpdateImage{


	protected AbstractUserRepository $userRepository;

	public function __construct(AbstractUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function execute(string $image, int $id): AbstractUser
	{
		$userExists = $this->userRepository->exists($id);

		if(!$userExists){
			Storage::delete($image);
			throw new NotFoundError('Usuário não encontrado');
		}

		$userData = $this->userRepository->show($id);

		if($userData->image != null){
			Storage::delete($userData->image);
		}

		$user = $this->userRepository->updateImage($image, $id);

		return $user;
	}

}
