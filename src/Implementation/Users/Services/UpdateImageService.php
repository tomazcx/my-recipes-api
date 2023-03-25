<?php

namespace Src\Implementation\Users\Services;

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
			throw new NotFoundError('Usuário não encontrado');
		}

		$user = $this->userRepository->updateImage($image, $id);

		return $user;
	}

}
