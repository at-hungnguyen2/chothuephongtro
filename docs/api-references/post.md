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
| post_type_id | Integer | required | Id of type post |
| cost_id | Integer | required | Id of cost |
| subject_id | Integer | required | Id of subject |
| district_id | Integer | required | Id of district |
#### Sample Request
```json
{
	"user_id": 1,
	"title": "Cho thue phong tro moi",
	"content": "Phong tro rong rai thoang mat, 20m2",
	"address": "137 K82 Nguyen Luong Bang",
	"post_type_id": 2,
	"cost_id": 3,
	"subject_id": 1,
	"district_id": 2
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
  	"data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "user_id": 1,
                "post_type_id": 1,
                "cost_id": 1,
                "subject_id": 1,
                "district_id": 1,
                "title": "Cho thue phong o bach khoa",
                "image": null,
                "content": "Phong dep thoang mat sach se",
                "address": "K82 Nguyen Luong Bang",
                "is_active": 0,
                "status": 1,
                "lat": "102.9232222",
                "lng": "103.9999990",
                "created_at": "2017-09-23 14:54:03",
                "updated_at": "2017-09-23 14:54:03"
            },
            {
                "id": 2,
                "user_id": 1,
                "post_type_id": 2,
                "cost_id": 3,
                "subject_id": 4,
                "district_id": 1,
                "title": "Cho thue phong o su pham",
                "image": null,
                "content": "Phong dep thoang mat sach se",
                "address": "K82 ton duc thang",
                "is_active": 0,
                "status": 1,
                "lat": "102.9232222",
                "lng": "103.9999990",
                "created_at": "2017-09-23 14:55:02",
                "updated_at": "2017-09-23 14:55:02"
            }
        ],
        "first_page_url": "http://link-to-host.com/api/posts?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://link-to-host.com/api/posts?page=1",
        "next_page_url": null,
        "path": "http://link-to-host.com/api/posts",
        "per_page": 10,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    },
    "success": true
}
```

### `GET` SPECIFIC POST
```
/api/posts/{post_id}
```
Get post by id

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |

#### Sample Response
```json
{
  	"data": {
        "id": 1,
        "user_id": 1,
        "post_type_id": 3,
        "cost_id": 1,
        "subject_id": 2,
        "district_id": 3,
        "title": "Cho thue phong tro o Kinh Te",
        "image": null,
        "content": "Phong rat dep ahihi",
        "address": "K82 Ngo Quyen",
        "is_active": 0,
        "status": 1,
        "lat": "102.0000000",
        "lng": "103.0000000",
        "created_at": "2017-09-23 14:54:03",
        "updated_at": "2017-09-24 02:26:55"
    },
    "comments": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "user_id": 1,
                "post_id": 1,
                "comment": "Phong gia nhiu?",
                "created_at": "2017-09-24 03:08:26",
                "updated_at": "2017-09-24 03:08:26"
            },
            {
                "id": 2,
                "user_id": 1,
                "post_id": 1,
                "comment": "Co giam gia khong?",
                "created_at": "2017-09-24 03:08:38",
                "updated_at": "2017-09-24 03:08:38"
            },
            {
                "id": 3,
                "user_id": 1,
                "post_id": 1,
                "comment": "Fix them ti di",
                "created_at": "2017-09-24 03:10:08",
                "updated_at": "2017-09-24 03:10:08"
            },
            {
                "id": 4,
                "user_id": 1,
                "post_id": 1,
                "comment": "Nan ni ma",
                "created_at": "2017-09-24 03:10:13",
                "updated_at": "2017-09-24 03:10:13"
            },
            {
                "id": 5,
                "user_id": 1,
                "post_id": 1,
                "comment": "Cau xin do",
                "created_at": "2017-09-24 03:10:19",
                "updated_at": "2017-09-24 03:10:19"
            }
        ],
        "first_page_url": "http://phongtro.app/api/posts/1?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://phongtro.app/api/posts/1?page=2",
        "next_page_url": "http://phongtro.app/api/posts/1?page=2",
        "path": "http://phongtro.app/api/posts/1",
        "per_page": 5,
        "prev_page_url": null,
        "to": 5,
        "total": 7
    },
    "success": true
}
```
