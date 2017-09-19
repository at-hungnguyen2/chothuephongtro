<?php
namespace App\Repositories\User;

use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
	/**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\User::class;
    }

    /**
     * Get all posts only published
     * @return mixed
     */
    public function getAllUserNotAdmin()
    {
        $result = $this->_model->where('is_admin', 0)->paginate($this->_model->ITEMS_PER_PAGE);
        return $result;
    }
}
?>
