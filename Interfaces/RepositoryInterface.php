<?php namespace App\Modules\Core\Interfaces;

interface RepositoryInterface
{
	/**
     * Fetch all records with relations from the storage.
     * 
     * @param  array $columns
     * @return collection
     */
	public function all($columns = array('*'));
 	
	/**
     * Fetch all records with relations from storage in pages.
     * 
     * @param  integer $perPage
     * @param  array $columns
     * @return collection
     */
    public function paginate($perPage = 15, $columns = array('*'));
 	
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
    public function paginateBy($attribute, $value, $perPage = 15, $columns = array('*'));

    /**
     * Insert single record to the storage.
     * 
     * @param  array $data
     * @return object
     */
    public function create(array $data);
 	
    /**
     * Insert multiple records to the storage.
     * 
     * @param  array $data
     * @return object
     */
    public function insert(array $data);

	/**
     * Update record in the storage based on the given
     * condition.
     * 
     * @param  [type] $value condition value
     * @param  array $data
     * @param  string $attribute condition column name
     * @return integer affected rows
     */
    public function update($value, array $data, $attribute = 'id');
 	
	/**
     * Delete record from the storage based on the given
     * condition.
     * 
     * @param  [type] $value condition value
     * @param  string $attribute condition column name
     * @return integer affected rows
     */
    public function delete($value, $attribute = 'id');
 	
	/**
     * Fetch records from the storage based on the given
     * id.
     * 
     * @param  integer $id
     * @param  array $columns
     * @return object
     */
    public function find($id, $columns = array('*'));
 	
	/**
     * Fetch records from the storage based on the given
     * condition.
     * 
     * @param  string $attribute condition column name
     * @param  [type] $value condition value
     * @param  array $colunns
     * @return collection
     */
    public function findBy($attribute, $value, $columns = array('*'));

    /**
     * Fetch the first record fro the storage based on the given
     * condition.
     * 
     * @param  string $attrinute condition column name
     * @param  [type] $value condition value
     * @param  array $colunmns
     * @return object
     */
    public function first($attribute, $value, $columns = array('*'));
}