<?php

/**
 * @author Mauricio Paz Pacheco
 * @copyright Copyright © 2020 Mpaz. All rights reserved.
 * @package Mpaz_HeaderCategoryPage
 */

namespace Mpaz\HeaderCategoryPage\Controller\Adminhtml\Category\Image;
 
use \Magento\Framework\Controller\ResultFactory;
use \Magento\Backend\App\Action\Context;
use \Magento\Catalog\Model\ImageUploader;
use \Magento\MediaStorage\Model\File\UploaderFactory;
use \Magento\Framework\Filesystem;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\MediaStorage\Helper\File\Storage\Database;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\App\Filesystem\DirectoryList;
use \Magento\Framework\Filesystem\Directory\WriteInterface;

class Upload extends \Magento\Backend\App\Action
{
    /**
     * Image uploader
     *
     * @var ImageUploader
     */
    protected $imageUploader;
 
    /**
     * Uploader factory
     *
     * @var UploaderFactory
     */
    private $uploaderFactory;
 
    /**
     * Media directory object (writable).
     *
     * @var WriteInterface
     */
    protected $mediaDirectory;
 
    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;
 
    /**
     * Core file storage database
     *
     * @var Database
     */
    protected $coreFileStorageDatabase;
 
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;
 
    /**
     * Upload constructor.
     *
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        Database $coreFileStorageDatabase,
        LoggerInterface $logger
    ) {
        parent::__construct($context);

        $this->imageUploader = $imageUploader;
        $this->uploaderFactory = $uploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->logger = $logger;
    }
 
    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mpaz_HeaderCategoryPage::category');
    }
 
    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('header_category_image');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
