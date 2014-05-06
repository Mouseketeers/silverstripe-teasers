<?php
class Teaser extends DataObject {
	static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'ExternalLink' => 'Varchar(255)',
		'LinkTitle' => 'Varchar(255)',
		'Global' => 'Boolean',
		'ColumnWidth' => 'Varchar',
	);
	static $has_one = array (
		'Image' => 'Image',
		'Link' => 'SiteTree'
	);
	static $belongs_many_many = array(
		'Pages' => 'Page'
	);
	public function populateDefaults() {
		$this->ColumnWidth = $this->getDefaultColumnWidth();
		parent::populateDefaults();
	}
	function getThumbnailOfTeaserImage() {
		return $this->Image()->StripThumbnail();
	}
	function getContentSummary() {
		return $this->dbObject('Content')->LimitCharacters(80);
	}
	function getGlobalSummary() {
		return $this->Global ? 'Shown on all pages' : '';
	}
	function ColumnWidth() {
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
			reset(Teasers::$column_widths);
			$default_column_width = key(Teasers::$column_widths);
		}
		return $default_column_width;
	} 
	function getCMSFields_forPopup() {
		$fields = new FieldSet();
		$fields->push(new TextField('Title', 'Title'));
		$fields->push(new FileUploadField('Image', 'Image'));
		$fields->push(new SimpleTinyMCEField('Content','Content'));
		$PageDropDown = new SimpleTreeDropdownField('LinkID', 'Link to page');
		$PageDropDown->setEmptyString('-- None --');
		$fields->push($PageDropDown);
		$fields->push(new TextField('ExternalLink', 'Link to another website'));
		$fields->push(new TextField('LinkTitle', 'Link label'));
		if(Teasers::$enable_column_width) {
			$fields->push( new DropdownField(
					$name = 'ColumnWidth',
					$title = _t('Teaser.COLUMNS','Width of teaser (in columns)'),
					$options = Teasers::$column_widths,
					$value = null,
					$form = null,
					$emptyString = 'Default'
				)
			);
		}
		if(Teasers::$enable_global_teasers) {
			$fields->push(new CheckboxField('Global', 'Show this teaser on all pages'));
		}
		$fields->push( new LiteralField('DOM-fix','<div style="height:35px">&nbsp;</div>'));
		return $fields;
	}
}
?>