<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Permission
{
	public function permission($id, $data)
	{
		if ($data->user_id === $id) {
			return true;
		} else {
			return false;
		}
	}
}
?>
