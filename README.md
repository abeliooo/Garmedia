## About Garmedia
Garmedia is a website to buy book you like, inspired by Gramedia.com (It's for my learning purpose)
I'm focusing on learning CRUD such as search book base on the title, or author or by the catrgory

## What In This Web
1. CRUD for admin page, you can put the book you want to sell to the user by putting all the criteria
2. CRUD for user, you can search and buy book you like base on title, author or category

## How To Access Admin Or User?
You can login for admin by admin@garmedia.com with password 'admin123'
Or as user by user@email.com with password '1123411234'

## What I Use To Build This Code?
Because I want to learn the plain Laravel such as how it work, I only use Html, Bootstrap, JS

## Note
In this web, I didn't put the cover image in asset, I put it in the storage/public/temp-covers
If you want to use just extract covers.zip and put it in the temp-covers, then do 
php artisan migrate:fresh --seed
Always repeat this step whenever you want to migrate the database
### Why I Use This Method
I use this method because in the real time scenario we don't put the covers in assets because it will make the web become heavier (If you don't want to use this method just put it in the assets)