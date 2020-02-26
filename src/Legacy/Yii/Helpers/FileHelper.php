<?php

namespace PhpLab\Core\Legacy\Yii\Helpers;

use PhpLab\Core\Enums\Measure\ByteEnum;
use PhpLab\Core\Helpers\ComposerHelper;
use PhpLab\Core\Libs\Store\StoreFile;

class FileHelper extends BaseFileHelper
{

    /*public static function path($path)
    {
        $rootDir = __DIR__ . '/../../../../../../..';
        $rootDir = realpath($rootDir);
        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');
        return $rootDir . '/' . $path;
    }*/

    public static function path(string $path = ''): string
    {
        $root = self::rootPath();
        $path = trim($path, '/');
        if($path) {
            $root .= DIRECTORY_SEPARATOR . $path;
        }
        return $root;
    }

    public static function prepareRootPath($path)
    {
        $rootDir = __DIR__ . '/../../../../../../..';
        $path = str_replace('\\', '/', $path);
        if ($path{0} == '/') {
            return $rootDir . $path;
        }
        return $path;
    }

    public static function mb_basename($name, $ds = DIRECTORY_SEPARATOR)
    {
        $name = self::normalizePath($name);
        $nameArray = explode($ds, $name);
        $name = end($nameArray);
        return $name;
    }

    public static function fileExt($name)
    {
        $name = trim($name);
        $baseName = self::mb_basename($name);
        $start = strrpos($baseName, '.');
        if ($start) {
            $ext = substr($baseName, $start + 1);
            $ext = strtolower($ext);
            return $ext;
        }
        return null;
    }

    public static function fileNameOnly($name)
    {
        $file_name = self::mb_basename($name);
        return FileHelper::fileRemoveExt($file_name);
    }

    public static function fileRemoveExt($name)
    {
        $ext = self::fileExt($name);
        $extLen = strlen($ext);
        if ($extLen) {
            return substr($name, 0, 0 - $extLen - 1);
        }
        return $name;
    }

    public static function loadData($name, $key = null, $default = null)
    {
        $store = new StoreFile($name);
        $data = $store->load($key);
        $data = ! empty($data) ? $data : $default;
        return $data;
    }

    static function getPath($name)
    {
        if (self::isAlias($name)) {
            $name = str_replace('\\', '/', $name);
            $fileName = \PhpLab\Core\Legacy\Yii\Helpers\FileHelper::getAlias($name);
        } else {
            if (self::isAbsolute($name)) {
                $fileName = $name;
            } else {
                $fileName = self::rootPath() . DIRECTORY_SEPARATOR . $name;
            }
        }
        $fileName = self::normalizePath($fileName);
        return $fileName;
    }

    public static function dirLevelUp($class, $upLevel = 1)
    {
        $class = self::normalizePath($class);
        $arr = explode(DIRECTORY_SEPARATOR, $class);
        for ($i = 0; $i < $upLevel; $i++) {
            $arr = array_splice($arr, 0, -1);
        }
        return implode(DIRECTORY_SEPARATOR, $arr);
    }

    public static function normalizeAlias($path)
    {
        if (empty($path)) {
            return $path;
        }
        $path = str_replace('\\', '/', $path);
        if ( ! self::isAlias($path)) {
            $path = '@' . $path;
        }
        return $path;
    }

    public static function pathToAbsolute($path)
    {
        $path = self::normalizePath($path);
        if (self::isAbsolute($path)) {
            return $path;
        }
        return self::rootPath() . DIRECTORY_SEPARATOR . $path;
    }

    public static function isAlias($path)
    {
        return is_string($path) && ! empty($path) && $path{0} == '@';
    }

