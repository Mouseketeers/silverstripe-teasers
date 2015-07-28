<?php
class Teasers extends DataObjectDecorator {
	
	public static $enable_parent_inheritance = false;
	public static $enable_global_teasers = false;
	public static $enable_num_columns = false;
	public static $enable_column_width = false;
	public static $column_widths = array('1' => 1 ,2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11 ,12);
	public static $default_column_width;

	public static $default_num_columns;
	public static $num_columns_options = array(1 ,2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11 ,12);

	function extraStatics() {
		return array(
			'many_many' => array(
				'Teasers' => 'Teaser'
			),
			'db' => array(
				'NumTeaserColumns' => 'Varchar',
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
		};
		if(self::$enable_num_columns) {
			$fields->addFieldToTab(
				'Root.Content.Teasers', new DropdownField(
					$name = 'NumTeaserColumns',
					$title = _t('Teaser.NUMCOLUMNS','Number of teasers per row'),
					$options = self::$num_columns_options,
					$value = null,
					$form = null,
					$emptyString = 'Default'
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
	function getNumColumns() {
		$num_columns = $this->owner->NumTeaserColumns;
		if(!$num_columns) {
			$num_columns = $this->getDefaultNumColumns();
		}
		return $num_columns;
	}
	private function getDefaultNumColumns() {
		$default_num_columns = self::$default_num_columns;
		// default to first item in array if no default column width is specified
		if(!$default_num_columns) {
			reset(self::$num_columns_options);
			$default_num_columns = key(self::$num_columns_options);
		}
		return $default_num_columns;
	} 
}