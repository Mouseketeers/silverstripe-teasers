<?php
/*
To add tasers to all pages include the follwoing in your mysite/_config.php 
DataObject::add_extension('Page', 'Teasers');
*/
//SortableDataObject::add_sortable_many_many_relation('Page', 'Teasers');

SortableDataObject::add_sortable_class('Teaser');

/*SimpleTinyMCEField::set_default_buttons(array(
'cut,paste,undo,|,formatselect,styleselect,|,bold,|,justifyleft,justifyright,|,code'
));*/
?>