    public static function getAlias($path)
    {
        if (self::isAlias($path)) {
            $path = self::normalizeAlias($path);

            $dir = ComposerHelper::getPsr4Path($path);

            /*if (class_exists('Yii')) {
                $dir = \PhpLab\Core\Legacy\Yii\Helpers\FileHelper::getAlias($path);
            } else {
                $path = trim($path, '@/\\');
                if ($pos = strpos($path, 'root') === 0) {
                    $path = substr($path, 4);
                }
                $dir = self::rootPath() . DIRECTORY_SEPARATOR . $path;
            }*/
        } else {
            $dir = self::pathToAbsolute($path);
        }
        return self::normalizePath($dir);
    }

    public static function findInFileByExp($file, $search, $returnIndex = null)
    {
        $content = self::load($file);
        $finded = [];
        preg_match_all("/{$search}/", $content, $out);
        if ( ! empty($out[0])) {
            if ($returnIndex === null) {
                $item = $out;
            } else {
                $item = $out[$returnIndex];
            }
            $finded[] = $item;
        }
        return $finded;
    }

    public static function remove($path)
    {
        $path = self::pathToAbsolute($path);
        if (is_dir($path)) {
            FileHelper::removeDirectory($path);
            return true;
        } elseif (is_file($path)) {
            unlink($path);
            return true;
        }
        return false;
    }

    public static function isAbsolute($path)
    {
        $pattern = '[/\\\\]|[a-zA-Z]:[/\\\\]|[a-z][a-z0-9+.-]*://';
        return (bool) preg_match("#$pattern#Ai", $path);
    }

    public static function rootPath()
    {
        return self::up(__DIR__, 7);
    }

    public static function trimRootPath($path)
    {
        if ( ! self::isAbsolute($path)) {
            return $path;
        }
        $rootLen = strlen(self::rootPath());
        return substr($path, $rootLen + 1);
    }

    public static function up($dir, $level = 1)
    {
        $dir = self::normalizePath($dir);
        $dir = rtrim($dir, DIRECTORY_SEPARATOR);
        for ($i = 0; $i < $level; $i++) {
            $dir = dirname($dir);
        }
        return $dir;
    }

    public static function isEqualContent($sourceFile, $targetFile)
    {
        return self::load($sourceFile) === self::load($targetFile);
    }

    public static function copy($sourceFile, $targetFile, $dirAccess = 0777)
    {
        $sourceData = FileHelper::load($sourceFile);
        FileHelper::save($targetFile, $sourceData, null, null, $dirAccess);
    }

    public static function touch($fileName, $data = null, $flags = null, $context = null, $dirAccess = 0777)
    {
        $fileName = self::normalizePath($fileName);
        if ( ! file_exists($fileName)) {
            self::save($fileName, $data, $flags, $context, $dirAccess);
        }
    }

    public static function save($fileName, $data, $flags = null, $context = null, $dirAccess = 0777)
    {
        $fileName = self::normalizePath($fileName);
        $dirName = dirname($fileName);
        if ( ! is_dir($dirName)) {
            self::createDirectory($dirName, $dirAccess);
        }
        return file_put_contents($fileName, $data, $flags, $context);
    }

    public static function load($fileName, $flags = null, $context = null, $offset = null, $maxLen = null)
    {
        $fileName = self::normalizePath($fileName);
        if ( ! self::has($fileName)) {
            return null;
        }
        return file_get_contents($fileName, $flags, $context, $offset);
    }

    public static function has($fileName)
    {
        $fileName = self::normalizePath($fileName);
        return is_file($fileName) || is_dir($fileName);
    }

    public static function normalizePathList($list)
    {
        foreach ($list as &$path) {
            $path = self::normalizePath($path);
        }
        return $list;
    }

    public static function scanDir($dir, $options = null)
    {
        if ( ! self::has($dir)) {
            return [];
        }
        $pathList = scandir($dir);
        ArrayHelper::removeByValue('.', $pathList);
        ArrayHelper::removeByValue('..', $pathList);
        if (empty($pathList)) {
            return [];
        }
        if ( ! empty($options)) {
            $pathList = self::filterPathList($pathList, $options, $dir);
        }
        sort($pathList);
        return $pathList;
    }

