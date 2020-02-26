<?php

namespace PhpLab\Core\Libs\Store;

use PhpLab\Core\Legacy\Yii\Helpers\FileHelper;

class StoreFile
{

    private $store;
    private $file;

    public function __construct($file, $driver = null)
    {
        //parent::__construct();
        $driver = $driver ?: FileHelper::fileExt($file);
        $this->store = new Store($driver);
        $this->file = $file;
    }

    public function update($key, $value)
    {
        $this->store->update($this->file, $key, $value);
    }

    public function load($key = null)
    {
        return $this->store->load($this->file, $key);
    }

    public function save($data)
    {
        $this->store->save($this->file, $data);
    }

}