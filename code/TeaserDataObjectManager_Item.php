<?php
class TeaserDataObjectManager_Item extends HasManyDataObjectManager_Item {
	function MarkingCheckbox() {
		$name = $this->parent->Name() . '[]';
		$disabled = $this->parent->hasMarkingPermission() ? "" : "disabled='disabled'";
		if($this->parent->IsReadOnly) {
			return "<input class=\"checkbox\" type=\"checkbox\" name=\"$name\" value=\"{$this->item->ID}\" disabled=\"disabled\"/>";
		}
		elseif($this->Global) {
			return "<input class=\"checkbox\" type=\"checkbox\" name=\"$name\" value=\"{$this->item->ID}\" disabled />";
		}
		elseif($this->item->{$this->parent->joinField}) {
			return "<input class=\"checkbox\" type=\"checkbox\" name=\"$name\" value=\"{$this->item->ID}\" checked=\"checked\" $disabled />";
		}
		else {
			return "<input class=\"checkbox\" type=\"checkbox\" name=\"$name\" value=\"{$this->item->ID}\" $disabled />";
		}
	}
}