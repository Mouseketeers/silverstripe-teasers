<?php
SortableDataObject::add_sortable_class('Teaser');
if (class_exists('Subsite')) Object::add_extension('Teaser', 'TeaserSubsites');