<?php
class Teasers extends DataExtension {
	
	public static $enable_parent_inheritance = false;
	public static $enable_global_teasers = false;
	public static $enable_num_columns = false;
	public static $enable_column_width = false;
	public static $column_widths = array(1 ,2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11 ,12);
	public static $default_column_width;
	public static $default_num_columns;
	public static $num_columns_options = array(1 ,2 ,3 ,4 ,5 ,6 ,7 ,8 ,9 ,10 ,11 ,12);

	public static $has_many = array(
		'Teasers' => 'Teaser'
	);
	public static $db = array(
		'NumTeaserColumns' => 'Varchar',
		'InheritParentTeasers' => 'Boolean'
	);
	public function updateCMSFields(FieldList $fields) {
		$gridField = new GridField("Teasers", "Teasers", $this->owner->Teasers());
		$config = GridFieldConfig_RecordEditor::create();
		$config->addComponent(new GridFieldOrderableRows("SortOrder"));
		$gridField->setConfig($config);
		$fields->addFieldToTab("Root.Teasers", $gridField);
		return $fields;
	}
	public function ManagedTeasers() {
		$managed_teasers = null;
		if(self::$enable_parent_inheritance && $inherited_teasers = $this->owner->InheritedTeasers()) {
			$managed_teasers = $inherited_teasers;
		}
		else {
			$managed_teasers = $this->owner->Teasers()->filter('Active', true);
		}
		if(self::$enable_global_teasers) {
			$global_teasers = $this->owner->GlobalTeasers();
			$managed_teasers->merge($global_teasers);
			$managed_teasers->removeDuplicates();
		}
		return $managed_teasers;
	}
	public function InheritedTeasers() {
		if ($this->owner->InheritParentTeasers && $this->owner->Parent()->Exists() && $this->owner->Parent()->hasExtension('Teasers')) {
			return $this->owner->Parent()->ManagedTeasers();
		}
	}
	public function GlobalTeasers() {
		return DataObject::get('Teaser', 'Global = 1');
	}
	public function getNumColumns() {
		$num_columns = $this->owner->NumTeaserColumns;
		if(!$num_columns) {
			$num_columns = $this->getDefaultNumColumns();
		}
		return $num_columns;
	}
	private function getDefaultNumColumns() {
		return self::$default_num_columns ? self::$default_num_columns : 1;
	}
}