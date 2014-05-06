<?php
class Teasers extends DataObjectDecorator {
	
	public static $enable_parent_inheritance = false;
	public static $enable_global_teasers = false;
	public static $enable_column_width = false;
	public static $column_widths = array('1' => 1 ,2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11 ,12);
	public static $default_column_width;

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
		if(self::$enable_parent_inheritance && $this->owner->Parent()->Exists() && $this->owner->Parent()->hasExtension('Teasers')) {
			$fields->addFieldToTab(
				'Root.Content.Teasers', new CheckboxField(
					$name = 'InheritParentTeasers',
					$title = _t('Teasers.INHERIT_PARENT_TEASERS','Show the teasers of the parent page (teasers selected below will not be shown)'),
					$value = 1
				)
			);
		}
		$manager_summaries = array(
			'Title' => _t('Teasers.TEASER_TITLE','Title'),
			'ContentSummary' => _t('Teasers.TEASER_CONTENT','Content'),
			'ThumbnailOfTeaserImage' => _t('Teasers.THUMBNAIL','Image')
		);
		if(self::$enable_global_teasers) {
			$manager_summaries['GlobalSummary'] = _t('Teasers.SHOW_ON_ALL_PAGES','Shown on all pages?');
		}
		$manager = new ManyManyDataObjectManager (
			$this->owner,
			'Teasers',
			'Teaser',
			$manager_summaries,
			'getCMSFields_forPopup'
		);
		$manager->itemClass = 'TeaserDataObjectManager_Item';
		$manager->setMarkingPermission("CMS_ACCESS_CMSMain");
		$fields->addFieldToTab('Root.Content.Teasers', $manager);
		return $fields;
	}
	function ManagedTeasers() {
		$managed_teasers = new ComponentSet();
		if(self::$enable_parent_inheritance && $inherited_teasers = $this->owner->InheritedTeasers()) {
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
		if ($this->owner->InheritParentTeasers && $this->owner->Parent()->Exists() && $this->owner->Parent()->hasExtension('Teasers')) {
			return $this->owner->Parent()->Teasers();
		}
	}
	function GlobalTeasers() {
		return DataObject::get('Teaser', 'Global = 1');
	}
}