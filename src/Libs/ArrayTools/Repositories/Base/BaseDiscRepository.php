<?php

namespace PhpLab\Core\Libs\ArrayTools\Repositories\Base;

use PhpLab\Core\Legacy\Yii\Helpers\FileHelper;
use php7rails\domain\repositories\BaseRepository;
use PhpLab\Core\Libs\Store\Store;

abstract class BaseDiscRepository extends BaseRepository
{

    public $table;
    public $format = 'php';
    public $path = '@common/data';
    public $readonly = false;
    private $collection;
    private $store;

    protected function getCollection()
    {
        if ( ! isset($this->collection)) {
            $this->loadCollection();
        }
        return $this->collection;
    }

    protected function setCollection(Array $collection)
    {
        $this->collection = $collection;
        $this->saveCollection();
    }

    private function loadCollection()
    {
        $fileName = $this->getFileName();
        $store = $this->getStore();
        $data = $store->load($fileName);
        if ( ! empty($data)) {
            $this->collection = $this->alias->decode($data);
        }
        if ( ! is_array($this->collection) || empty($this->collection)) {
            $this->collection = [];
        }
    }

    private function saveCollection()
    {
        if ($this->readonly) {
            return;
        }
        $data = $this->alias->encode($this->collection);
        $data = array_values($data);
        $fileName = $this->getFileName();
        $store = $this->getStore();
        $store->save($fileName, $data);
    }

    private function getDbDir()
    {
        return FileHelper::getAlias($this->path);
    }

    private function getFileName()
    {
        $dir = $this->getDbDir();
        return $dir . DIRECTORY_SEPARATOR . $this->table . '.' . $this->format;
    }

    private function getStore()
    {
        if ( ! isset($this->store)) {
            $this->store = new Store($this->format);
        }
        return $this->store;
    }

}