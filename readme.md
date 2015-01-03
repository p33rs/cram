# Instacram

Fill your profile with images and sink them deep within the internet.

## Installation

This is gonna involve the usual suspects, as far as package managers go. Docroot is `/public`. We have an `.htaccess`
file, so make sure you've got `AllowOverrides`. Laravel, as usual, requires php-mcrypt.

1. git clone
1. composer install
1. php artisan migrate
1. npm install
1. bower install
1. ./node_modules/grunt-cli/bin/grunt
1. mkdir app/storage/uploads // should be writable

## To Do:
* Likes & Follows
  * Change "View All Photos" to "View Followed Photos"
  * Add "Discover" page and move "View All Photos" there
* CSS
* Rate Limits (uploads, comments)
* Replace Facades with something testable
* Anti-spam on registration
* Paging
* Spinners on AJAX
* Upload via modal
