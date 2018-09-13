<?php

namespace Sheadawson\Select2;

use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;

/**
 * Select2Field Definition
 *
 * @package    Select2
 * @author     Shea Dawson <shea@silverstripe.com.au>
 */
class Select2Field extends DropdownField
{
    /**
     * @var int The number of items that need to appear in the dropdown
     * in order to trigger a search bar
     */
    public static $default_search_threshold = 12;

    /**
     * Sets the search threshold for this dropdown
     *
     * @param int $num The number of items
     */
    public function setSearchThreshold($num)
    {
        return $this->setAttribute('data-search-threshold', $num);
    }

    public function Field($properties = array())
    {
        Requirements::javascript('silverstripe/admin: thirdparty/jquery/jquery.js');
        Requirements::javascript('silverstripe/admin: thirdparty/jquery-entwine/dist/jquery.entwine-dist.js');
        Requirements::javascript('sheadawson/silverstripe-select2: select2/select2.js');
        Requirements::javascript('sheadawson/silverstripe-select2: javascript/ajaxselect2.init.js');
        Requirements::css('sheadawson/silverstripe-select2: select2/select2.css');
        $this->addExtraClass('select2')->addExtraClass('no-chzn');

        if (!$this->getAttribute('data-search-threshold')) {
            $this->setSearchThreshold(self::$default_search_threshold);
        }

        return parent::Field($properties);
    }
}
