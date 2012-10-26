<?php
class Teaser extends DataObject {
	static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'LinkTitle' => 'Varchar(255)'
	);
	static $has_one = array (
		'Image' => 'Image',
		'Link' => 'SiteTree'
	);
	static $belongs_many_many = array(
		'Pages' => 'Page'
	);
	function getThumbnailOfTeaserImage() {
		return $this->Image()->StripThumbnail();
	}
	function getContentSummary() {
		return $this->dbObject('Content')->LimitCharacters(80);
	}
	function getCMSFields_forPopup() {
		$fields = new FieldSet();
		$fields->push(new FileUploadField('Image', 'Image'));
		$fields->push(new TextField('Title', 'Title'));
		$fields->push(new SimpleTinyMCEField('Content','Content'));
		$PageDropDown = new SimpleTreeDropdownField('LinkID', 'Link to page');
		$PageDropDown->setEmptyString('-- None --');
		$fields->push($PageDropDown);
		$fields->push(new TextField('LinkTitle', 'Link label'));
		return $fields;
	}
}
?>