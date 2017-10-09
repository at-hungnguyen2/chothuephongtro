<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BeforeUpdate
{
	public function scopeUpdateNotNull(Builder $query, $data)
	{
		foreach ($data as $key => $value) {
			if (!$value) {
				unset($data[$key]);
			}
		}
		if ($data) {
			$id = $data['id'];
			unset($data['id']);
			return $query->where('id', $id)->update($data);
		}
	}
}
?>
