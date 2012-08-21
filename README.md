# SilverStripe Teaser Module
Module for adding teasers to pages. Teasers can consist of title, text, images and links to other pages


## Maintainer Contact
* Henrik Olsen
  <Henrik (at) mouseketeers (dot) dk>

## Requirements
* Silverstripe 2.4
* DataObjectManager < http://silverstripe.org/dataobjectmanager-module/ >
* Uploadify < http://silverstripe.org/uploadify-module/ >

## Installation Instructions
1. Install DataObjectManager < http://silverstripe.org/dataobjectmanager-module/ > and Uploadify < http://silverstripe.org/uploadify-module/ >

2. Put the teasers folder inside your project

3. To enable the teasers on all pages, add the following to your mysite/_config.php file:

DataObject::add_extension('Page', 'Teasers');

To enable teasers on specific pages, for example your home page, add the following to your mysite/_config.php file:

DataObject::add_extension('HomePage', 'Teasers');

4. Build the database (e.g. http://localhost/mysite/dev/build)

5. Include the slideshow in your templates by adding <% include Teasers %>

