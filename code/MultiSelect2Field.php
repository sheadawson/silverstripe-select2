<?php

namespace Sheadawson\Select2;

use SilverStripe\Forms\ListboxField;
use SilverStripe\View\Requirements;

/**
 * MultiSelect2Field Definition
 *
 * @package    Silverstripe-Select2
 * @author     Shea Dawson <shea@silverstripe.com.au>
 */
class MultiSelect2Field extends ListBoxField
{
    public function Field($properties = array())
    {
        Requirements::javascript('silverstripe/admin: thirdparty/jquery/jquery.js');
        Requirements::javascript('silverstripe/admin: thirdparty/jquery-entwine/dist/jquery.entwine-dist.js');
        Requirements::javascript('sheadawson/silverstripe-select2: select2/select2.js');
        Requirements::javascript('sheadawson/silverstripe-select2: javascript/ajaxselect2.init.js');
        Requirements::css('sheadawson/silverstripe-select2: select2/select2.css');
        $this->addExtraClass('select2')->addExtraClass('no-chzn');

        return parent::Field($properties);
    }
}