    public static function filterPathList($pathList, $options, $basePath = null)
    {
        if (empty($pathList)) {
            return $pathList;
        }
        $result = [];
        if ( ! empty($options)) {
            if ( ! isset($options['basePath']) && ! empty($basePath)) {
                $options['basePath'] = realpath($basePath);
            }
        }
        $options = self::normalizeOptions($options);
        foreach ($pathList as $path) {
            if (static::filterPath($path, $options)) {
                $result[] = $path;
            }
        }
        return $result;
    }

    public static function sizeUnit(int $sizeByte)
    {
        $units = ByteEnum::allUnits();
        foreach ($units as $name => $value) {
            if ($sizeByte / $value < ByteEnum::STEP) {
                return $name;
            }
        }
    }

    public static function sizeFormat(int $sizeByte, $precision = 2)
    {
        $unitKey = self::sizeUnit($sizeByte);
        $size = $sizeByte / ByteEnum::getValue($unitKey);
        $size = round($size, $precision);
        return $size . ' ' . $unitKey;
    }

    public static function dirFromTime($level = 3, $time = null)
    {
        $time = $time ? $time : time();
        if ($level >= 1) $format[] = 'Y';
        if ($level >= 2) $format[] = 'm';
        if ($level >= 3) $format[] = 'd';
        if ($level >= 4) $format[] = 'H';
        if ($level >= 5) $format[] = 'i';
        if ($level >= 6) $format[] = 's';
        $name = date(implode('/', $format), $time);
        $name = self::normalizePath($name);
        return $name;
    }

    public static function fileFromTime($level = 5, $time = null, $delimiter = '.', $delimiter2 = '_')
    {
        $time = $time ? $time : time();
        $format = '';
        if ($level >= 1) $format .= 'Y';
        if ($level >= 2) $format .= $delimiter . 'm';
        if ($level >= 3) $format .= $delimiter . 'd';
        if ($level >= 4) $format .= $delimiter2 . 'H';
        if ($level >= 5) $format .= $delimiter . 'i';
        if ($level >= 6) $format .= $delimiter . 's';
        $name = date($format, $time);
        return $name;
    }

    public static function findFilesWithPath($source_dir, $directory_depth = 0, $hidden = FALSE, $empty_dir = false)
    {
        if (empty($source_dir)) {
            $source_dir = '.';
        }
        static $source_dir1;
        if ( ! isset($source_dir1)) {
            $source_dir1 = $source_dir;
        }
        if ( ! file_exists($source_dir) || ! is_dir($source_dir)) {
            return false;
        }
        if ($fp = @opendir($source_dir)) {
            $fileList = [];
            $new_depth = $directory_depth - 1;
            $source_dir = rtrim($source_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            while (FALSE !== ($file = readdir($fp))) {
                // Remove '.', '..', and hidden files [optional]
                if ( ! trim($file, '.') OR ($hidden == FALSE && $file[0] == '.')) {
                    continue;
                }
                $dd = substr($source_dir, mb_strlen($source_dir1));
                $dd = ltrim($dd, DIRECTORY_SEPARATOR);
                if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir . $file)) {
                    $dir_cont = self::findFilesWithPath($source_dir . $file . DIRECTORY_SEPARATOR, $new_depth, $hidden, $empty_dir);
                    if ( ! empty($dir_cont)) {
                        $fileList = array_merge($fileList, $dir_cont);
                    } else {
                        if ($empty_dir) {
                            $fileList[] = $dd . $file . DIRECTORY_SEPARATOR;
                        }
                    }
                } else {

                    if (@is_dir($source_dir . $file)) {
                        $fileList[] = $dd . $file;
                    } else {
                        $fileList[] = $dd . $file;
                    }
                }
            }
            closedir($fp);
            sort($fileList);
            return $fileList;
        }
        return FALSE;
    }

}
