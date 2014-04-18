<?php

/**
 * A dropdown field with ajax loaded options list, uses jquery select2
 * http://ivaynberg.github.io/select2/
 * @author shea@livesource.co.nz
 **/
class AjaxSelect2Field extends TextField{

	private static $allowed_actions = array('search');
	
	protected $config = array(
		'classToSearch' 		=> 'SiteTree',
		'searchFields' 			=> array('Title'),
		'resultsLimit' 			=> 200,
		'minimumInputLength' 	=> 2,
		'resultsFormat' 		=> '$Title',
		'selectionFormat' 		=> '$Title',
		'placeholder'			=> 'Search...'
	);


	function Field($properties = array()){
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript(THIRDPARTY_DIR . '/jquery-entwine/dist/jquery.entwine-dist.js');
		Requirements::javascript(SELECT2_MODULE . "/select2/select2.js");
		Requirements::javascript(SELECT2_MODULE . '/javascript/ajaxselect2.init.js');
		Requirements::css(SELECT2_MODULE . "/select2/select2.css");
		return parent::Field($properties);
	}


	public function search($request){
		$list = DataList::create($this->getConfig('classToSearch'));
		
		if($id = $request->getVar('id')){
			$results = $list->filter('ID', $id)->limit(1);
			$total = 1;
		}else{
			$params = array();
			$searchFields = $this->getConfig('searchFields');
			foreach($searchFields as $searchField) {
				$name = (strpos($searchField, ':') !== FALSE) ? $searchField : "$searchField:StartsWith";
				$params[$name] = $request->getVar('q');
			}	
			$start = (int)$request->getVar('id') ? (int)$request->getVar('id') * $this->getConfig('resultsLimit') : 0;
			$list = $list->filterAny($params);
			$total = $list->count();
			$results = $list->sort(strtok($searchFields[0], ':'), 'ASC')->limit($this->getConfig('resultsLimit'), $start);
		}

		$return = array(
			'list' => array(),
			'total' => $total
		);

		$originalSourceFileComments = Config::inst()->get('SSViewer', 'source_file_comments');
		Config::inst()->update('SSViewer', 'source_file_comments', false);
		foreach($results as $result) {
			$return['list'][] = array(
				'id' => $result->ID,
				'resultsContent' => html_entity_decode(SSViewer::fromString($this->getConfig('resultsFormat'))->process($result)),
				'selectionContent' => html_entity_decode(SSViewer::fromString($this->getConfig('selectionFormat'))->process($result))
			);
		}
		Config::inst()->update('SSViewer', 'source_file_comments', $originalSourceFileComments);
		return Convert::array2json($return);	
		
		
		
	}


	public function setConfig($k, $v){
		$this->config[$k] = $v;
		return $this;
	}


	public function getConfig($k){
		return isset($this->config[$k]) ? $this->config[$k] : null;
	}


	/**
	 * @return Array
	 */
	public function getAttributes() {
		return array_merge(
			parent::getAttributes(),
			array(
				'type' => 'hidden',
				'data-searchurl' => $this->Link('search'),
				'data-minimuminputlength' => $this->getConfig('minimumInputLength'),
				'data-resultslimit' => $this->getConfig('resultsLimit'),
				'data-placeholder' => $this->getConfig('placeholder')
			)
		);
	}
}