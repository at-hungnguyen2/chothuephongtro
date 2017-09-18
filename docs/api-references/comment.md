## COMMENT - API

### `POST` Create New Comment
```
api/comments
```
Add new comment from client.
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
| post_id | Integer | required | Id of post want to comment |
| comment | String | required | Content of comment |
#### Sample Request
```json
{
	"user_id": 1,
	"post_id": 2,
	"content": "Phong nay cho phep bao nhieu nguoi o vay?"
}
```
#### Sample Response
```json
{
	"data": {
		"user_id": 1,
		"post_id": 2,
		"comment": "Phong nay cho phep bao nhieu nguoi o vay?",
		"created_at": "2017-09-14 05:55:55",
		"updated_at": "2017-09-14 05:55:55"
	},
	"success": true
}
```

### `GET` All Comment of a post
```
/api/comments/{post_id}
```
Get all comment

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
    "path": "http://link-to-host.com/api/comment/1",
    "prev_page_url": null,
    "from": 1,
    "to": 1,
    "data": [
	    {
			"user_id": 2,
			"comment": "abcxyz",
			"created_at": "2017-09-15 04:43:56",
			"updated_at": "2017-09-15 04:43:56",
	    },
	    {
			"user_id": 3,
			"comment": "phong dep lam"
			"created_at": "2017-09-15 04:43:56",
			"updated_at": "2017-09-15 04:43:56",
	    }
	],
	"success": true
}
```
