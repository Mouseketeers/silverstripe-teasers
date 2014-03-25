<?php
class TeaserLocale extends DataObjectDecorator {
	function extraStatics() {
		return array(
			'db' => array(
				'Locale' => 'Varchar(16)'
			),
		);
	}
	// filter teasers by locale
	function augmentSQL(SQLQuery &$query) {
		if(is_subclass_of(Controller::curr(), "LeftAndMain") || isset($_POST['record-Form_EditForm_Teasers'])) {
			// dirty session fix for maintaning locale for ajax calls in the CMS
			if(isset($_GET['locale'])) {
				$locale = $_GET['locale'];
				Session::set('locale', $locale);
			} 
			else {
				$locale = Session::get('locale');
			}
		}
		else {
			$locale = Translatable::get_current_locale();
		}
		$where = '"Teaser"."Locale" = \''.$locale.'\'';
		$query->where[] = $where;
	}
	function onBeforeWrite() {
		if (!$this->owner->ID && !$this->owner->Locale) {
			$this->owner->Locale = Translatable::get_current_locale();
		}
	}
}