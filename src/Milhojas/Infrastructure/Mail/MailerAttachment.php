<?php

namespace Milhojas\Infrastructure\Mail;

class MailerAttachment
{
    private $filename;
    private $type;
    private $data;
    private $path;

    private function __construct($filename, $type, $data, $path)
    {
        $this->filename = $filename;
        $this->type = $type;
        $this->data = $data;
        $this->path = $path;
    }

    public static function fromPath($path)
    {

        $mailerAttachment = new MailerAttachment(basename($path), '', '', $path);


        return $mailerAttachment;
    }

    public static function inline($filename, $type, $data)
    {
        $mailerAttachment = new MailerAttachment($filename, $type, $data, '');


        return $mailerAttachment;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        if ($this->path) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
            $this->type = finfo_file($finfo, $this->path);
            finfo_close($finfo);
        }

        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        if (!$this->data && $this->path) {
            $this->data = file_get_contents($this->path);
        }

        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

}
