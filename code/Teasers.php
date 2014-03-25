<?php
class Teasers extends DataObjectDecorator {
	protected static $enable_parent_inheritance = true;
	protected static $enable_global_teasers = true;
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
		if(self::$enable_parent_inheritance && $this->owner->Parent()->Exists() && $this->owner->Parent()->hasExtension('Teasers')) {
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
				'ThumbnailOfTeaserImage' => _t('Teasers.THUMBNAIL','Image'),
				'GlobalSummary' => _t('Teasers.SHOW_ON_ALL_PAGES','Shown on all pages?')
			),
			'getCMSFields_forPopup'
		);
		$manager->itemClass = 'TeaserDataObjectManager_Item';
		$manager->setMarkingPermission("CMS_ACCESS_CMSMain");
		$fields->addFieldToTab('Root.Content.Teasers', $manager);
		return $fields;
	}
	function ManagedTeasers() {
		$managed_teasers = new ComponentSet();
		if($inherited_teasers = $this->owner->InheritedTeasers()) {
			$managed_teasers = $inherited_teasers;
		}
		else {
			$managed_teasers = $this->owner->Teasers();
		}
		if(self::$enable_global_teasers) {
			$global_teasers = $this->owner->GlobalTeasers();
			$managed_teasers->merge($global_teasers);
			$managed_teasers->removeDuplicates();
		}
		return $managed_teasers;
	}
	function InheritedTeasers() {
		if (self::$enable_parent_inheritance && $this->owner->InheritParentTeasers && $this->owner->Parent()->Exists() && $this->owner->Parent()->hasExtension('Teasers')) {
			return $this->owner->Parent()->Teasers();
		}
	}
	function GlobalTeasers() {
		return DataObject::get('Teaser', 'Global = 1');
	}

	public function enable_inheritance($bool) {
		self::$enable_parent_inhertiance = $bool;
	}
	public function enable_global_teasers($bool) {
		self::$enable_global_teasers = $bool;	
	}
}