<?php

namespace Milhojas\Application\Management;

use League\Flysystem\FilesystemInterface;
use Milhojas\Domain\Management\PayrollReporter;

/**
 * Represents an exchange file to communicate with frontend.
 */
class PayrollProgressExchange
{
    /**
     * File name.
     *
     * @var string
     */
    private $file;
    /**
     * @var FilesystemInterface
     */
    private $filesystem;
    public function __construct($file, FilesystemInterface $filesystem)
    {
        $this->file = $file;
        $this->filesystem = $filesystem;
    }

    public function init()
    {
        $this->filesystem->put($this->file, '');
    }

    public function read()
    {
        if (!$this->filesystem->has($this->file)) {
            return '';
        }

        return $this->filesystem->read($this->file);
    }

    public function reset()
    {
        if ($this->filesystem->has($this->file)) {
            $this->filesystem->delete($this->file);
        }
    }

    public function update(PayrollReporter $reporter)
    {
        if (!$this->filesystem->has($this->file)) {
            $this->init();
        }
        $this->filesystem->put($this->file, $reporter->asJson());
    }
}
