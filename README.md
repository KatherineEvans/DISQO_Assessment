# DISQO Assessment

> A simple Laravel "notes" API!

## To Run Locally

SSH:

```bash
git clone git@github.com:KatherineEvans/DISQO_Assessment.git
```

HTTPS:

```bash
git clone https://github.com/KatherineEvans/DISQO_Assessment.git
```

Install framework dependencies:

```bash
npm install
composer install
```

Create and seed local database:
> create .env file if one does not already exist and create and copy .env.example  
> Ensure you populate DB_DATABASE  
> > DB_DATABASE=[*insert your demo db name*]  

```bash
#generate app key
php artisan key:generate

#sign in to MySQL and create db
mysql -u root -p
CREATE DATABASE [insert your demo db name];  

#exit MySQL, migrate and populate your database
php artisan migrate:fresh --seed
```

Serve:
```bash
php artisan serve

# will now run on http://127.0.0.1:8000
```

# REST API Usage
The user has two options for testing out the API: 
 - Utilize an API testing tool (ex: Postman)
 - Utilize provided cURL commands

Please start by generating a test user and obtaining a Bearer token:
```bash
php artisan generate:api_test_user {example email}

# Command will create a new user and return a Bearer token
```

## cURL

### GET list of Notes 
> scoped by user  

#### REQUEST:
`GET /api/notes`
```
curl -i -H "Authorization: Bearer <generated bearer token>" http://127.0.0.1:8000/api/notes
```
> Example with "title" parameter:
> ```
>curl -i -H "Authorization: Bearer <generated bearer token>" -d -X http://127.0.0.1:8000/api/notes -d 'title=Example Note'
> ```
#### RESPONSE:
```
HTTP/1.1 200 OK
Host: 127.0.0.1:8000
Date: Sun, 26 Sep 2021 19:34:22 GMT
Connection: close
X-Powered-By: PHP/8.0.10
Cache-Control: no-cache, private
Date: Sun, 26 Sep 2021 19:34:22 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{"data":[{"id":14,"user_id":5,"title":"Spider-Man: No Way Home","note":"Spider-Man's identity is revealed to everyone, and he can no longer separate his normal life from his superhero life. When he asks Doctor Strange for help, it forces him to discover what it means to be him.","created_at":"2021-09-26T18:53:26.000000Z","updated_at":"2021-09-26T18:53:26.000000Z","deleted_at":null},{"id":15,"user_id":5,"title":"Shang-Chi and the Legend of the Ten Rings","note":"Martial-arts master Shang-Chi confronts the past he thought he left behind when he's drawn into the web of the mysterious Ten Rings organization.","created_at":"2021-09-26T18:54:49.000000Z","updated_at":"2021-09-26T18:54:49.000000Z","deleted_at":null}]}
```

##

### CREATE new Note 

#### REQUEST:
`POST /api/notes`
```
curl -i -H "Authorization: Bearer <generated bearer token>" -d "title=Example Title&note=Example Note" -X POST http://127.0.0.1:8000/api/notes
```
#### RESPONSE:
```
HTTP/1.1 200 OK
Host: 127.0.0.1:8000
Date: Sun, 26 Sep 2021 19:47:24 GMT
Connection: close
X-Powered-By: PHP/8.0.10
Cache-Control: no-cache, private
Date: Sun, 26 Sep 2021 19:47:24 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 58
Access-Control-Allow-Origin: *

{"data":{"title":"Example Title","note":"Example Note","user_id":5,"updated_at":"2021-09-26T19:47:24.000000Z","created_at":"2021-09-26T19:47:24.000000Z","id":17}}
```
##

### GET single Note
> scoped by user

#### REQUEST:
`GET /api/notes/{id}`
```
curl -i -H "Authorization: Bearer <generated bearer token>" http://127.0.0.1:8000/api/notes/{id}
```

#### RESPONSE:
```
HTTP/1.1 200 OK
Host: 127.0.0.1:8000
Date: Sun, 26 Sep 2021 19:58:16 GMT
Connection: close
X-Powered-By: PHP/8.0.10
Cache-Control: no-cache, private
Date: Sun, 26 Sep 2021 19:58:16 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 58
Access-Control-Allow-Origin: *

{"data":{"id":14,"user_id":5,"title":"Spider-Man: No Way Home","note":"Spider-Man's identity is revealed to everyone, and he can no longer separate his normal life from his superhero life. When he asks Doctor Strange for help, it forces him to discover what it means to be him.","created_at":"2021-09-26T18:53:26.000000Z","updated_at":"2021-09-26T18:53:26.000000Z","deleted_at":null}}
```
##

