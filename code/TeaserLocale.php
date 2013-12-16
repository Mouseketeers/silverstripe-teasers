<?php
class TeaserLocale extends DataObjectDecorator {
	function extraStatics() {
		return array(
			'db' => array(
				'Locale' => 'Varchar(16)',
			),
		);
	}
	function augmentSQL(SQLQuery &$query) {
		$locale = Translatable::get_current_locale();
		$where = '"Teaser"."Locale" = \''.$locale.'\'';
		$query->where[] = $where;
		// if(Subsite::$disable_subsite_filter) return;
		// $subsiteID = (int)Subsite::currentSubsiteID();
		// $where = '"Teaser"."SubsiteID" IN ('.$subsiteID.')';
		// $query->where[] = $where;
	}
	function onBeforeWrite() {
		if (!$this->owner->ID && !$this->owner->Locale) {
			$this->owner->Locale = Translatable::get_current_locale();
		}
	}
}