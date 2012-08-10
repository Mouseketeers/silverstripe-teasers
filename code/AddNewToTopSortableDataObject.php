<?php
class AddNewToTopSortableDataObject extends SortableDataObject {
	public function onBeforeWrite() {
		if(!$this->owner->ID) {
			if($peers = DataObject::get($this->owner->class)) {
				$this->owner->SortOrder = 0;
				foreach($peers as $peer) {
					$peer->SortOrder++;
					$peer->write(); 
				}
			}
		}
	}
}