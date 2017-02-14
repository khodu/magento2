<?php
namespace Ktpl\Brand\Api;

use Ktpl\Brand\Model\BrandInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface BrandRepositoryInterface 
{
    public function save(TodoItemInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(TodoItemInterface $page);

    public function deleteById($id);
}
