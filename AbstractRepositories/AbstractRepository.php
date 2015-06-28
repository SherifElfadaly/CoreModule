<?php namespace App\Modules\Core\AbstractRepositories;

use App\Modules\Core\Interfaces\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * The model implementation.
     * 
     * @var model
     */
    public $model;

    /**
     * Create new AbstractRepository instance.
     */
    public function __construct()
    {
        $this->model = \App::make($this->getModel());
    }

    /**
     * Fetch all records with relations from the storage.
     * 
     * @param  array $columns
     * @return collection
     */
	public function all($columns = array('*'))
	{
		return call_user_func_array("{$this->getModel()}::with", array($this->getRelations()))->get($columns);
	}
    
    /**
     * Fetch all records with relations from storage in pages.
     * 
     * @param  integer $perPage
     * @param  array $columns
     * @return collection
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
    	return call_user_func_array("{$this->getModel()}::with", array($this->getRelations()))->paginate($perPage, $columns);
    }

    /**
     * Fetch all records with relations based on
     * the given condition from storage in pages.
     * 
     * @param  string $attribute condition column name
     * @param  [type] $value condition value
     * @param  integer $perPage
     * @param  array $columns
     * @return collection
     */
    public function paginateBy($attribute, $value, $perPage = 15, $columns = array('*'))
    {
        return call_user_func_array("{$this->getModel()}::with", array($this->getRelations()))->where($attribute, '=', $value)->paginate($perPage, $columns);
    }
    
    /**
     * Insert single record to the storage.
     * 
     * @param  array $data
     * @return object
     */
    public function create(array $data)
    {
    	return call_user_func_array("{$this->getModel()}::create", array($data));
    }

    /**
     * Insert multiple records to the storage.
     * 
     * @param  array $data
     * @return object
     */
    public function insert(array $data)
    {
        return call_user_func_array("{$this->getModel()}::insert", array($data));
    }
    
    /**
     * Update record in the storage based on the given
     * condition.
     * 
     * @param  [type] $value condition value
     * @param  array $data
     * @param  string $attribute condition column name
     * @return integer affected rows
     */
    public function update($value, array $data, $attribute = 'id')
    {
        if ($attribute == 'id') 
        {
            return $this->find($value)->update($data);
        }
    	return call_user_func_array("{$this->getModel()}::where", array($attribute, '=', $value))->update($data);
    }
    
    /**
     * Delete record from the storage based on the given
     * condition.
     * 
     * @param  [type] $value condition value
     * @param  string $attribute condition column name
     * @return integer affected rows
     */
    public function delete($value, $attribute = 'id')
    {
    	if ($attribute == 'id') 
    	{
    		return $this->find($value)->delete();
    	}
    	return call_user_func_array("{$this->getModel()}::where", array($attribute, '=', $value))->delete();
    }
    
    /**
     * Fetch records from the storage based on the given
     * id.
     * 
     * @param  integer $id
     * @param  array $columns
     * @return object
     */
    public function find($id, $columns = array('*'))
    {
    	return call_user_func_array("{$this->getModel()}::with", array($this->getRelations()))->find($id, $columns);
    }
    
    /**
     * Fetch records from the storage based on the given
     * condition.
     * 
     * @param  string $attribute condition column name
     * @param  [type] $value condition value
     * @param  array $colunns
     * @return collection
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
    	return call_user_func_array("{$this->getModel()}::with", array($this->getRelations()))->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Fetch the first record fro the storage based on the given
     * condition.
     * 
     * @param  string $attrinute condition column name
     * @param  [type] $value condition value
     * @param  array $colunmns
     * @return object
     */
    public function first($attribute, $value, $columns = array('*'))
    {
        $data = call_user_func_array("{$this->getModel()}::with", array($this->getRelations()))->where($attribute, '=', $value)->first($columns);
        if ($data === null) 
            return false;
        return $data;
    }

    /**
     * Abstract methods that return the necessary 
     * information (full model namespace & model relations)
     * needed to preform the previous actions.
     * 
     * @return string
     */
	abstract protected function getModel();
	abstract protected function getRelations();
}