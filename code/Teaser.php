<?php
class Teaser extends DataObject {
	static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'ExternalLink' => 'Varchar(255)',
		'LinkTitle' => 'Varchar(255)',
		'Global' => 'Boolean',
		'ColumnWidth' => 'Varchar',
		'Active' => "Boolean",
		"SortOrder" => "Int"
	);
	static $has_one = array (
		'Image' => 'Image',
		'Link' => 'SiteTree',
		'Page' => 'Page'
	);
	static $default_sort = "SortOrder";
	static $field_labels = array(
		'Active.Nice' => 'Active'
	);

	static $summary_fields = array(
		"Thumbnail",
		"Title",
		"Active.Nice"
	);
	private static $defaults = array(
		'Active' => true
	);
	public function populateDefaults() {
		$this->ColumnWidth = $this->getDefaultColumnWidth();
		parent::populateDefaults();
	}
	public function getCMSFields(){
		$fields = new FieldList();
		$fields->push(
			new TabSet('Root', 
				new Tab('Main', 'Main')
			)
		);
		$fields->addFieldsToTab('Root.Main',
			array(
				TextField::create('Title'),
				UploadField::create('Image')
					->setTitle('Image')
					->setFolderName('Teasers')
					->setConfig('allowedMaxFileNumber', 1),
				TreeDropdownField::create('LinkID', 'Link to internal page', 'SiteTree'),
				TextField::create('ExternalLink', 'Link to external page')
					->setDescription('Include http:// (e.g. http://www.example.com)'),
				HTMLEditorField::create('Content'),
				CheckboxField::create("Active")->setTitle("Active")
			)
		);
		if(Teasers::$enable_global_teasers) {
			$fields->push(new CheckboxField('Global', 'Show this teaser on all pages'));
		}
		return $fields;
	}
	function getThumbnail() {
		if (((int) $this->ImageID > 0) && (is_a($this->Image(),'Image')))  {
			return $this->Image()->SetWidth(50);
		} else {
			return 'No image';
		}
	}
	public function HasLink() {
		$has_link = ($this->LinkID || $this->ExternalLink != '');
		return $has_link;
	}
	function getContentSummary() {
		return $this->dbObject('Content')->LimitCharacters(80);
	}
	function getGlobalSummary() {
		return $this->Global ? 'Shown on all pages' : '';
	}
	function ColumnWidth() {
		return $this->getDefaultColumnWidth();
		$column_width = $this->dbObject('ColumnWidth')->value;
		if(!$column_width) {
			$column_width = $this->getDefaultColumnWidth();
		}
		return $column_width;
	}
	private function getDefaultColumnWidth() {
		$default_column_width = Teasers::$default_column_width;
		// default to first item in array if no default column width is specified
		if(!$default_column_width) {
			// debug::dump(end(Teasers::$column_widths));
			$default_column_width = end(Teasers::$column_widths);
			// reset(Teasers::$column_widths);
			// $default_column_width = key(Teasers::$column_widths);
		}
		return $default_column_width;
	}
}
?>