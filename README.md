# SilverStripe Teaser Module
Module for adding teasers to pages. Teasers can consist of title, text, images and links to other pages


## Maintainer Contact
* Henrik Olsen
  <Henrik (at) mouseketeers (dot) dk>

## Requirements
* Silverstripe 3.1

## Installation Instructions

Put the teasers folder inside your project

To enable the teasers on all pages, add the following to your mysite/_config/config.yml file:

Page:
  extensions:
    - Teasers

4. Build the database (e.g. http://localhost/mysite/dev/build)

5. Include the teasers in your templates by adding <% include ManagedTeasers %>

