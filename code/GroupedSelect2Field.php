<?php
class GroupedSelect2Field extends GroupedDropdownField
{

    public function Field($properties = array())
    {
        Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
        Requirements::javascript(THIRDPARTY_DIR . '/jquery-entwine/dist/jquery.entwine-dist.js');
        Requirements::javascript(SELECT2_MODULE . "/select2/select2.js");
        Requirements::javascript(SELECT2_MODULE . "/javascript/select2.init.js");
        Requirements::css(SELECT2_MODULE . "/select2/select2.min.css");
        $this->addExtraClass('select2')->addExtraClass('no-chzn');
        return parent::Field($properties);
    }
}
