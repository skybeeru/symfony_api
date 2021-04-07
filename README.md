# Simple REST API

This is a simple REST API application that can save images to local storage, makes preview images (small square and medium thumbnail), and store the filename and resolution in the database

## Installation

Clone or extract source code to your instance.

Use the package manager [composer](https://getcomposer.org/) to install application.

```bash
cd project-folder/
composer install
```
After that create your own .env.local file and set up the database connection. Examples you can find in the .env file.

When the database connection configured run the next commands
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
Set up your web server/host to the public folder and that's it. We are ready.

## Usage
This application has few endpoints:
```http request
GET /api/images
```
Will return a list of all images in fromat [url, width, height]

```http request
GET /api/fails
```
Will return a list of all fails

```http request
POST /api/images
```
Will upload files from request.
There is two available formats to send data:
### 1) multipart/form-data
Filed name should be "images[]"

### 2) application/json
```json
{
	"type" : "",
	"images" : [
		{
			"name" : "",
			"content" : ""		
		},
		{
			"name" : "",
			"content" : ""	
		},
	]
}
```
Type can be "base64" or "url". Depends on the type value for content filed should be base64 converted image or valid url.
```http request
DELETE /api/image/{filename}
```
Will delete an image from the database and from the local storage. 