<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
	/**
	 * Get all user not admin
	 *
	 * @return mixed
	 */
	public function getAllUserNotAdmin();
}
?>
