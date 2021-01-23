<?php

/**
 * @author Mauricio Paz Pacheco
 * @copyright Copyright © 2020 Mpaz. All rights reserved.
 * @package Mpaz_HeaderCategoryPage
 */

namespace Mpaz\HeaderCategoryPage\Setup;

use \Magento\Framework\Setup\{
    ModuleContextInterface,
    ModuleDataSetupInterface,
    InstallDataInterface
};

use \Magento\Eav\Setup\EavSetupFactory;
use \Magento\Catalog\Model\Category;
use \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use \Magento\Catalog\Setup\CategorySetupFactory;

class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Construct
     *
     * @param EavSetupFactory $eavSetupFactory
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory, CategorySetupFactory $categorySetupFactory) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Create new attribute header_category_image into Category edit page
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $setup = $this->categorySetupFactory->create(['setup' => $setup]); 
        $eavSetup->addAttribute(Category::ENTITY, 'header_category_image', 
        [
            'type'     => 'varchar',
            'label'    => 'Header Category Image',
            'input'    => 'image',
            'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
            'required' => false,
            'sort_order' => 9,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Content'
        ]);
    }
}
