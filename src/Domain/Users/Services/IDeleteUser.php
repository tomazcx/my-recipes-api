<?php

namespace Src\Domain\Users\Services;

interface IDeleteUser{

	public function execute(int $id):void;
	
}
