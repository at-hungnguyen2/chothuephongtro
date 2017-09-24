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
	"comment": "Phong nay cho phep bao nhieu nguoi o vay?"
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

### `PUT` Edit comment
```
/api/comments/{id}
```
Edit specific comment by id

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |

#### Sample Request
```json
{
	"comment": "Phong nay gia nhiu?"
}
```
#### Sample Response
```json
{
	"message": 'Update comment success'
}
```
