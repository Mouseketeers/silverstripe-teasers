<?php
class Teasers extends DataObjectDecorator {
	function extraStatics() {
		return array(
			'many_many' => array(
				'Teasers' => 'Teaser'
			),
			'db' => array(
				'InheritParentTeasers' => 'Boolean'
			)
		);
	}
	function updateCMSFields(&$fields) {
		/*
		* don't want teasers on a redirector page
		*/
		if($this->owner->ClassName == 'RedirectorPage') return $fields;
		/*
		 * show inherit parent teasers option if this page has a parent with teasers 
		 */
		if($this->owner->Parent()->Exists() && $this->owner->Parent()->hasExtension('Teasers')) {
			$fields->addFieldToTab(
				'Root.Content.Teasers', new CheckboxField(
					$name = 'InheritParentTeasers',
					$title = _t('Teasers.INHERIT_PARENT_TEASERS','Show the teasers of the parent page (teasers below will not be shown)'),
					$value = 1
				)
			);
		}
		$manager = new ManyManyDataObjectManager (
			$this->owner,
			'Teasers',
			'Teaser',
			array(
				'Title' => _t('Teasers.TEASER_TITLE','Title'),
				'ContentSummary' => _t('Teasers.TEASER_CONTENT','Content'),
				'ThumbnailOfTeaserImage' => _t('Teasers.THUMBNAIL','Image')
			),
			'getCMSFields_forPopup'
		);
		$manager->setMarkingPermission("CMS_ACCESS_CMSMain");
		$fields->addFieldToTab('Root.Content.Teasers', $manager);
		
		return $fields;
	}
	/*
	 * inherit paret teasers if inherit option is selected. Otherwise show the page's own teasers.
	 */
	function ManagedTeasers(){
		if ($this->owner->InheritParentTeasers && $this->owner->Parent()->Exists() && $this->owner->Parent()->hasExtension('Teasers'))
			return $this->owner->Parent()->Teasers();
		else
			return $this->owner->Teasers();
	}
}