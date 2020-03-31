<?php

namespace Admin\Classes;

class MediaManager
{
    private $mediaPath = 'content/media/';
    private $datePath;
    private $file;
    private $fileUrl;

    /**
     * MediaManager constructor.
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->datePath = $this->mediaPath.date('Y').'/'.date('m').'/';
        $this->absDatePath = ABS_PATH.'/'.$this->datePath;
        $this->checkDatePath();
        $this->file = $file;
    }

    /**
     * Check if path content/media/YEAR/MONTH exists. If not, create it.
     */
    public function checkDatePath()
    {
        if (!file_exists($this->absDatePath) || !is_dir($this->absDatePath))
            mkdir($this->absDatePath, 0777, true);
    }

    /**
     * Move file to date path.
     *
     * @return bool
     */
    public function moveFile()
    {
        try {
            move_uploaded_file($this->file['tmp_name'], $this->absDatePath.$this->file['name']);
            $this->fileUrl = BASE_URL.$this->datePath.$this->file['name'];
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get file full name with extension.
     *
     * @return mixed
     */
    public function getFileFullName()
    {
        return $this->file['name'];
    }

    /**
     * Get file extension.
     *
     * @return false|string
     */
    public function getFileExtension()
    {
        return substr($this->file['name'], strpos($this->file['name'], '.')+1);
    }

    /**
     * Get file url.
     *
     * @return mixed
     */
    public function getFileUrl()
    {
        return $this->fileUrl;
    }
}