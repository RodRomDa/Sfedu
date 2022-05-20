<?php

namespace Sfedu\ShopsManage\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Name;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ImageUploader
 *
 * Provides service to save images
 */
class ImageUploader
{
    /**
     * @var Database
     */
    protected $coreFileStorageDatabase;

    /**
     * @var WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $baseTmpPath;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $allowedExtensions;

    /**
     * @var string[]
     */
    private $allowedMimeTypes;

    /**
     * @var Name
     */
    private $fileNameLookup;

    /**
     * ImageUploader constructor.
     *
     * @param Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param Name $fileNameLookup
     * @param string $baseTmpPath
     * @param string $basePath
     * @param string[] $allowedExtensions
     * @param string[] $allowedMimeTypes
     */
    public function __construct(
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        Name $fileNameLookup,
        $baseTmpPath,
        $basePath,
        $allowedExtensions,
        $allowedMimeTypes = []
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->baseTmpPath = $baseTmpPath;
        $this->basePath = $basePath;
        $this->allowedExtensions = $allowedExtensions;
        $this->allowedMimeTypes = $allowedMimeTypes;
        $this->fileNameLookup = $fileNameLookup;
    }

    /**
     * Set base tmp path
     *
     * @param string $baseTmpPath
     * @return void
     */
    public function setBaseTmpPath($baseTmpPath)
    {
        $this->baseTmpPath = $baseTmpPath;
    }

    /**
     * Set base path
     *
     * @param string $basePath
     * @return void
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Set allowed extensions
     *
     * @param string[] $allowedExtensions
     * @return void
     */
    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * Retrieve base tmp path
     *
     * @return string
     */
    public function getBaseTmpPath()
    {
        return $this->baseTmpPath;
    }

    /**
     * Retrieve base path
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Retrieve allowed extensions
     *
     * @return string[]
     */
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }

    /**
     * Retrieve path
     *
     * @param string $path
     * @param string $imageName
     * @return string
     */
    public function getFilePath($path, $imageName)
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

    /**
     * Checking file for moving and moving it
     *
     * @param string $imageName
     * @param bool $returnRelativePath
     * @return string
     *
     * @throws LocalizedException
     */
    public function moveFileFromTmp($imageName, $returnRelativePath = false)
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $basePath = $this->getBasePath();

        $baseImagePath = $this->getFilePath(
            $basePath,
            $this->fileNameLookup->getNewFileName(
                $this->mediaDirectory->getAbsolutePath(
                    $this->getFilePath($basePath, $imageName)
                )
            )
        );
        $baseTmpImagePath = $this->getFilePath($baseTmpPath, $imageName);

        try {
            $this->mediaDirectory->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (\Exception $e) {
            $this->logger->critical($e);
            throw new LocalizedException(__('Something went wrong while saving the file(s).'), $e);
        }

        return $returnRelativePath ? $baseImagePath : $imageName;
    }

    /**
     * Checking file for copying and copying it
     *
     * @param $imagePath
     * @throws LocalizedException
     */
    public function copyExistingFile($imageName, $imagePath)
    {
        $basePath = $this->getBasePath();
        $baseImagePath = $this->getFilePath(
            $basePath,
            $this->fileNameLookup->getNewFileName(
                $this->mediaDirectory->getAbsolutePath(
                    $this->getFilePath($basePath, $imageName)
                )
            )
        );

        try {
            $this->mediaDirectory->copyFile($imagePath, $baseImagePath);
        } catch (\Exception $e) {
            $this->logger->critical($e);
            throw new LocalizedException(__('Something went wrong while saving the file(s).'), $e);
        }

        return $baseImagePath;
    }

    /**
     * Checking file for save and save it to tmp dir
     *
     * @param string $fileId
     * @return string[]
     *
     * @throws LocalizedException
     */
    public function saveFileToTmpDir($fileId)
    {
        $baseTmpPath = $this->getBaseTmpPath();

        /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
        if (!$uploader->checkMimeType($this->allowedMimeTypes)) {
            throw new LocalizedException(__('File validation failed.'));
        }
        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath));
        unset($result['path']);

        if (!$result) {
            throw new LocalizedException(__('File can not be saved to the destination folder.'));
        }

        /**
         * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
         */
        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['url'] = $this->storeManager
                ->getStore()
                ->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $this->getFilePath($baseTmpPath, $result['file']);
        $result['name'] = $result['file'];

//        if (isset($result['file'])) {
//            try {
//                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
//                $this->coreFileStorageDatabase->saveFile($relativePath);
//            } catch (\Exception $e) {
//                $this->logger->critical($e);
//                throw new LocalizedException(
//                    __('Something went wrong while saving the file(s).'),
//                    $e
//                );
//            }
//        }

        return $result;
    }
}
