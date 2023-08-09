<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Iman\BetterMaintenance\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Filesystem\Driver\File as DriverFile;

class Maintenance
{
    /**
     * @var string
     */
    protected $template = 'Iman_BetterMaintenance::maintenance_page.phtml';

    /**
     * @var string
     */
    protected $baseDir = 'pub/errors/iman_maintenance/';

    /**
     * @var WriteInterface
     */
    protected $filesWrite;

    /**
     * @var File
     */
    private $file;

    /**
     * @var DriverFile
     */
    private $driverFile;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Filesystem $filesystem
     * @param File $file
     * @param Reader $reader
     * @param DriverFile $driverFile
     * @param DirectoryList $directoryList
     * @throws FileSystemException
     */
    public function __construct(
        Filesystem    $filesystem,
        File          $file,
        Reader        $reader,
        DriverFile    $driverFile,
        DirectoryList $directoryList
    ) {
        $this->filesWrite = $filesystem->getDirectoryWrite(DirectoryList::ROOT);
        $this->baseDir = rtrim('pub/errors/iman_maintenance/', '/') . '/';
        $this->file = $file;
        $this->reader = $reader;
        $this->driverFile = $driverFile;
        $this->directoryList = $directoryList;
    }

    /**
     * @return void
     * @throws FileSystemException
     */
    public function rebuild()
    {
        $this->filesSaveContentToFile();
    }

    /**
     * @return void
     * @throws FileSystemException
     */
    protected function filesSaveContentToFile()
    {
        $baseModulePath = $this->reader->getModuleDir('', 'Iman_BetterMaintenance');
        $this->filesWrite->create($this->baseDir);
        $paths = $this->driverFile->readDirectoryRecursively($baseModulePath. '/' . $this->baseDir);
        $pubDirectory = $this->directoryList->getPath(DirectoryList::PUB);
        foreach ($paths as $file) {
            $this->file->cp($file, $pubDirectory . '/errors/iman_maintenance/' . basename($file));
        }
    }

    /**
     * @param $path
     * @return void
     */
    protected function filesDeleteFile($path)
    {
        // $this->filesWrite->delete($path);
    }
}