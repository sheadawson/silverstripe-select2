<?php

namespace Sheadawson\Select2;

use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Convert;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;
use SilverStripe\Core\Manifest\ModuleLoader;
use Page;

/**
 * A dropdown field with ajax loaded options list, uses jquery select2
 * http://ivaynberg.github.io/select2/
 * @author shea@livesource.co.nz
 **/
class AjaxSelect2Field extends TextField
{
    private static $allowed_actions = array('search');

    protected $config = array(
        'classToSearch' => 'SiteTree',
        'searchFields' => array('Title'),
        'resultsLimit' => 200,
        'minimumInputLength' => 2,
        'resultsFormat' => '$Title',
        'selectionFormat' => '$Title',
        'placeholder' => 'Search...',
        'excludes' => array(),
        'filter' => array(),
        'multiple' => false,
    );

    public function Field($properties = array())
    {
        Requirements::javascript('silverstripe/admin: thirdparty/jquery/jquery.js');
        Requirements::javascript('silverstripe/admin: thirdparty/jquery-entwine/dist/jquery.entwine-dist.js');
        Requirements::javascript('sheadawson/silverstripe-select2: select2/select2.js');
        Requirements::javascript('sheadawson/silverstripe-select2: javascript/ajaxselect2.init.js');
        Requirements::css('sheadawson/silverstripe-select2: select2/select2.min.css');

        return parent::Field($properties);
    }

    public function search($request)
    {
        $list = DataList::create($this->getConfig('classToSearch'));

        $params = [];
        $searchFields = $this->getConfig('searchFields');

        foreach ($searchFields as $searchField) {
            $name = (strpos($searchField, ':') !== false) ? $searchField : "$searchField:PartialMatch";
            $params[$name] = $request->getVar('term');
        }
        $start = (int)$request->getVar('id') ? (int)$request->getVar('id') * $this->getConfig('resultsLimit') : 0;

        $list = $list->filterAny($params)->exclude($this->getConfig('excludes'));
        $filter = $this->getConfig('filter');
        if (count($filter) > 0) {
            $list = $list->filter($filter);
        }
        $total = $list->count();
        $results = $list->sort(strtok($searchFields[0], ':'), 'ASC')->limit($this->getConfig('resultsLimit'), $start);

        $return = array(
            'list' => array(),
            'total' => $total
        );

        $originalSourceFileComments = Config::inst()->get('SSViewer', 'source_file_comments');
        Config::inst()->update('SSViewer', 'source_file_comments', false);
        foreach ($results as $object) {
            $return['list'][] = array(
                'id' => $object->ID,
                'resultsContent' => html_entity_decode(SSViewer::fromString($this->getConfig('resultsFormat'))->process($object)),
                'selectionContent' => SSViewer::fromString($this->getConfig('selectionFormat'))->process($object)
            );
        }
        Config::inst()->update('SSViewer', 'source_file_comments', $originalSourceFileComments);

        return Convert::array2json($return);
    }

    public function setConfig($k, $v)
    {
        $this->config[$k] = $v;

        return $this;
    }

    public function getConfig($k)
    {
        return isset($this->config[$k]) ? $this->config[$k] : null;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $attributes = array_merge(
            parent::getAttributes(),
            array(
                'type' => 'hidden',
                'data-searchurl' => $this->Link('search'),
                'data-minimuminputlength' => $this->getConfig('minimumInputLength'),
                'data-resultslimit' => $this->getConfig('resultsLimit'),
                'data-placeholder' => $this->getConfig('placeholder'),
                'data-multiple' => $this->getConfig('multiple')
            )
        );

        if ($this->Value() && $object = DataObject::get($this->getConfig('classToSearch'))->byID($this->Value())) {
            $originalSourceFileComments = Config::inst()->get('SSViewer', 'source_file_comments');
            Config::inst()->update('SSViewer', 'source_file_comments', false);
            $attributes['data-selectioncontent'] = html_entity_decode(SSViewer::fromString($this->getConfig('selectionFormat'))->process($object));
            Config::inst()->update('SSViewer', 'source_file_comments', $originalSourceFileComments);
        }

        return $attributes;
    }
}
