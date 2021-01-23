<?php

/**
 * @author Mauricio Paz Pacheco
 * @copyright Copyright © 2020 Mpaz. All rights reserved.
 * @package Mpaz_CategoryData
 */

namespace Mpaz\HeaderCategoryPage\Model\Category;

class DataProvider extends \Magento\Catalog\Model\Category\DataProvider
{
	/**
	 * Return Fields map
	 *
	 * @return array
	 */
	protected function getFieldsMap()
	{
    	$fields = parent::getFieldsMap();
        $fields['content'][] = 'header_category_image';

    	return $fields;
	}
}
