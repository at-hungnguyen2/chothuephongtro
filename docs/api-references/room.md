## ROOM - API

### `POST` Add new room into existed post
```
api/posts/{post_id}/rooms
```
Add new post from client.
#### Request Header
| Key | Value |
|---|---|
| Accept | application/json |
| Authorization | {token_type} {access_token} |
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| cost_id | Integer | required | Id of cost |
| subject_id | Integer | required | Id of subject |
| amount | Integer | not required | Amount of people |
| image | File | not required | Image of room |

#### Sample Request
```json
{
	"cost_id": 1,
	"subject_id": 2,
	"amount": 2,
	"image": file
}
```
#### Sample Response
```json
{
	"room": {
        "amount": "2",
        "cost_id": "1",
        "subject_id": "2",
        "post_id": "20",
        "image": "XASFjVdK.jpg",
        "updated_at": "2017-09-29 15:08:12",
        "created_at": "2017-09-29 15:08:12",
        "id": 9
    },
    "success": true
}
```

### `GET` SPECIFIC ROOM
```
/api/rooms/{room_id}
```
Get room by id

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |

#### Sample Response
```json
{
  	"data": {
        "id": 8,
        "amount": 3,
        "image": null,
        "cost_id": 2,
        "status": 1,
        "post_id": 20,
        "subject_id": 3,
        "created_at": "2017-09-29 14:36:12",
        "updated_at": "2017-09-29 14:36:12",
        "cost": {
            "id": 2,
            "cost": "500k - 700k"
        },
        "subject": {
            "id": 3,
            "subject": "All"
        },
        "post": {
            "id": 20,
            "title": "Testttttttt"
        }
    },
    "success": true
}
```
