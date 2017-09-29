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
| Authorization | {token_type} {access_token} |
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| title | String | required | Post title |
| image | String | required | file image |
| content | String | required | Content of post |
| address | String | required | Address of room/house |
| post_type_id | Integer | required | Id of type post |
| cost_id | Integer | required | Id of cost |
| subject_id | Integer | required | Id of subject |
| district_id | Integer | required | Id of district |
| lat | decimal(10, 7) | required | Google map lat |
| lng | decimal(10, 7) | required | Google map lng |
| room[][amount] | Integer | not required | Amount of people |
| room[][cost_id] | Integer | not required | cost_id - Can change to string to add specific value |
| room[][subject_id] | Integer | not required | subject_id - 0 - Male, 1 - Female, 2 - All |

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
	"district_id": 2,
    "room[0][amount]": 3,
    "room[0][cost_id]": 1,
    "room[0][subject_id]": 2,
    "room[1][amount]": 3,
    "room[1][cost_id]": 1,
    "room[1][subject_id]": 2
}
```
#### Sample Response
```json
{
	"data": {
        "post_type_id": "1",
        "cost_id": "2",
        "subject_id": "1",
        "district_id": "1",
        "title": "Testttttttt",
        "content": "What is this",
        "address": "hihi",
        "lat": "100.0000000",
        "lng": "100.0000000",
        "street_id": "1",
        "image": "OqCnK0Lm.jpg",
        "user_id": 2,
        "updated_at": "2017-09-29 14:36:12",
        "created_at": "2017-09-29 14:36:12",
        "id": 20
    },
    "room": [
        {
            "id": 7,
            "amount": 2,
            "image": null,
            "cost_id": 1,
            "status": 1,
            "post_id": 20,
            "subject_id": 2,
            "created_at": "2017-09-29 14:36:12",
            "updated_at": "2017-09-29 14:36:12"
        },
        {
            "id": 8,
            "amount": 3,
            "image": null,
            "cost_id": 2,
            "status": 1,
            "post_id": 20,
            "subject_id": 3,
            "created_at": "2017-09-29 14:36:12",
            "updated_at": "2017-09-29 14:36:12"
        }
    ],
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
                "id": 17,
                "user_id": 2,
                "post_type_id": 1,
                "cost_id": 2,
                "subject_id": 1,
                "district_id": 1,
                "street_id": 1,
                "title": "Test image5",
                "image": "fCi8hYUm.jpg",
                "content": "What is this",
                "address": "hihi",
                "is_active": 0,
                "status": 1,
                "lat": "100.0000000",
                "lng": "100.0000000",
                "created_at": "2017-09-28 16:43:31",
                "updated_at": "2017-09-28 16:43:31",
                "user": {
                    "id": 2,
                    "name": "hung"
                },
                "district": {
                    "id": 1,
                    "district": "Cẩm Lệ"
                },
                "cost": {
                    "id": 2,
                    "cost": "500k - 700k"
                },
                "subject": {
                    "id": 1,
                    "subject": "Male"
                },
                "post_type": {
                    "id": 1,
                    "type": "Phòng Trọ, Nhà Trọ"
                }
            },
            {
                "id": 17,
                "user_id": 2,
                "post_type_id": 1,
                "cost_id": 2,
                "subject_id": 1,
                "district_id": 1,
                "street_id": 1,
                "title": "Test image5",
                "image": "fCi8hYUm.jpg",
                "content": "What is this",
                "address": "hihi",
                "is_active": 0,
                "status": 1,
                "lat": "100.0000000",
                "lng": "100.0000000",
                "created_at": "2017-09-28 16:43:31",
                "updated_at": "2017-09-28 16:43:31",
                "user": {
                    "id": 2,
                    "name": "hung"
                },
                "district": {
                    "id": 1,
                    "district": "Cẩm Lệ"
                },
                "cost": {
                    "id": 2,
                    "cost": "500k - 700k"
                },
                "subject": {
                    "id": 1,
                    "subject": "Male"
                },
                "post_type": {
                    "id": 1,
                    "type": "Phòng Trọ, Nhà Trọ"
                }
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
        "user_id": 2,
        "post_type_id": 1,
        "cost_id": 2,
        "subject_id": 1,
        "district_id": 1,
        "street_id": 1,
        "title": "Test image5",
        "image": "fCi8hYUm.jpg",
        "content": "What is this",
        "address": "hihi",
        "is_active": 0,
        "status": 1,
        "lat": "100.0000000",
        "lng": "100.0000000",
        "created_at": "2017-09-28 16:43:31",
        "updated_at": "2017-09-28 16:43:31",
        "user": {
            "id": 2,
            "name": "hung"
        },
        "district": {
            "id": 1,
            "district": "Cẩm Lệ"
        },
        "cost": {
            "id": 2,
            "cost": "500k - 700k"
        },
        "subject": {
            "id": 1,
            "subject": "Male"
        },
        "post_type": {
            "id": 1,
            "type": "Phòng Trọ, Nhà Trọ"
        }
    },
    "rooms": [
        {
            "id": 7,
            "amount": 2,
            "image": null,
            "cost_id": 1,
            "status": 1,
            "post_id": 20,
            "subject_id": 2,
            "created_at": "2017-09-29 14:36:12",
            "updated_at": "2017-09-29 14:36:12"
        },
        {
            "id": 8,
            "amount": 3,
            "image": null,
            "cost_id": 2,
            "status": 1,
            "post_id": 20,
            "subject_id": 3,
            "created_at": "2017-09-29 14:36:12",
            "updated_at": "2017-09-29 14:36:12"
        },
        {
            "id": 9,
            "amount": 2,
            "image": "XASFjVdK.jpg",
            "cost_id": 1,
            "status": 1,
            "post_id": 20,
            "subject_id": 2,
            "created_at": "2017-09-29 15:08:12",
            "updated_at": "2017-09-29 15:08:12"
        }
    ],
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
        "first_page_url": "http://phongtro.app/api/posts/17?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://phongtro.app/api/posts/17?page=2",
        "next_page_url": "http://phongtro.app/api/posts/17?page=2",
        "path": "http://phongtro.app/api/posts/1",
        "per_page": 5,
        "prev_page_url": null,
        "to": 5,
        "total": 7
    },
    "success": true
}
```
