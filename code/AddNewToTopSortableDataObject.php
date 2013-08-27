<?php
class AddNewToTopSortableDataObject extends SortableDataObject {
	public function onBeforeWrite() {
		if(!$this->owner->ID) {
			if($peers = DataObject::get($this->owner->class)) {
				if($this->owner->class == 'Teaser') {
					$this->owner->SortOrder = 0;
					foreach($peers as $peer) {
						$peer->SortOrder++;
						$peer->write(); 
					}					
				}
				else {
					$this->owner->SortOrder = $peers->Count()+1;
				}
			}
		}
	}
}