### UPDATE Note
> scoped by user

#### REQUEST:
`PUT /api/notes/{id}`
```
curl -i -H "Authorization: Bearer <generated bearer token>" -X PUT -d 'title=New Title' -d 'note=New Note' http://127.0.0.1:8000/api/notes/{id}
```
#### RESPONSE:
```
HTTP/1.1 200 OK
Host: 127.0.0.1:8000
Date: Sun, 26 Sep 2021 20:06:45 GMT
Connection: close
X-Powered-By: PHP/8.0.10
Cache-Control: no-cache, private
Date: Sun, 26 Sep 2021 20:06:45 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 58
Access-Control-Allow-Origin: *

{"data":{"id":22,"user_id":5,"title":"New Title","note":"New Note","created_at":"2021-09-26T20:06:08.000000Z","updated_at":"2021-09-26T20:06:45.000000Z","deleted_at":null}}
```
##

### DELETE Note
> scoped by user

#### REQUEST:
`DELETE /api/notes/{id}`
```
curl -i -H "Authorization: Bearer <generated bearer token>" -X "DELETE" http://127.0.0.1:8000/api/notes/{id}
```
#### RESPONSE:
```
HTTP/1.1 200 OK
Host: 127.0.0.1:8000
Date: Sun, 26 Sep 2021 20:01:41 GMT
Connection: close
X-Powered-By: PHP/8.0.10
Cache-Control: no-cache, private
Date: Sun, 26 Sep 2021 20:01:41 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{"success":true}
```
##

### Auth error example

> If you attempt to access a note that does not belong to your user

#### Request 
```
curl -i -H "Authorization: Bearer <generated bearer token>" -X "DELETE" http://127.0.0.1:8000/api/notes/1
```

#### Response
```
HTTP/1.1 401 Unauthorized
Host: 127.0.0.1:8000
Date: Sun, 26 Sep 2021 20:09:38 GMT
Connection: close
X-Powered-By: PHP/8.0.10
Cache-Control: no-cache, private
Date: Sun, 26 Sep 2021 20:09:38 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{"message":"Authorization Error","errors":{"id":["This user does not have permission to view, updated, or delete this note."]}}
```

##

### Validation error example
> Missing or incorrectly formatted parameters (example: missing required title)

#### Request 
`POST /api/notes`
```
curl -i -H "Authorization: Bearer <generated bearer token>" -d "note=Example Note" -X POST http://127.0.0.1:8000/api/notes
```

#### Response
```
HTTP/1.1 422 Unprocessable Entity
Host: 127.0.0.1:8000
Date: Sun, 26 Sep 2021 20:12:58 GMT
Connection: close
X-Powered-By: PHP/8.0.10
Cache-Control: no-cache, private
Date: Sun, 26 Sep 2021 20:12:58 GMT
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{"title":["Note title is required."]}
```
##

# Postman - GET list example
*Ensure you populate 'Bearer Token' field with generated token*

### GET list of Notes 
> scoped by user  

#### REQUEST:
`GET /api/notes`
#### AVAILABLE REQUEST PARAMS (with examples):
```
{  
    "title": "Example Title!",  
    "created_at": "01-01-2021",
    "pagination": {
        "sort_column": "created_at",
        "sort_order": "DESC",
        "page_size": 10,
        "page": 1
    }
}
```
#### RESPONSE:
```
{
    "data": [
        {
            "id": 14,
            "user_id": 5,
            "title": "Spider-Man: No Way Home",
            "note": "Spider-Man's identity is revealed to everyone, and he can no longer separate his normal life from his superhero life. When he asks Doctor Strange for help, it forces him to discover what it means to be him.",
            "created_at": "2021-09-26T18:53:26.000000Z",
            "updated_at": "2021-09-26T18:53:26.000000Z",
            "deleted_at": null
        },
        {
            "id": 15,
            "user_id": 5,
            "title": "Shang-Chi and the Legend of the Ten Rings",
            "note": "Martial-arts master Shang-Chi confronts the past he thought he left behind when he's drawn into the web of the mysterious Ten Rings organization.",
            "created_at": "2021-09-26T18:54:49.000000Z",
            "updated_at": "2021-09-26T18:54:49.000000Z",
            "deleted_at": null
        }
    ]
}
```

##

### License
[MIT](https://choosealicense.com/licenses/mit/)