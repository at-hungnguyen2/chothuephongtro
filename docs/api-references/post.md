## POST - API

### `POST` Create New Post
```
api/posts
```
Add new post from client.
#### Request Header
| Key | Value |
|---|---|
| Accept | application/json |
|Content-Type| application/json |
| Authorization | {token_type} {access_token} |
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| user_id | Integer | required | Id of current user |
| title | String | required | Post title |
| content | String | required | Content of post |
| address | String | required | Address of room/house |
| post_type | Integer | required | Id of type post |
| cost | Integer | required | Id of cost |
| subject | Integer | required | Id of subject |
| district | Integer | required | Id of district |
#### Sample Request
```json
{
	"user_id": 1,
	"title": "Cho thue phong tro moi",
	"content": "Phong tro rong rai thoang mat, 20m2",
	"address": "137 K82 Nguyen Luong Bang",
	"post_type": 2,
	"cost": 3,
	"subject": 1,
	"district": 2
}
```
#### Sample Response
```json
{
	"data": {
		"user_id": 1,
		"title": "Cho thue phong tro moi",
		"content": "Phong tro rong rai thoang mat, 20m2",
		"address": "137 K82 Nguyen Luong Bang",
		"post_type": 2,
		"cost": 3,
		"subject": 1,
		"district": 2,
		"created_at": "2017-09-14 05:55:55",
		"updated_at": "2017-09-14 05:55:55"
	},
	"success": true
}
```

### `GET` ALL POST
```
/api/posts
```
Get all post

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |

#### Sample Response
```json
{
  	"total": 1,
    "per_page": 10,
    "current_page": 1,
    "last_page": 1,
    "next_page_url": null,
    "path": "http://link-to-host.com/api/posts",
    "prev_page_url": null,
    "from": 1,
    "to": 1,
    "data": [
	    {
			"title": "Cho thue phong moi",
			"user_id": 2,
			"content": "abcxyz",
			"address": "nguyen luong bang"
	    },
	    {
	    	"title": "Cho thue phong moi",
			"user_id": 3,
			"content": "abcssssssxyz",
			"address": "Ton Duc Thang"
	    },
	    {
	    	"title": "Cho thue phong tro",
			"user_id": 3,
			"content": "abcxyzdsasdz",
			"address": "Ngo Si Lien"
	    }
	],
	"success": true
}
```
