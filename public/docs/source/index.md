---
title: API Reference

language_tabs:

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://scms.loc/docs/collection.json)

<!-- END_INFO -->

#ADVANTAGE


<!-- START_32ca3ca3c9e3f89b043d35bf244b790c -->
## Categories meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "title": {
            "creating": "Creating Category",
            "updating": "Updating Category",
            "index": "Categories"
        },
        "success": {
            "created": "Category success created",
            "updated": "Category success updated",
            "deleted": "Categories success deleted"
        },
        "fields": {
            "is_active": "Active",
            "rank": "Rank",
            "title": "Title",
            "description": "Short description"
        },
        "description": {
            "is_active": "",
            "rank": "",
            "title": "",
            "description": ""
        }
    },
    "default": {
        "rank": 693,
        "is_active": 1
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/advantage/categories/meta`


<!-- END_32ca3ca3c9e3f89b043d35bf244b790c -->

<!-- START_be07b18967ed62532854272fa023da1f -->
## Categories bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/advantage/categories/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | Category id.

<!-- END_be07b18967ed62532854272fa023da1f -->

<!-- START_429e09cb6058fb24212119856ce2ab0d -->
## Categories list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "is_active": 1,
            "rank": 367,
            "title": "Eaque voluptate quia dignissimos repudiandae.",
            "description": "In sed ut blanditiis dolores et laudantium fugit. Blanditiis id non qui reiciendis sint. Deserunt et odio minus quidem laboriosam. Exercitationem culpa ipsam et quis quibusdam natus suscipit."
        },
        {
            "id": 2,
            "is_active": 1,
            "rank": 284,
            "title": "Ducimus tempore ducimus nihil.",
            "description": "Dolorum atque ut eos quidem nobis porro sunt. Accusamus repellendus voluptas dolore eius et et totam. Non eum consequatur animi in aut soluta corporis. Ipsam expedita et rem neque aut."
        }
    ],
    "meta": {
        "pagination": {
            "total": 8,
            "count": 8,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {
                "next": null,
                "previous": null
            }
        }
    },
    "count": 8
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/advantage/categories`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    is_active | integer |  optional  | optional    Active
    rank | integer |  optional  | optional    Rank
    title | string |  optional  | optional    Title
    description | string |  optional  | optional    Short description

<!-- END_429e09cb6058fb24212119856ce2ab0d -->

<!-- START_a3df00ed03e897e5c9debc3575540e8d -->
## Categories store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 33,
        "is_active": 1,
        "rank": 749,
        "title": "Qui cupiditate rerum sed eos.",
        "description": "Qui ut quia et. Laboriosam expedita esse sit assumenda ut eos alias facere. Praesentium inventore inventore veritatis dolores nesciunt facilis corrupti nulla.",
        "ru": {
            "title": "Nam et suscipit rerum eaque quia vitae.",
            "description": "Rerum corporis dolore ut ducimus aperiam et. Accusamus voluptas vitae omnis illum voluptates. Eos omnis odit ea rerum. A tempore veniam sed qui omnis quis cum."
        },
        "ua": {
            "title": "Dolorem hic odio unde enim tempora quos vel.",
            "description": "Molestias qui dolorum aut quia. Qui perspiciatis fuga est ut. Pariatur quia nobis deserunt sed dolores. Id sunt neque odio ipsam sapiente saepe. Nam blanditiis magni ducimus ea."
        },
        "en": {
            "title": "Qui cupiditate rerum sed eos.",
            "description": "Qui ut quia et. Laboriosam expedita esse sit assumenda ut eos alias facere. Praesentium inventore inventore veritatis dolores nesciunt facilis corrupti nulla."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/advantage/categories`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    is_active | integer |  required  | Active
    rank | integer |  required  | Rank
    lang[title] | string |  required  | Title
    lang[description] | string |  optional  | optional Short description

<!-- END_a3df00ed03e897e5c9debc3575540e8d -->

<!-- START_f75156783527b467aaee2a8d2a8e71a3 -->
## Categories show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 35,
        "is_active": 1,
        "rank": 788,
        "title": "Ut a officiis fugiat aperiam vero.",
        "description": "In culpa est nulla consequatur consequatur et impedit assumenda. Dolor fuga perspiciatis aliquam ipsa sint velit et quis. Deleniti aspernatur voluptates accusantium vel et est. Deserunt asperiores tempora explicabo expedita.",
        "en": {
            "title": "Ut a officiis fugiat aperiam vero.",
            "description": "In culpa est nulla consequatur consequatur et impedit assumenda. Dolor fuga perspiciatis aliquam ipsa sint velit et quis. Deleniti aspernatur voluptates accusantium vel et est. Deserunt asperiores tempora explicabo expedita."
        },
        "ru": {
            "title": "Est consequatur doloremque nemo ut.",
            "description": "Nesciunt voluptas numquam eius nesciunt soluta. Quo incidunt laboriosam excepturi aut alias. Maiores expedita aperiam fuga. Aut impedit quo aut harum temporibus qui. Consequatur excepturi asperiores velit vel."
        },
        "ua": {
            "title": "Natus quibusdam et illo culpa aut.",
            "description": "Maxime officiis cum consequuntur quaerat voluptatibus ut iste. Libero quis sint eaque. Dolor molestias perspiciatis et voluptas porro sed aperiam."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Advantage\\Models\\Category] 35",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/advantage/categories/{category}`


<!-- END_f75156783527b467aaee2a8d2a8e71a3 -->

<!-- START_10db3eb157cd2dd7022c6366b0e308a0 -->
## Categories update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 34,
        "is_active": 1,
        "rank": 865,
        "title": "Tenetur vero minus aut qui sequi.",
        "description": "Doloribus quae repellendus et quam. Ullam velit earum delectus qui in magni. Fugit iste illo id quaerat. Praesentium quasi est nemo vitae. Dolore et odio vitae exercitationem. Est aut molestias sunt ea qui labore porro. Aut blanditiis facilis culpa.",
        "en": {
            "title": "Tenetur vero minus aut qui sequi.",
            "description": "Doloribus quae repellendus et quam. Ullam velit earum delectus qui in magni. Fugit iste illo id quaerat. Praesentium quasi est nemo vitae. Dolore et odio vitae exercitationem. Est aut molestias sunt ea qui labore porro. Aut blanditiis facilis culpa."
        },
        "ru": {
            "title": "Architecto non in est accusantium labore.",
            "description": "Error qui qui placeat consequatur. Asperiores doloremque ea omnis quia. Dolor explicabo distinctio possimus debitis veniam nihil. Libero rerum dolorem distinctio dolorem eius."
        },
        "ua": {
            "title": "Nihil magnam ab enim maxime optio.",
            "description": "Ullam voluptas consequatur debitis ut iusto. Vel suscipit earum hic et recusandae. Aut non tempora accusantium suscipit commodi aut sit. Recusandae repellat illo et deserunt sapiente."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Advantage\\Models\\Category] 34",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/advantage/categories/{category}`

`PATCH api/scms/advantage/categories/{category}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    is_active | integer |  required  | Active
    rank | integer |  required  | Rank
    lang[title] | string |  required  | Title
    lang[description] | string |  optional  | optional Short description

<!-- END_10db3eb157cd2dd7022c6366b0e308a0 -->

<!-- START_84d9aa657ce895dd4546db214ef193ad -->
## Categories destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Advantage\\Models\\Category] 36",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/advantage/categories/{category}`


<!-- END_84d9aa657ce895dd4546db214ef193ad -->

<!-- START_1006a5f9d3afc41c715b5d2005a234fd -->
## Advantages meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "title": {
            "creating": "Creating Advantage",
            "updating": "Updating Advantage",
            "index": "Advantages"
        },
        "success": {
            "created": "Advantage success created",
            "updated": "Advantage success updated",
            "deleted": "Advantages success deleted"
        },
        "fields": {
            "id": "id",
            "category_id": "Category",
            "category_title": "Category",
            "image": "Image",
            "image_base64": "Image",
            "is_active": "Active",
            "rank": "Rank",
            "svg_code": "SVG code",
            "title": "Title",
            "description": "Short description",
            "body": "Body"
        },
        "description": {
            "category_id": "",
            "image": "",
            "image_base64": "",
            "is_active": "",
            "rank": "",
            "svg_code": "",
            "title": "",
            "description": "",
            "body": ""
        }
    },
    "options": {
        "categories": [
            {
                "value": 1,
                "text": "Eaque voluptate quia dignissimos repudiandae."
            },
            {
                "value": 2,
                "text": "Ducimus tempore ducimus nihil."
            },
            {
                "value": 3,
                "text": "Esse et aut quae architecto est non qui."
            },
            {
                "value": 4,
                "text": "Possimus sequi eos dolores aut ratione."
            },
            {
                "value": 5,
                "text": "Quia voluptatum quia magni voluptas autem nobis."
            }
        ]
    },
    "default": {
        "rank": 1008,
        "is_active": 1
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/advantage/advantages/meta`


<!-- END_1006a5f9d3afc41c715b5d2005a234fd -->

<!-- START_fa691ba4a1d260ad3792056daf4ccbab -->
## Advantages bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/advantage/advantages/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | Advantage id.

<!-- END_fa691ba4a1d260ad3792056daf4ccbab -->

<!-- START_7f2408262c98eebac9b8b60b84aead20 -->
## Advantages list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 18,
            "category_id": 1,
            "category_title": "Eaque voluptate quia dignissimos repudiandae.",
            "image": "\/uploads\/20\/01\/18\/et-c_100x75.png",
            "is_active": 0,
            "rank": 435,
            "title": "Sed rem ut voluptas est.",
            "description": "Voluptas dolore minima rem placeat ad iste nobis. Ut ut qui est nesciunt. Qui ducimus ipsa et et."
        },
        {
            "id": 22,
            "category_id": 1,
            "category_title": "Eaque voluptate quia dignissimos repudiandae.",
            "image": "\/uploads\/20\/01\/18\/maxime-c_100x75.jpeg",
            "is_active": 1,
            "rank": 526,
            "title": "Cupiditate earum reiciendis qui voluptatum cum.",
            "description": "Enim corrupti nihil provident architecto. Quod placeat iste ut dolorum. Qui eaque tenetur vero asperiores doloribus quibusdam. Est ea quae possimus nesciunt harum provident voluptas."
        }
    ],
    "meta": {
        "pagination": {
            "total": 93,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 10,
            "links": {
                "next": "http:\/\/scms.loc\/api\/scms\/advantage\/advantages?page=2",
                "previous": null
            }
        }
    },
    "count": 93
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/advantage/advantages`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    category_title | string |  optional  | optional    Category
    is_active | integer |  optional  | optional    Active
    rank | integer |  optional  | optional    Rank
    title | string |  optional  | optional    Title
    description | string |  optional  | optional    Short description

<!-- END_7f2408262c98eebac9b8b60b84aead20 -->

<!-- START_ba4d52591fc9edbcb85c805f64aada9b -->
## Advantages store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 128,
        "category_id": 4,
        "image": null,
        "is_active": 0,
        "rank": 398,
        "svg_code": null,
        "title": "Omnis quia placeat iure omnis doloribus sint.",
        "description": "Accusantium ab iste aliquid et mollitia alias. Tenetur est sequi assumenda consequatur eum enim. Blanditiis minus et et vel aut ut.",
        "body": "Odit minima at nulla dignissimos labore magnam reiciendis. Necessitatibus quo sint nemo velit quo consequuntur omnis. Ex eos suscipit fuga officia aut. Excepturi pariatur reiciendis ut est. Dolorem qui quae recusandae quasi id deserunt aut.",
        "ru": {
            "title": "Nulla et voluptas ut sint.",
            "description": "Est voluptas reiciendis enim quia blanditiis hic voluptatem. Ratione placeat et sapiente quidem. Totam suscipit totam ut velit quod quia non cupiditate. Repellendus distinctio quidem reprehenderit commodi. Porro unde placeat quaerat voluptas dolore.",
            "body": "Omnis fugiat quia sit et sequi. Aliquam aliquid et provident omnis. Quis velit ut tenetur voluptatem."
        },
        "ua": {
            "title": "Ut ab omnis nostrum deserunt similique assumenda.",
            "description": "Consequatur nulla voluptas nam velit quisquam modi. Voluptatibus eveniet illum consequatur. Veritatis et alias quibusdam. Debitis rem vel eum accusantium laudantium dolorum aperiam.",
            "body": "Nam ut nihil omnis iste tempora et reprehenderit. Nam possimus blanditiis explicabo. Nam non cumque error voluptatem ea vitae. Consectetur ullam sunt non."
        },
        "en": {
            "title": "Omnis quia placeat iure omnis doloribus sint.",
            "description": "Accusantium ab iste aliquid et mollitia alias. Tenetur est sequi assumenda consequatur eum enim. Blanditiis minus et et vel aut ut.",
            "body": "Odit minima at nulla dignissimos labore magnam reiciendis. Necessitatibus quo sint nemo velit quo consequuntur omnis. Ex eos suscipit fuga officia aut. Excepturi pariatur reiciendis ut est. Dolorem qui quae recusandae quasi id deserunt aut."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "category_id": [
            "The Category field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ru.body": [
            "The Body (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "ua.body": [
            "The Body (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ],
        "en.body": [
            "The Body (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/advantage/advantages`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    category_id | integer |  required  | Category
    image | image |  optional  | optional Image
    is_active | integer |  required  | Active
    rank | integer |  required  | Rank
    svg_code | string |  optional  | optional SVG code
    lang[title] | string |  required  | Title
    lang[description] | string |  optional  | optional Short description
    lang[body] | string |  required  | Body

<!-- END_ba4d52591fc9edbcb85c805f64aada9b -->

<!-- START_0260339adca3206a3aba723b901e240d -->
## Advantages show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 130,
        "category_id": 2,
        "image": "\/uploads\/20\/01\/29\/consequatur-c_100x75.jpg",
        "is_active": 1,
        "rank": 215,
        "svg_code": null,
        "title": "Sequi et architecto iusto voluptatem.",
        "description": "Autem ratione omnis eaque ut assumenda maxime est hic. Sunt in illo amet consequatur autem. Quo dolore quis rerum ducimus nesciunt placeat et tenetur.",
        "body": "Saepe aliquid exercitationem quisquam veritatis voluptatum. Ipsa occaecati quod dolore aut mollitia. Pariatur repellat velit sint autem.",
        "en": {
            "title": "Sequi et architecto iusto voluptatem.",
            "description": "Autem ratione omnis eaque ut assumenda maxime est hic. Sunt in illo amet consequatur autem. Quo dolore quis rerum ducimus nesciunt placeat et tenetur.",
            "body": "Saepe aliquid exercitationem quisquam veritatis voluptatum. Ipsa occaecati quod dolore aut mollitia. Pariatur repellat velit sint autem."
        },
        "ru": {
            "title": "Ut sit dolor est nostrum.",
            "description": "Ea dolores iste sed molestias eveniet voluptatem temporibus. Id explicabo iusto quidem accusamus qui modi voluptatem. Commodi aut assumenda eum perferendis.",
            "body": "Reiciendis voluptas blanditiis voluptatibus. Et incidunt ea repellendus rerum ipsa molestias. Error velit et voluptates alias a porro qui. Nisi error ut et non. Reprehenderit aut magnam eaque."
        },
        "ua": {
            "title": "Quia expedita vero voluptatum voluptas.",
            "description": "Omnis sed nostrum sunt omnis officiis. Ea eligendi accusamus nihil. Eos nesciunt ratione numquam exercitationem. Nulla nihil sint ut harum magnam quis. Modi saepe vitae ea.",
            "body": "Odio suscipit quod eos eos consequatur illum. Officia fuga facilis voluptate ut eligendi consectetur ducimus. Quidem sapiente et vel."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Advantage\\Models\\Advantage] 130",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/advantage/advantages/{advantage}`


<!-- END_0260339adca3206a3aba723b901e240d -->

<!-- START_672d02fc58d8daed38c270c423713672 -->
## Advantages update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 129,
        "category_id": 1,
        "image": "\/uploads\/20\/01\/29\/ut-c_100x75.jpg",
        "is_active": 1,
        "rank": 751,
        "svg_code": null,
        "title": "Non excepturi nulla libero ab.",
        "description": "Architecto excepturi tenetur et est molestias adipisci. Quo et occaecati et. Culpa aspernatur sint voluptatem nostrum velit. Aut cupiditate sit officia et.",
        "body": "Molestiae beatae et quae qui non amet. Repudiandae et quasi sed aut architecto tenetur porro exercitationem. Labore molestias neque odit qui sit aut optio. Eos architecto vero voluptate eum pariatur laborum.",
        "en": {
            "title": "Non excepturi nulla libero ab.",
            "description": "Architecto excepturi tenetur et est molestias adipisci. Quo et occaecati et. Culpa aspernatur sint voluptatem nostrum velit. Aut cupiditate sit officia et.",
            "body": "Molestiae beatae et quae qui non amet. Repudiandae et quasi sed aut architecto tenetur porro exercitationem. Labore molestias neque odit qui sit aut optio. Eos architecto vero voluptate eum pariatur laborum."
        },
        "ru": {
            "title": "Facilis omnis impedit sit sit dicta ad qui.",
            "description": "Ut velit eveniet officiis cum sed. Molestiae nihil voluptas et fuga. Suscipit eligendi quidem suscipit dolores quia quis adipisci.",
            "body": "Eum provident atque facilis omnis eveniet porro consequuntur placeat. Excepturi et repellendus voluptates neque consectetur consequuntur. Quos rerum dolore error aperiam asperiores eos."
        },
        "ua": {
            "title": "Et corporis sed ab dolorem ipsum rerum.",
            "description": "Sed cum voluptas laudantium autem ullam asperiores. Eum nostrum qui tempora vel adipisci quasi. Vitae enim laudantium iste totam ex voluptatem. Culpa vel maiores dolore molestias quaerat itaque sit.",
            "body": "Tempore voluptatum necessitatibus voluptatem sed eum ea. Tempore vel qui magnam dolorum rerum perspiciatis saepe. Sint qui dolores quasi quod qui similique fugit."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "category_id": [
            "The Category field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ru.body": [
            "The Body (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "ua.body": [
            "The Body (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ],
        "en.body": [
            "The Body (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Advantage\\Models\\Advantage] 129",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/advantage/advantages/{advantage}`

`PATCH api/scms/advantage/advantages/{advantage}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    category_id | integer |  required  | Category
    image | image |  optional  | optional Image
    is_active | integer |  required  | Active
    rank | integer |  required  | Rank
    svg_code | string |  optional  | optional SVG code
    lang[title] | string |  required  | Title
    lang[description] | string |  optional  | optional Short description
    lang[body] | string |  required  | Body

<!-- END_672d02fc58d8daed38c270c423713672 -->

<!-- START_5a97e6adbab31c8a2e1d2dd1d2f2294b -->
## Advantages destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Advantage\\Models\\Advantage] 131",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/advantage/advantages/{advantage}`


<!-- END_5a97e6adbab31c8a2e1d2dd1d2f2294b -->

#AUTH


<!-- START_63bea058e5acc2faa2c5388bb1602c46 -->
## Login

> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 1132,
        "name": "Veronica Graham",
        "is_active": 1,
        "email": "fadel.jayme@example.com",
        "position": null,
        "created_at": "2020-01-29 12:22:14",
        "updated_at": "2020-01-29 12:22:14",
        "image": null,
        "roles": []
    },
    "token": "5Lb4Wnc0q6PqFnoZmlyBzUjXny7o5bGSDHJqgoOfpUI2WE4Op2PaEp8Eg57S",
    "menu": [
        {
            "id": "Advantage",
            "title": "Advantages",
            "route": "\/advantage\/advantages",
            "icon": "",
            "permission": "advantage.advantage.index",
            "children": [
                {
                    "id": "Category",
                    "title": "Categories",
                    "route": "\/advantage\/categories",
                    "icon": "",
                    "permission": "advantage.category.index"
                }
            ]
        },
        {
            "id": "ContentBlock",
            "title": "ContentBlocks",
            "route": "\/content-block\/content-blocks",
            "icon": "",
            "permission": "contentblock.contentblock.index"
        },
        {
            "title": "Menu",
            "route": "\/menu\/menus",
            "icon": "icon-log-menus",
            "permission": "menu.menu.index"
        },
        {
            "title": "Domains",
            "route": "\/structure\/domains",
            "icon": "icon-structure-domains",
            "permission": "structure.domain.index"
        },
        {
            "id": "Tariff",
            "title": "Tariffs",
            "route": "\/tariff\/tariffs",
            "icon": "",
            "permission": "tariff.tariff.index",
            "children": [
                {
                    "id": "OperatingSystem",
                    "title": "OperatingSystems",
                    "route": "\/tariff\/operating-systems",
                    "icon": "",
                    "permission": "tariff.operatingsystem.index"
                },
                {
                    "id": "Period",
                    "title": "Periods",
                    "route": "\/tariff\/periods",
                    "icon": "",
                    "permission": "tariff.period.index"
                },
                {
                    "id": "Currency",
                    "title": "Currencies",
                    "route": "\/tariff\/currencies",
                    "icon": "",
                    "permission": "tariff.currency.index"
                }
            ]
        },
        {
            "title": "Users",
            "route": "\/user\/users",
            "icon": "icon-user-users",
            "permission": "user.user.index",
            "children": [
                {
                    "title": "Roles",
                    "route": "\/user\/roles",
                    "icon": "icon-user-roles",
                    "permission": "user.role.index"
                }
            ]
        }
    ],
    "permissions": []
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "email": [
            "The E-mail field is required."
        ],
        "password": [
            "The Password field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/auth/login`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User email.
    password | string |  required  | User password.

<!-- END_63bea058e5acc2faa2c5388bb1602c46 -->

<!-- START_d29dd363c4d87fad638c2ad16c5b4aeb -->
## Remind password - send email

> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "email": [
            "The E-mail field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/auth/remind-password/email`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User email.

<!-- END_d29dd363c4d87fad638c2ad16c5b4aeb -->

<!-- START_bf024def50bb260d8a393ce7f4481247 -->
## Remind password - set password

> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "email": [
            "The E-mail field is required."
        ],
        "code": [
            "The Code field is required."
        ],
        "password": [
            "The New password field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/auth/remind-password/input`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User email.
    code | integer |  required  | Code.
    password | string |  required  | New password.

<!-- END_bf024def50bb260d8a393ce7f4481247 -->

<!-- START_350be19b7509d3501c8c26e296db0960 -->
## Logout

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/auth/logout`


<!-- END_350be19b7509d3501c8c26e296db0960 -->

#CONTENT_BLOCK


<!-- START_cc96e83bb45f3bba862627967f39bea7 -->
## ContentBlocks meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "title": {
            "creating": "Creating ContentBlock",
            "updating": "Updating ContentBlock",
            "index": "ContentBlocks",
            "photos": "Photos"
        },
        "success": {
            "created": "ContentBlock success created",
            "updated": "ContentBlock success updated",
            "deleted": "ContentBlocks success deleted"
        },
        "fields": {
            "image": "Image",
            "image_base64": "Image",
            "name": "Name",
            "is_active": "Active",
            "is_hide_editor": "Hide editor",
            "adaptive_image": "Adaptive images",
            "title": "Title",
            "body": "Body"
        },
        "description": {
            "image": "",
            "image_base64": "",
            "name": "",
            "is_active": "",
            "is_hide_editor": "",
            "adaptive_image": "",
            "title": "",
            "body": ""
        }
    },
    "default": {
        "is_active": 1,
        "is_hide_editor": 0
    },
    "adaptive_images": {
        "adaptive_image": [
            "480x280",
            "768x480",
            "1024x640"
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/content-block/content-blocks/meta`


<!-- END_cc96e83bb45f3bba862627967f39bea7 -->

<!-- START_a56857516732a51890494077bc1d81d1 -->
## ContentBlocks bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/content-block/content-blocks/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | ContentBlock id.

<!-- END_a56857516732a51890494077bc1d81d1 -->

<!-- START_3ddb43a2bb2f8cd3fd42fd73692ecbac -->
## ContentBlocks list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 2,
            "image": "\/uploads\/20\/01\/23\/consequatur-r_100x75.jpeg",
            "name": "Iste veniam et voluptatem inventore. Qui vel quos sunt. Omnis et modi minima sed. Id qui cumque rerum rerum.",
            "is_active": 1,
            "is_hide_editor": 1,
            "title": "Voluptatum autem est vitae eum."
        },
        {
            "id": 3,
            "image": "\/uploads\/20\/01\/23\/error-r_100x75.png",
            "name": "11111111111111111111111111",
            "is_active": 1,
            "is_hide_editor": 1,
            "title": "11111111111111111111111111"
        }
    ],
    "meta": {
        "pagination": {
            "total": 12,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 2,
            "links": {
                "next": "http:\/\/scms.loc\/api\/scms\/content-block\/content-blocks?page=2",
                "previous": null
            }
        }
    },
    "count": 12
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/content-block/content-blocks`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    name | string |  optional  | optional    Name
    is_active | integer |  optional  | optional    Active
    is_hide_editor | integer |  optional  | optional    Hide editor
    title | string |  optional  | optional    Title

<!-- END_3ddb43a2bb2f8cd3fd42fd73692ecbac -->

<!-- START_cd31fc25f315f77e0dfa730118026bdb -->
## ContentBlocks store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 102,
        "image": null,
        "name": "In omnis exercitationem aut voluptates. Eius rerum laborum sequi. Sapiente expedita deleniti quaerat voluptatibus.",
        "is_active": 0,
        "is_hide_editor": 1,
        "adaptive_image": [],
        "title": "Est alias qui ut tempora at magni corrupti.",
        "body": "Earum est aliquam atque earum quas. Magnam quas modi rem quod incidunt quia aut. Ipsum possimus illo eligendi commodi ut autem. Odit quod inventore quidem consequuntur corrupti deserunt.",
        "ru": {
            "title": "Rerum dolorem praesentium facilis hic.",
            "body": "Dolorem corporis rerum impedit. Ut neque qui natus iste earum ab."
        },
        "ua": {
            "title": "Placeat temporibus dolor eos et.",
            "body": "Ab aut illo a sit porro consequatur quos. In culpa aut rem saepe consectetur. Dolores rerum sed porro quod possimus quae aliquam."
        },
        "en": {
            "title": "Est alias qui ut tempora at magni corrupti.",
            "body": "Earum est aliquam atque earum quas. Magnam quas modi rem quod incidunt quia aut. Ipsum possimus illo eligendi commodi ut autem. Odit quod inventore quidem consequuntur corrupti deserunt."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "name": [
            "The Name field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "is_hide_editor": [
            "The Hide editor field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ru.body": [
            "The Body (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "ua.body": [
            "The Body (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ],
        "en.body": [
            "The Body (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/content-block/content-blocks`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | image |  optional  | optional  Image
    name | string |  required  | Name
    is_active | integer |  required  | Active
    is_hide_editor | integer |  required  | Hide editor
    adaptive_image | string |  optional  | optional  Adaptive images
    lang[title] | string |  required  | Title
    lang[body] | string |  required  | Body

<!-- END_cd31fc25f315f77e0dfa730118026bdb -->

<!-- START_7d877be55e027ca40edcaa4a2410bbd5 -->
## ContentBlocks show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 104,
        "image": "\/uploads\/20\/01\/29\/aut-r_100x75.jpg",
        "name": "Asperiores minus aut eius. Quibusdam aut ut recusandae in porro vero est eligendi. Maiores voluptas voluptatem ea ipsa.",
        "is_active": 1,
        "is_hide_editor": 1,
        "adaptive_image": [],
        "title": "Quis amet totam aut sint omnis blanditiis.",
        "body": "Dolor esse labore minus modi ut et reprehenderit. Ipsam mollitia aut deserunt molestiae et dicta autem. Deleniti nihil aut quia est suscipit ab rerum. Eos delectus repellat harum consequuntur in tempora doloremque labore.",
        "en": {
            "title": "Quis amet totam aut sint omnis blanditiis.",
            "body": "Dolor esse labore minus modi ut et reprehenderit. Ipsam mollitia aut deserunt molestiae et dicta autem. Deleniti nihil aut quia est suscipit ab rerum. Eos delectus repellat harum consequuntur in tempora doloremque labore."
        },
        "ru": {
            "title": "Quasi ratione sit aut vero qui quia aspernatur.",
            "body": "Molestiae occaecati sit quae voluptatem omnis illum reiciendis atque. Voluptatem itaque quae rerum et dolor. Impedit qui placeat velit officia sed et sed. Aut ea ipsum explicabo aut dolores perspiciatis mollitia."
        },
        "ua": {
            "title": "Aliquid distinctio sequi sequi vitae.",
            "body": "Nostrum quae voluptatibus velit et voluptatem molestiae ullam. Quae voluptates vero et quo ex enim cum. Dolorem adipisci iusto delectus dolorum."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\ContentBlock\\Models\\ContentBlock] 104",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/content-block/content-blocks/{content_block}`


<!-- END_7d877be55e027ca40edcaa4a2410bbd5 -->

<!-- START_c4daabfe5c83e06f71f9293e6bcf9baf -->
## ContentBlocks update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 103,
        "image": "\/uploads\/20\/01\/29\/debitis-r_100x75.jpg",
        "name": "Est labore occaecati labore quo occaecati numquam. Dolorum iusto ad a veritatis.",
        "is_active": 0,
        "is_hide_editor": 0,
        "adaptive_image": [],
        "title": "Repudiandae eius unde dolorum perspiciatis amet.",
        "body": "Deleniti a quia et et. Illo in repudiandae dignissimos et quisquam quo. Tenetur est dolorum maxime adipisci molestiae deleniti harum. Soluta rerum qui in reiciendis dolore.",
        "en": {
            "title": "Repudiandae eius unde dolorum perspiciatis amet.",
            "body": "Deleniti a quia et et. Illo in repudiandae dignissimos et quisquam quo. Tenetur est dolorum maxime adipisci molestiae deleniti harum. Soluta rerum qui in reiciendis dolore."
        },
        "ru": {
            "title": "Molestiae sequi doloribus consequatur.",
            "body": "Doloribus voluptate qui iure adipisci. Cumque officiis repudiandae cupiditate quia culpa. Modi aliquid libero sed ducimus dolores debitis. Ducimus dolor aliquid sapiente molestias."
        },
        "ua": {
            "title": "Eos aliquam commodi corporis tempora.",
            "body": "Qui labore delectus alias aut sequi. Sequi reprehenderit perspiciatis maiores fugit. Totam laborum totam et dolorem. Iste quia omnis iure harum laboriosam quis voluptatem. Tempore saepe aut qui adipisci nesciunt officia quo."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "name": [
            "The Name field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "is_hide_editor": [
            "The Hide editor field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ru.body": [
            "The Body (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "ua.body": [
            "The Body (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ],
        "en.body": [
            "The Body (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\ContentBlock\\Models\\ContentBlock] 103",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/content-block/content-blocks/{content_block}`

`PATCH api/scms/content-block/content-blocks/{content_block}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | image |  optional  | optional  Image
    name | string |  required  | Name
    is_active | integer |  required  | Active
    is_hide_editor | integer |  required  | Hide editor
    adaptive_image | string |  optional  | optional  Adaptive images
    lang[title] | string |  required  | Title
    lang[body] | string |  required  | Body

<!-- END_c4daabfe5c83e06f71f9293e6bcf9baf -->

<!-- START_e00ad1502d76ae4baa66db4fb31b7644 -->
## ContentBlocks destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\ContentBlock\\Models\\ContentBlock] 105",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/content-block/content-blocks/{content_block}`


<!-- END_e00ad1502d76ae4baa66db4fb31b7644 -->

<!-- START_2baa743f5f98bd2c8d6c60805cabc3d0 -->
## ContentBlock photos meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "title": {
            "creating": "Creating Photo",
            "updating": "Updating Photo",
            "index": "Photos"
        },
        "success": {
            "created": "Photo success created",
            "updated": "Photo success updated",
            "deleted": "Photos success deleted"
        },
        "fields": {
            "image": "Image",
            "image_base64": "Image",
            "is_active": "Active",
            "type": "Type",
            "rank": "Rank",
            "title": "Title",
            "description": "Description"
        },
        "description": {
            "image": "",
            "image_base64": "",
            "is_active": "",
            "type": "",
            "rank": "",
            "title": "",
            "description": ""
        }
    },
    "model": {
        "fields": {
            "image": {
                "type": "image",
                "required": false
            },
            "is_active": {
                "type": "checkbox",
                "required": true,
                "default": 1
            },
            "type": {
                "type": "select",
                "required": false,
                "options": [
                    {
                        "value": 1,
                        "text": "image"
                    },
                    {
                        "value": 2,
                        "text": "map"
                    },
                    {
                        "value": 3,
                        "text": "plan"
                    }
                ]
            }
        },
        "translatable": {
            "title": {
                "type": "input",
                "required": true
            },
            "description": {
                "type": "ckeditor",
                "required": false
            }
        }
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/content-block/content-blocks/{content_block}/photos/meta`


<!-- END_2baa743f5f98bd2c8d6c60805cabc3d0 -->

<!-- START_e97eb2b1f9597927eafb37f9dd93a094 -->
## ContentBlock photos sortable

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`PUT api/scms/content-block/content-blocks/{content_block}/photos/sortable`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | ContentBlockPhoto id.

<!-- END_e97eb2b1f9597927eafb37f9dd93a094 -->

<!-- START_f75bf6789af501ee8ed8357890846019 -->
## ContentBlock photos bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/content-block/content-blocks/{content_block}/photos/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | ContentBlockPhoto id.

<!-- END_f75bf6789af501ee8ed8357890846019 -->

<!-- START_79c947eac474216f15c5b203fdf38d27 -->
## ContentBlock photos list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 246,
            "image": "\/uploads\/20\/01\/29\/impedit-r_100x75.jpg",
            "is_active": 0,
            "rank": 119,
            "title": "Dolorum iure quaerat quo ad sit.",
            "description": "Sint iusto nisi ad facere eligendi voluptate. Omnis sit ea praesentium inventore veritatis aliquid."
        },
        {
            "id": 244,
            "image": "\/uploads\/20\/01\/29\/eveniet-r_100x75.jpg",
            "is_active": 1,
            "rank": 271,
            "title": "Unde ipsam qui cupiditate nostrum.",
            "description": "Magni ut accusantium ipsam nam tempore sint et est. Pariatur et pariatur numquam consequuntur. Maiores laborum adipisci provident voluptatum est mollitia at."
        },
        {
            "id": 245,
            "image": "\/uploads\/20\/01\/29\/amet-r_100x75.jpg",
            "is_active": 0,
            "rank": 901,
            "title": "Quia qui et placeat et qui dolorem dolores.",
            "description": "Et sapiente aperiam eum repudiandae facere voluptatem aliquam. Placeat rerum animi odit placeat. Dolorum temporibus rerum quod vitae dolorem eius sunt. Aut voluptatum quibusdam eaque fuga."
        }
    ]
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/content-block/content-blocks/{content_block}/photos`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    is_active | integer |  optional  | optional    Active
    rank | integer |  optional  | optional    Rank
    title | string |  optional  | optional    Title
    description | string |  optional  | optional    Description

<!-- END_79c947eac474216f15c5b203fdf38d27 -->

<!-- START_f8fd34058eded51307bf586710cbedd6 -->
## ContentBlock photos store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 247,
        "image": null,
        "is_active": 1,
        "type": 1,
        "rank": 1,
        "title": "Voluptas officia corporis quis quisquam tenetur.",
        "description": "Natus et eos tenetur sit aut quis. Et non corporis illum eum distinctio. Qui quas accusamus minima culpa dignissimos at voluptate.",
        "ru": {
            "title": "Et enim sed ut atque quia quibusdam quia quidem.",
            "description": "Non reprehenderit non non occaecati iure quibusdam quasi. Non quae rerum dolorem expedita. Impedit dicta eligendi dicta magnam nobis. Quo quibusdam excepturi soluta quo quibusdam ad."
        },
        "ua": {
            "title": "Quaerat id nobis in modi impedit.",
            "description": "Quos ab id nisi eius sit id. Eum deserunt magni cumque."
        },
        "en": {
            "title": "Voluptas officia corporis quis quisquam tenetur.",
            "description": "Natus et eos tenetur sit aut quis. Et non corporis illum eum distinctio. Qui quas accusamus minima culpa dignissimos at voluptate."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/content-block/content-blocks/{content_block}/photos`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | image |  optional  | optional  Image
    is_active | integer |  required  | Active
    type | integer |  optional  | optional  Type
    lang[title] | string |  required  | Title
    lang[description] | string |  optional  | optional  Description

<!-- END_f8fd34058eded51307bf586710cbedd6 -->

<!-- START_61159eba470a40b7b1b7b92c3b68049d -->
## ContentBlock photos show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 249,
        "image": "\/uploads\/20\/01\/29\/quam-r_100x75.jpg",
        "is_active": 0,
        "type": 2,
        "rank": 454,
        "title": "Voluptatem iure non aut velit dignissimos.",
        "description": "Illo quia omnis perferendis laboriosam at quia. Et qui aperiam iste nesciunt in voluptas quibusdam id. Adipisci omnis recusandae id commodi. Velit maxime dolor id ipsam et dicta eum.",
        "en": {
            "title": "Voluptatem iure non aut velit dignissimos.",
            "description": "Illo quia omnis perferendis laboriosam at quia. Et qui aperiam iste nesciunt in voluptas quibusdam id. Adipisci omnis recusandae id commodi. Velit maxime dolor id ipsam et dicta eum."
        },
        "ru": {
            "title": "Enim ad repellat dolor deleniti.",
            "description": "Nisi qui dolore earum quis vel repellat. Rerum delectus non beatae sint doloremque officiis quae eum. Qui occaecati adipisci est consequuntur totam sint. Tempora ut est est qui beatae."
        },
        "ua": {
            "title": "Error qui repudiandae doloribus esse aut.",
            "description": "Alias molestiae suscipit in et qui. Aut vero esse nihil commodi totam quis consequatur. Aut eum quod excepturi et. Facilis ratione consequatur velit unde omnis ad voluptatem."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\ContentBlock\\Models\\ContentBlock\\Photo] 249",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/content-block/content-blocks/{content_block}/photos/{photo}`


<!-- END_61159eba470a40b7b1b7b92c3b68049d -->

<!-- START_04a3eccaaf3d0cb459fd74207d73f619 -->
## ContentBlock photos update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 248,
        "image": "\/uploads\/20\/01\/29\/accusamus-r_100x75.jpg",
        "is_active": 1,
        "type": 3,
        "rank": 182,
        "title": "Animi consectetur ut eligendi.",
        "description": "Quasi aut sunt labore distinctio. Et et accusamus et quia voluptatem. Est alias illo repellat.",
        "en": {
            "title": "Animi consectetur ut eligendi.",
            "description": "Quasi aut sunt labore distinctio. Et et accusamus et quia voluptatem. Est alias illo repellat."
        },
        "ru": {
            "title": "Ut animi quia at accusantium molestias eius non.",
            "description": "Est dolorem quas cumque asperiores vel harum quae. Aspernatur voluptas reiciendis nesciunt non nisi. Accusamus officia qui tenetur sapiente eveniet impedit."
        },
        "ua": {
            "title": "Voluptas et recusandae molestias laboriosam.",
            "description": "Laboriosam qui laudantium eaque aut quia maiores. Aliquam eum et dolores ut culpa et cum. Nesciunt et quos provident voluptates quo aut."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\ContentBlock\\Models\\ContentBlock\\Photo] 248",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/content-block/content-blocks/{content_block}/photos/{photo}`

`PATCH api/scms/content-block/content-blocks/{content_block}/photos/{photo}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | image |  optional  | optional  Image
    is_active | integer |  required  | Active
    type | integer |  optional  | optional  Type
    lang[title] | string |  required  | Title
    lang[description] | string |  optional  | optional  Description

<!-- END_04a3eccaaf3d0cb459fd74207d73f619 -->

<!-- START_62c8fad4b18a52769bea6578a6b22f87 -->
## ContentBlock photos destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\ContentBlock\\Models\\ContentBlock\\Photo] 250",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/content-block/content-blocks/{content_block}/photos/{photo}`


<!-- END_62c8fad4b18a52769bea6578a6b22f87 -->

#EVENT


<!-- START_25e6928c4c62e1a10db809979090370e -->
## Events meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "id": "Id",
        "event_id": "Event ID",
        "is_active": "Active",
        "content_type": "Content type",
        "from_email": "From email",
        "from_name": "From name",
        "subject": "Subject",
        "body": "Body"
    },
    "content_types": {
        "1": "text\/plain",
        "2": "text\/html"
    },
    "event_ids": {
        "auth.remind_password": "Remind password"
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/event/events/meta`


<!-- END_25e6928c4c62e1a10db809979090370e -->

<!-- START_d443635f01016c671154ab633d71aca1 -->
## Events list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "event_id": "auth.remind_password",
            "is_active": 1,
            "from_email": null,
            "from_name": null,
            "content_type": null,
            "body": "[email], [code]",
            "subject": "Remind password"
        }
    ],
    "meta": {
        "pagination": {
            "total": 1,
            "count": 1,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {
                "next": null,
                "previous": null
            }
        }
    },
    "count": 1
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/event/events`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    is_active | integer |  optional  | optional active
    content_type | integer |  optional  | optional content type
    event_id | string |  optional  | optional event_id
    subject | string |  optional  | optional subject
    body | string |  optional  | optional body
    from_email | string |  optional  | optional from email
    from_name | string |  optional  | optional from name

<!-- END_d443635f01016c671154ab633d71aca1 -->

<!-- START_1e7f1105d861814a78729c7009c9f85f -->
## Events store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 7,
        "event_id": "auth.remind_password",
        "is_active": 1,
        "from_email": "citlalli.metz@example.com",
        "content_type": 2,
        "ru": {
            "subject": "Voluptatem iusto odio pariatur deserunt expedita possimus quo consequatur.",
            "body": "Ratione tempore inventore quam eligendi unde accusantium. Maiores ducimus non dolores consectetur in repellendus. Id nobis dolorum ut consequatur. Et iure adipisci dolorum consequatur et.",
            "from_name": "micheal.kohler"
        },
        "ua": {
            "subject": "Rerum et magni adipisci. Animi iure voluptatem ut reprehenderit autem qui nam.",
            "body": "Quibusdam non voluptas totam nesciunt ut nihil. Debitis recusandae ad quo laudantium ut. Quia enim officiis facilis voluptas nesciunt qui.",
            "from_name": "alfonso23"
        },
        "en": {
            "subject": "Consequatur sed repellat id repellat natus soluta occaecati ut.",
            "body": "Id officiis molestias sed rerum. Earum repellat accusamus qui quia repudiandae. Eum enim pariatur est quibusdam esse. Esse atque quia non.",
            "from_name": "price.justine"
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "event_id": [
            "The Event ID field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "content_type": [
            "The Content type field is required."
        ],
        "ru.subject": [
            "The Subject (ru) field is required."
        ],
        "ru.body": [
            "The Body (ru) field is required."
        ],
        "ua.subject": [
            "The Subject (ua) field is required."
        ],
        "ua.body": [
            "The Body (ua) field is required."
        ],
        "en.subject": [
            "The Subject (en) field is required."
        ],
        "en.body": [
            "The Body (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/event/events`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    is_active | integer |  required  | Active. Value: 0, 1
    content_type | integer |  required  | Content type. Value: 1, 2
    lang[subject] | string |  required  | Subject.
    lang[body] | string |  required  | Body.
    from_email | string |  optional  | optional From email.
    lang[from_name] | string |  optional  | optional From name.

<!-- END_1e7f1105d861814a78729c7009c9f85f -->

<!-- START_97b71acd00a6614542626673c6bbb46f -->
## Events show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 1,
        "event_id": "auth.remind_password",
        "is_active": 0,
        "from_email": "qward@example.net",
        "content_type": 2,
        "en": {
            "subject": "Officiis odit nihil alias molestiae vel sed. Quibusdam voluptate non quis et.",
            "body": "Placeat doloremque reprehenderit recusandae quae voluptates natus. Numquam consequatur ducimus et dolorem ex. Possimus aut asperiores veritatis non. Nihil ut voluptatum eius recusandae facere.",
            "from_name": "fschinner"
        },
        "ru": {
            "subject": "Amet maiores id facere tempore excepturi.",
            "body": "Commodi fuga dolorem est quia aut. Architecto et molestiae pariatur. Animi dignissimos dolorum iste sint placeat illum. Animi fugiat rerum vitae porro.",
            "from_name": "damian.homenick"
        },
        "ua": {
            "subject": "Ad omnis fugit delectus maxime voluptatem sed provident.",
            "body": "Atque placeat deserunt quae reprehenderit quia. Quo eaque maiores ea tenetur voluptates. Et enim provident eum rerum libero. Saepe molestiae quisquam repellat et cum tempora.",
            "from_name": "name61"
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Event\\Models\\Event] 1",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/event/events/{event}`


<!-- END_97b71acd00a6614542626673c6bbb46f -->

<!-- START_fc8cd954d974263f3087de43d6598adf -->
## Events update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 1,
        "event_id": "auth.remind_password",
        "is_active": 0,
        "from_email": "pete.hane@example.net",
        "content_type": 2,
        "en": {
            "subject": "Aut eos dolorum consectetur labore.",
            "body": "Rem nihil dolores qui vel veritatis aut. Explicabo ab excepturi sed ea. Eaque beatae eos eos ea dolor. Maxime quas exercitationem nihil autem expedita optio.",
            "from_name": "wsteuber"
        },
        "ru": {
            "subject": "Nemo reiciendis distinctio nobis inventore deserunt.",
            "body": "Voluptatem deleniti libero dolores deleniti. Nemo eligendi velit sint veritatis vero placeat sapiente accusantium.",
            "from_name": "ward.homenick"
        },
        "ua": {
            "subject": "Ducimus harum hic ullam doloremque eligendi illo eaque.",
            "body": "Voluptas nobis dicta sapiente quia molestias et earum voluptatem. Reprehenderit itaque dolor consequatur consequatur illum debitis.",
            "from_name": "halvorson.brant"
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "event_id": [
            "The Event ID field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "content_type": [
            "The Content type field is required."
        ],
        "ru.subject": [
            "The Subject (ru) field is required."
        ],
        "ru.body": [
            "The Body (ru) field is required."
        ],
        "ua.subject": [
            "The Subject (ua) field is required."
        ],
        "ua.body": [
            "The Body (ua) field is required."
        ],
        "en.subject": [
            "The Subject (en) field is required."
        ],
        "en.body": [
            "The Body (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Event\\Models\\Event] 1",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/event/events/{event}`

`PATCH api/scms/event/events/{event}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    is_active | integer |  required  | Active. Value: 0, 1
    content_type | integer |  required  | Content type. Value: 1, 2
    lang[subject] | string |  required  | Subject.
    lang[body] | string |  required  | Body.
    from_email | string |  optional  | optional From email.
    lang[from_name] | string |  optional  | optional From name.

<!-- END_fc8cd954d974263f3087de43d6598adf -->

<!-- START_16125543b61316b0a16d0d2a367412d0 -->
## Events destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Event\\Models\\Event] 1",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/event/events/{event}`


<!-- END_16125543b61316b0a16d0d2a367412d0 -->

<!-- START_c5166c226a00864c23e9faae22d45d29 -->
## Queues meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "id": "Id",
        "event_id": "Event ID",
        "status": "Status",
        "email_to": "Email to",
        "from_email": "From email",
        "from_name": "From name",
        "subject": "Subject",
        "body": "Body",
        "created_at": "Created",
        "send_at": "Sended"
    },
    "statuses": {
        "1": "ожидает отправки",
        "2": "отправлено",
        "3": "ошыбка отправки"
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/event/queues/meta`


<!-- END_c5166c226a00864c23e9faae22d45d29 -->

<!-- START_1da00b7ebeedacc05565c54e34272672 -->
## Queues list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [],
    "meta": {
        "pagination": {
            "total": 0,
            "count": 0,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {
                "next": null,
                "previous": null
            }
        }
    },
    "count": 0
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/event/queues`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    status | integer |  optional  | optional status
    subject | string |  optional  | optional subject
    body | string |  optional  | optional body
    email_to | string |  optional  | optional email to
    from_email | string |  optional  | optional from email
    from_name | string |  optional  | optional from name

<!-- END_1da00b7ebeedacc05565c54e34272672 -->

<!-- START_ce0a874952ab405b8e90086b547fd2fe -->
## Queues show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 23,
        "status": 2,
        "email_to": "treutel.caleb@example.net",
        "from_email": "quincy65@example.com",
        "from_name": "clovis.volkman",
        "subject": "Ratione commodi soluta voluptates corporis repudiandae.",
        "body": "In cupiditate aut dignissimos unde dolores nostrum beatae. Sunt sunt rem ducimus enim sit. Ullam quos ut sequi corporis veritatis velit occaecati. Harum deleniti quod ut incidunt amet omnis.",
        "created_at": "2020-01-29 14:22:33",
        "send_at": null
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Event\\Models\\Queue] 23",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/event/queues/{queue}`


<!-- END_ce0a874952ab405b8e90086b547fd2fe -->

<!-- START_06766ba1983953cc902cc05fb9de9d9e -->
## Queues destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Event\\Models\\Queue] 24",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/event/queues/{queue}`


<!-- END_06766ba1983953cc902cc05fb9de9d9e -->

#MENU


<!-- START_030417de6d40d10cb567cc571313db9c -->
## Menus bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/menu/menus/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | menu id.

<!-- END_030417de6d40d10cb567cc571313db9c -->

<!-- START_27b719201bec7ba1e25c850c72ff7400 -->
## Menus meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "menu": {
            "fields": {
                "id": "ID",
                "domain_id": "Domain",
                "title": "Title",
                "is_active": "Active",
                "is_sitemap": "Sitemap"
            },
            "description": {
                "id": "",
                "domain_id": "",
                "title": "",
                "is_active": "",
                "is_sitemap": ""
            },
            "title": {
                "creating": "Creating menu",
                "updating": "Updating menu",
                "index": "Menus"
            },
            "success": {
                "created": "Menu success created",
                "updated": "Menu success updated",
                "deleted": "Menu success deleted"
            }
        },
        "item": {
            "fields": {
                "menu_id": "Menu",
                "parent_id": "Parent",
                "page_id": "Page",
                "is_active": "Active",
                "is_targer_blank": "Target blank",
                "rank": "Rank",
                "changefreq": "Sitemap changefreq",
                "priority": "Sitemap priority",
                "name": "Name",
                "title": "Title",
                "image": "Image",
                "link": "Link",
                "style": "Css raw style",
                "class": "Html link class",
                "description": "Description"
            },
            "title": {
                "creating": "Creating menu item",
                "updating": "Updating menu item",
                "index": "Menus item"
            },
            "changefreqs": {
                "1": "always",
                "2": "hourly",
                "3": "daily",
                "4": "weekly",
                "5": "monthly",
                "6": "yearly",
                "7": "never"
            },
            "priorities": {
                "0.0": "0.0",
                "0.1": "0.1",
                "0.2": "0.2",
                "0.3": "0.3",
                "0.4": "0.4",
                "0.5": "0.5",
                "0.6": "0.6",
                "0.7": "0.7",
                "0.8": "0.8",
                "0.9": "0.9",
                "1.0": "1.0"
            }
        }
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/menu/menus/meta`


<!-- END_27b719201bec7ba1e25c850c72ff7400 -->

<!-- START_c1fab48b2b2525b61fa48380045a0421 -->
## Menus list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "title": "11111111111111111111",
            "is_active": 1,
            "is_sitemap": 1
        },
        {
            "id": 2,
            "title": "11111111111111111111",
            "is_active": 1,
            "is_sitemap": 1
        }
    ],
    "meta": {
        "pagination": {
            "total": 14,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 2,
            "links": {
                "next": "http:\/\/scms.loc\/api\/scms\/menu\/menus?page=2",
                "previous": null
            }
        }
    },
    "count": 14
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/menu/menus`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    is_active | integer |  optional  | optional    Active
    is_sitemap | integer |  optional  | optional    Sitemap

<!-- END_c1fab48b2b2525b61fa48380045a0421 -->

<!-- START_24d979adfe01fae8384bceebb011ef08 -->
## Menus store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 80,
        "domain_id": 1,
        "title": "Velit omnis eos non recusandae occaecati at impedit et.",
        "is_active": 0,
        "is_sitemap": 1
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "title": [
            "The Title field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "is_sitemap": [
            "The Sitemap field is required."
        ],
        "items": [
            "The items field is required."
        ],
        "domain_id": [
            "The Domain field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/menu/menus`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    domain_id | integer |  required  | Domain
    title | string |  required  | Title
    is_active | integer |  required  | Active
    is_sitemap | integer |  required  | Sitemap

<!-- END_24d979adfe01fae8384bceebb011ef08 -->

<!-- START_2cc7ea42e0f424a2a041d89080d027fe -->
## Menus show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 58,
        "domain_id": 1,
        "title": "Delectus et aut nisi et sit recusandae earum.",
        "is_active": 0,
        "is_sitemap": 0,
        "items": null
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Menu\\Models\\Menu] 58",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/menu/menus/{menu}`


<!-- END_2cc7ea42e0f424a2a041d89080d027fe -->

<!-- START_b9d87d7bfd8b0bcc404bdeb5f71ca940 -->
## Menus update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 81,
        "domain_id": 1,
        "title": "Minima natus adipisci repudiandae nam eum et aut.",
        "is_active": 1,
        "is_sitemap": 1
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "title": [
            "The Title field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "is_sitemap": [
            "The Sitemap field is required."
        ],
        "items": [
            "The items field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Menu\\Models\\Menu] 81",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/menu/menus/{menu}`

`PATCH api/scms/menu/menus/{menu}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    domain_id | integer |  required  | Domain
    title | string |  required  | Title
    is_active | integer |  required  | Active
    is_sitemap | integer |  required  | Sitemap

<!-- END_b9d87d7bfd8b0bcc404bdeb5f71ca940 -->

<!-- START_2201304e4bffa08eff767b9724bc9568 -->
## Menus destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Menu\\Models\\Menu] 59",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/menu/menus/{menu}`


<!-- END_2201304e4bffa08eff767b9724bc9568 -->

#STRUCTURE


<!-- START_22a8d9878f75bbacbc5c596e841f9d0b -->
## Domains meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "fields": {
            "id": "Id",
            "alias": "Alias",
            "is_active": "Active",
            "site_lang": "Language",
            "site_langs": "Languages",
            "logo": "Logo",
            "logo_base64": "Logo file",
            "menus": "Menus",
            "menu_header_id": "Header Menu",
            "menu_footer_id": "Foter Menu",
            "copyright": "Copyright"
        },
        "description": {
            "id": "Id",
            "alias": "",
            "is_active": "",
            "site_lang": "Default language",
            "site_langs": "",
            "logo": "Logo",
            "logo_base64": "",
            "menus": "Menus",
            "menu_header_id": "Header Menu",
            "menu_footer_id": "Foter Menu",
            "copyright": "Copyright"
        },
        "title": {
            "creating": "Creating domain",
            "updating": "Updating domain",
            "index": "Domains"
        },
        "success": {
            "created": "Domain success created",
            "updated": "Domain success updated",
            "deleted": "Domain success deleted"
        }
    },
    "options": {
        "languages": [
            "ru",
            "ua",
            "en"
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains/meta`


<!-- END_22a8d9878f75bbacbc5c596e841f9d0b -->

<!-- START_6774f2235e212858a53054b7e1941a80 -->
## Domains bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/structure/domains/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | domain id.

<!-- END_6774f2235e212858a53054b7e1941a80 -->

<!-- START_57d3c3d8325d425e3007e480f17b82d7 -->
## Domains list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "alias": "scms.loc",
            "is_active": 1,
            "site_lang": "ru",
            "site_langs": [
                "ru",
                "ua",
                "en"
            ],
            "menus": null,
            "logo": null,
            "copyright": "Copyright: Praesentium totam sit ea."
        }
    ],
    "meta": {
        "pagination": {
            "total": 1,
            "count": 1,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {
                "next": null,
                "previous": null
            }
        }
    },
    "count": 1
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    alias | string |  optional  | optional Alias.
    is_active | integer |  optional  | optional Active. Value: 0, 1
    site_lang | string |  optional  | optional Domain default language
    copyright | string |  optional  | optional Domain copyright

<!-- END_57d3c3d8325d425e3007e480f17b82d7 -->

<!-- START_6cd4670abb2398d68d6fbe5570a67b0f -->
## Domains store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 98,
        "alias": "dietrich.com",
        "is_active": 1,
        "site_lang": "ru",
        "site_langs": [
            "ru",
            "ua",
            "en"
        ],
        "menus": null,
        "logo": null
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "alias": [
            "The Alias field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "site_lang": [
            "The Language field is required."
        ],
        "site_langs": [
            "The Languages field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/structure/domains`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    alias | string |  required  | Alias.
    is_active | integer |  required  | Active. Value: 0, 1
    site_lang | string |  required  | Domain default language
    site_langs | array |  required  | Domain languages
    logo_base64 | file |  optional  | optional Domain logo base64 encoded
    lang[copyright] | string |  optional  | optional Copyright text.

<!-- END_6cd4670abb2398d68d6fbe5570a67b0f -->

<!-- START_74c084015ec05ccdc7bee1c7d57bcabf -->
## Domains show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 100,
        "alias": "jast.com",
        "is_active": 1,
        "site_lang": "ua",
        "site_langs": [
            "ru",
            "ua",
            "en"
        ],
        "menus": null,
        "logo": null,
        "en": {
            "copyright": "Copyright: Corrupti modi aut modi nemo."
        },
        "ru": {
            "copyright": "Copyright: Eum voluptas blanditiis et."
        },
        "ua": {
            "copyright": "Copyright: Et nemo a provident enim qui."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Structure\\Models\\Domain] 100",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains/{domain}`


<!-- END_74c084015ec05ccdc7bee1c7d57bcabf -->

<!-- START_871c5db564a99ca413d93443be403f97 -->
## Domains update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 99,
        "alias": "cummings.biz",
        "is_active": 1,
        "site_lang": "en",
        "site_langs": [
            "ru",
            "ua",
            "en"
        ],
        "menus": null,
        "logo": null,
        "en": {
            "copyright": "Copyright: Ea qui est eos non."
        },
        "ru": {
            "copyright": "Copyright: Rerum et vel a accusamus."
        },
        "ua": {
            "copyright": "Copyright: Et inventore nam ea ducimus."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "alias": [
            "The Alias field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "site_lang": [
            "The Language field is required."
        ],
        "site_langs": [
            "The Languages field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Structure\\Models\\Domain] 99",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/structure/domains/{domain}`

`PATCH api/scms/structure/domains/{domain}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    alias | string |  required  | Alias.
    is_active | integer |  required  | Active. Value: 0, 1
    site_lang | string |  required  | Domain default language
    site_langs | array |  required  | Domain languages
    logo_base64 | file |  optional  | optional Domain logo base64 encoded
    lang[copyright] | string |  optional  | optional Copyright text.

<!-- END_871c5db564a99ca413d93443be403f97 -->

<!-- START_65fb5e109a38a0965b77668f26ed7d6f -->
## Domains destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```

### HTTP Request
`DELETE api/scms/structure/domains/{domain}`


<!-- END_65fb5e109a38a0965b77668f26ed7d6f -->

<!-- START_29e69bc8a39bc2cb71fad43250faec3f -->
## Pages meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "fields": {
            "id": "Id",
            "seo_title": "Seo Title",
            "seo_h1": "Seo H1",
            "seo_description": "Seo Description",
            "breacrumbs_title": "Breacrumbs Title",
            "head": "Head",
            "domain_id": "Domain",
            "template_id": "Template",
            "alias": "Alias",
            "is_search": "Available in search",
            "is_canonical": "Canonical page",
            "is_breadcrumbs": "Available in breadcrumb",
            "is_menu": "Available in menu"
        },
        "title": {
            "creating": "Creating page",
            "updating": "Updating page",
            "index": "Pages"
        },
        "success": {
            "created": "Page success created",
            "updated": "Page success updated",
            "deleted": "Page success deleted"
        }
    },
    "templates": [
        {
            "id": 1,
            "title": "Главная",
            "alias": "home",
            "layout": "main"
        },
        {
            "id": 2,
            "title": "Left",
            "alias": "left",
            "layout": "main"
        },
        {
            "id": 3,
            "title": "Right",
            "alias": "right",
            "layout": "main"
        }
    ]
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains/pages/meta`


<!-- END_29e69bc8a39bc2cb71fad43250faec3f -->

<!-- START_2722b727a25acf98cd653c91a099d04b -->
## Pages tree

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "id": 252,
    "structure_id": "000001",
    "template_id": 1,
    "alias": "index",
    "title": "Главная - haley.com",
    "blocks": [],
    "children": {
        "000001000001": {
            "id": 253,
            "structure_id": "000001000001",
            "template_id": 1,
            "alias": "contact",
            "title": "Cupiditate amet qui sed.",
            "blocks": [],
            "children": []
        },
        "000001000002": {
            "id": 254,
            "structure_id": "000001000002",
            "template_id": 1,
            "alias": "about",
            "title": "Error non quisquam officiis.",
            "blocks": [],
            "children": []
        },
        "000001000003": {
            "id": 255,
            "structure_id": "000001000003",
            "template_id": 1,
            "alias": "news",
            "title": "Quos sit vel explicabo aut.",
            "blocks": [],
            "children": {
                "000001000003000001": {
                    "id": 256,
                    "structure_id": "000001000003000001",
                    "template_id": 2,
                    "alias": "category",
                    "title": "Architecto et ipsum harum.",
                    "blocks": [],
                    "children": {
                        "000001000003000001000001": {
                            "id": 257,
                            "structure_id": "000001000003000001000001",
                            "template_id": 3,
                            "alias": "view",
                            "title": "Ut ab aut ea omnis.",
                            "blocks": [],
                            "children": []
                        }
                    }
                }
            }
        }
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Structure\\Models\\Domain] 103",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains/{domain}/pages`


<!-- END_2722b727a25acf98cd653c91a099d04b -->

<!-- START_5f67f740108a1d631a45cbf49a4feb68 -->
## Pages store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 264,
        "alias": "team",
        "domain_id": 104,
        "template_id": 3,
        "is_search": null,
        "is_canonical": 0,
        "is_breadcrumbs": 1,
        "is_menu": 0,
        "structure_id": "000001000004",
        "ru": {
            "seo_title": "Eveniet vel earum ratione.",
            "seo_h1": "Repellat odio qui.",
            "seo_description": "Tempore saepe nesciunt quidem rerum. Eum voluptatem molestiae consequatur.",
            "breacrumbs_title": "Praesentium quia.",
            "head": "Voluptatum ratione nihil repudiandae quia sed. Voluptates laudantium provident qui dolores soluta repellat quis itaque. Voluptas vitae et aut est sint qui."
        },
        "ua": {
            "seo_title": "Nesciunt eos ratione et aut.",
            "seo_h1": "Et saepe.",
            "seo_description": "Et provident sit dolores et similique. Aut adipisci quis totam earum. Voluptatem rerum in amet perspiciatis.",
            "breacrumbs_title": "Consequatur a.",
            "head": "Exercitationem sed molestiae ducimus at modi dolorem. Id dicta et at rem. Est et quia asperiores voluptatem."
        },
        "en": {
            "seo_title": "Aperiam aut ipsam sit.",
            "seo_h1": "Eligendi optio.",
            "seo_description": "Et nobis et rerum cumque natus. Eaque dolorem sint necessitatibus atque omnis. Nobis et illum voluptas atque.",
            "breacrumbs_title": "Fugiat fugit magni.",
            "head": "Recusandae ut deserunt dolor expedita placeat. Quam voluptates atque labore. Qui et provident suscipit rem minus sit. Id et iusto laborum voluptatum doloribus dolore."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "alias": [
            "The Alias field is required."
        ],
        "template_id": [
            "The Template field is required."
        ],
        "is_canonical": [
            "The Canonical page field is required."
        ],
        "is_breadcrumbs": [
            "The Available in breadcrumb field is required."
        ],
        "is_menu": [
            "The Available in menu field is required."
        ],
        "parent_id": [
            "The parent id field is required."
        ],
        "ru.seo_title": [
            "The Seo Title (ru) field is required."
        ],
        "ua.seo_title": [
            "The Seo Title (ua) field is required."
        ],
        "en.seo_title": [
            "The Seo Title (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Structure\\Models\\Domain] 103",
    "errors": []
}
```

### HTTP Request
`POST api/scms/structure/domains/{domain}/pages`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    alias | string |  required  | Alias.
    is_search | integer |  required  | Search
    is_canonical | integer |  required  | Canonical
    is_breadcrumbs | integer |  required  | Breadcrumbs
    is_menu | integer |  required  | Menu
    template_id | integer |  required  | Template
    parent_id | integer |  required  | Parent page - required only action store
    lang[seo_title] | string |  required  | Seo title
    lang[seo_h1] | string |  optional  | optional Seo h1
    lang[seo_description] | string |  optional  | optional Seo description
    lang[breacrumbs_title] | string |  optional  | optional Breacrumbs title
    lang[head] | string |  optional  | optional head

<!-- END_5f67f740108a1d631a45cbf49a4feb68 -->

<!-- START_df218b6c7c656eb4833f89b07fcdec71 -->
## Pages show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 271,
        "alias": "index",
        "domain_id": 106,
        "template_id": 1,
        "is_search": 1,
        "is_canonical": 0,
        "is_breadcrumbs": 1,
        "is_menu": 1,
        "structure_id": "000001",
        "en": {
            "seo_title": "Главная - conn.org",
            "seo_h1": null,
            "seo_description": null,
            "breacrumbs_title": null,
            "head": null
        },
        "ru": {
            "seo_title": "Главная - conn.org",
            "seo_h1": null,
            "seo_description": null,
            "breacrumbs_title": null,
            "head": null
        },
        "ua": {
            "seo_title": "Главная - conn.org",
            "seo_h1": null,
            "seo_description": null,
            "breacrumbs_title": null,
            "head": null
        }
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Structure\\Models\\Page] 271",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains/{domain}/pages/{page}`


<!-- END_df218b6c7c656eb4833f89b07fcdec71 -->

<!-- START_04f647fd159c62bed69c84d6146d7d02 -->
## Pages update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 265,
        "alias": "index",
        "domain_id": 105,
        "template_id": 1,
        "is_search": 1,
        "is_canonical": 0,
        "is_breadcrumbs": 1,
        "is_menu": 1,
        "structure_id": "000001",
        "en": {
            "seo_title": "Главная - schmitt.com",
            "seo_h1": null,
            "seo_description": null,
            "breacrumbs_title": null,
            "head": null
        },
        "ru": {
            "seo_title": "Главная - schmitt.com",
            "seo_h1": null,
            "seo_description": null,
            "breacrumbs_title": null,
            "head": null
        },
        "ua": {
            "seo_title": "Главная - schmitt.com",
            "seo_h1": null,
            "seo_description": null,
            "breacrumbs_title": null,
            "head": null
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "alias": [
            "The Alias field is required."
        ],
        "template_id": [
            "The Template field is required."
        ],
        "is_canonical": [
            "The Canonical page field is required."
        ],
        "is_breadcrumbs": [
            "The Available in breadcrumb field is required."
        ],
        "is_menu": [
            "The Available in menu field is required."
        ],
        "ru.seo_title": [
            "The Seo Title (ru) field is required."
        ],
        "ua.seo_title": [
            "The Seo Title (ua) field is required."
        ],
        "en.seo_title": [
            "The Seo Title (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "The POST method is not supported for this route. Supported methods: GET, HEAD, PUT, PATCH, DELETE.",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/structure/domains/{domain}/pages/{page}`

`PATCH api/scms/structure/domains/{domain}/pages/{page}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    alias | string |  required  | Alias.
    is_search | integer |  required  | Search
    is_canonical | integer |  required  | Canonical
    is_breadcrumbs | integer |  required  | Breadcrumbs
    is_menu | integer |  required  | Menu
    template_id | integer |  required  | Template
    parent_id | integer |  required  | Parent page - required only action store
    lang[seo_title] | string |  required  | Seo title
    lang[seo_h1] | string |  optional  | optional Seo h1
    lang[seo_description] | string |  optional  | optional Seo description
    lang[breacrumbs_title] | string |  optional  | optional Breacrumbs title
    lang[head] | string |  optional  | optional head

<!-- END_04f647fd159c62bed69c84d6146d7d02 -->

<!-- START_21c98535f3284ae01da3aaa73226f3f1 -->
## Pages destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```

### HTTP Request
`DELETE api/scms/structure/domains/{domain}/pages/{page}`


<!-- END_21c98535f3284ae01da3aaa73226f3f1 -->

<!-- START_5e1afde8f26ff086a4f5147332b2aa6b -->
## Pages move

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 286,
        "alias": "news",
        "domain_id": 108,
        "template_id": 2,
        "is_search": 0,
        "is_canonical": 0,
        "is_breadcrumbs": 1,
        "is_menu": 1,
        "structure_id": "000002",
        "en": {
            "seo_title": "Non porro omnis dolores.",
            "seo_h1": "Incidunt suscipit.",
            "seo_description": "Ut non nostrum doloribus error corporis unde. Eos accusantium vel veritatis consequatur nostrum.",
            "breacrumbs_title": "Sit eum reiciendis.",
            "head": "Molestiae qui molestiae earum aliquam aut incidunt. Ex ad atque et asperiores omnis. Deleniti est totam sit inventore assumenda. Ea aut cum cum harum."
        },
        "ru": {
            "seo_title": "Est eos amet eligendi.",
            "seo_h1": "In similique non ab.",
            "seo_description": "Quod quis quod non. Et quas rem ut. Veritatis amet eos officia molestias exercitationem.",
            "breacrumbs_title": "Magni odit in at.",
            "head": "Voluptatum qui nihil enim et itaque sed. Aspernatur et placeat autem assumenda vel. Est facere tempore qui dolore quasi officia. Voluptatum repellat temporibus cupiditate cum omnis ullam eum."
        },
        "ua": {
            "seo_title": "A aut omnis modi.",
            "seo_h1": "Blanditiis.",
            "seo_description": "Sed architecto nihil atque ea numquam corrupti. Cum beatae et at sequi provident. Ab sit praesentium ad qui.",
            "breacrumbs_title": "Eveniet sed velit.",
            "head": "Animi dicta nulla et et quia. Ex ad doloribus dolorem qui minima explicabo fugit. Molestias sunt dolores aut accusamus. Est nesciunt dolores et repellendus velit illo. Sunt et rerum enim est autem."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "parent_id": [
            "The parent id field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/structure/domains/{domain}/pages/{page}/move`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    parent_id | integer |  required  | Parent page

<!-- END_5e1afde8f26ff086a4f5147332b2aa6b -->

<!-- START_8ca6691be2f77fd689365caea7f30e91 -->
## Pages copy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 295,
        "alias": "news-1",
        "domain_id": 109,
        "template_id": 3,
        "is_search": 0,
        "is_canonical": 0,
        "is_breadcrumbs": 1,
        "is_menu": 1,
        "structure_id": "000001000004",
        "en": {
            "seo_title": "Alias quia et iure ut fugit.",
            "seo_h1": "Et facere et quos.",
            "seo_description": "Veniam tenetur eos et aut. Molestias cum qui ea maxime numquam. Quas non facere ut occaecati. Non in ratione explicabo.",
            "breacrumbs_title": "Dolore quaerat.",
            "head": "Ex odit fugit quia blanditiis sed illum laborum. Voluptate quis qui totam eum. Tenetur magnam iste architecto quia unde nihil quisquam ullam."
        },
        "ru": {
            "seo_title": "Non molestiae ut quo.",
            "seo_h1": "Earum saepe non.",
            "seo_description": "Totam ipsa quidem dolores adipisci ipsam. Rerum a qui molestias. Neque facere dicta quo et voluptas sapiente et.",
            "breacrumbs_title": "Quod corporis.",
            "head": "Voluptatem error aperiam nostrum quidem. Deleniti rerum labore ratione et. Quibusdam aliquam modi occaecati cum iste distinctio tenetur. Voluptatum illum et laudantium."
        },
        "ua": {
            "seo_title": "Non amet quo dicta et enim.",
            "seo_h1": "Illum dolor nulla.",
            "seo_description": "Alias occaecati pariatur quod veniam quas unde magni. Dolorem et non dolorum et. Neque et dolore incidunt quae.",
            "breacrumbs_title": "Totam omnis rerum.",
            "head": "Modi et officiis expedita dolore quas. Voluptatibus ducimus dolores perspiciatis veniam rem dignissimos est. Nesciunt maxime sit sunt et quia voluptas molestiae."
        }
    }
}
```

### HTTP Request
`POST api/scms/structure/domains/{domain}/pages/{page}/copy`


<!-- END_8ca6691be2f77fd689365caea7f30e91 -->

<!-- START_7ed6be31884d40bcdfe08a31fc5d777c -->
## Blocks meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "fields": {
            "action": "Action",
            "alias": "Template area alias",
            "widget_id": "Widget ID"
        },
        "title": {
            "creating": "Creating block",
            "updating": "Updating block",
            "index": "Blocks"
        },
        "success": {
            "created": "Block success created",
            "updated": "Block success updated",
            "deleted": "Block success deleted"
        }
    },
    "widgets": [
        {
            "id": "Menu",
            "name": "Menu",
            "config": [
                {
                    "name": "action",
                    "label": "Action",
                    "type": "select",
                    "options": {
                        "index": "Show menu"
                    }
                },
                {
                    "name": "template",
                    "label": "Template",
                    "type": "select",
                    "options": {
                        "header": "Header",
                        "footer": "Footer"
                    }
                },
                {
                    "name": "menu_id",
                    "label": "Menu",
                    "type": "select",
                    "options": {
                        "1": "11111111111111111111",
                        "2": "11111111111111111111",
                        "3": "11111111111111111111",
                        "4": "11111111111111111111",
                        "5": "11111111111111111111",
                        "6": "11111111111111111111",
                        "7": "11111111111111111111",
                        "8": "11111111111111111111",
                        "9": "11111111111111111111",
                        "10": "11111111111111111111",
                        "11": "11111111111111111111"
                    }
                }
            ]
        },
        {
            "id": "User",
            "name": "User",
            "config": [
                {
                    "name": "action",
                    "label": "Action",
                    "type": "select",
                    "options": {
                        "index": "contentBlock::widget.actions.index"
                    }
                }
            ]
        }
    ]
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains/blocks/meta`


<!-- END_7ed6be31884d40bcdfe08a31fc5d777c -->

<!-- START_2b3a0b85521346c4c6f7d826a167d731 -->
## Block show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "template": "empty",
    "block_id": 27,
    "widget_id": "ContentBlock",
    "alias": null,
    "action": "index",
    "contentBlockFetchService": [],
    "meta": {
        "id": "ContentBlock",
        "name": "Content Blocks",
        "config": [
            {
                "name": "action",
                "label": "Action",
                "type": "select",
                "options": {
                    "index": "Show Content Block"
                }
            },
            {
                "name": "template",
                "label": "Template",
                "type": "select",
                "options": {
                    "empty": "Only content",
                    "title_content": "Title + Content"
                }
            },
            {
                "name": "block_id",
                "label": "Block",
                "type": "select",
                "options": {
                    "1": "Earum et et enim. Dolorem et dolore eius consequatur. Earum ipsam libero dolor optio optio animi.",
                    "27": "In quasi cum ab quis. Officia quia adipisci dolores. Voluptates et eius quia neque."
                }
            }
        ]
    }
}
```
> Example response (204):

```json
[]
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains/{domain}/pages/{page}/blocks/{alias}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    alias | string |  required  | Template area Alias.

<!-- END_2b3a0b85521346c4c6f7d826a167d731 -->

<!-- START_863d5daf7033b38df1d0d077590a8a14 -->
## Blocks index

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "content1": {
        "widget_id": "ContentBlock",
        "action": "index"
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/structure/domains/{domain}/pages/{page}/blocks`


<!-- END_863d5daf7033b38df1d0d077590a8a14 -->

<!-- START_93e765134d3b4f52f024757c593c9d31 -->
## Blocks destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```

### HTTP Request
`DELETE api/scms/structure/domains/{domain}/pages/{page}/blocks/{alias}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    alias | string |  required  | Template area Alias.

<!-- END_93e765134d3b4f52f024757c593c9d31 -->

<!-- START_4cdf1a52f9d569e8c41c68fb7171f350 -->
## Blocks insert

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "alias": [
            "The Template area alias field is required."
        ],
        "widget_id": [
            "The Widget ID field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/structure/domains/{domain}/pages/{page}/blocks`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    alias | string |  required  | Template area Alias.
    widget_id | string |  required  | Widget id

<!-- END_4cdf1a52f9d569e8c41c68fb7171f350 -->

#TARIFF


<!-- START_ccfa805f14db14ad3ac6321e2ab8ea1a -->
## OperatingSystems meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "title": {
            "creating": "Creating OperatingSystem",
            "updating": "Updating OperatingSystem",
            "index": "OperatingSystems"
        },
        "success": {
            "created": "OperatingSystem success created",
            "updated": "OperatingSystem success updated",
            "deleted": "OperatingSystems success deleted"
        },
        "fields": {
            "image": "Image",
            "image_base64": "Image",
            "svg_code": "SVG code",
            "is_active": "Active",
            "rank": "Rank",
            "title": "Title"
        },
        "description": {
            "image": "",
            "image_base64": "",
            "svg_code": "",
            "is_active": "",
            "rank": "",
            "title": ""
        }
    },
    "default": {
        "is_active": 1,
        "rank": 901
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/operating-systems/meta`


<!-- END_ccfa805f14db14ad3ac6321e2ab8ea1a -->

<!-- START_ea8c28286b0eb40ff5673ad5c2396c3e -->
## OperatingSystems bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/tariff/operating-systems/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | OperatingSystem id.

<!-- END_ea8c28286b0eb40ff5673ad5c2396c3e -->

<!-- START_b572293b0e8f3565fa9aa95b580e2e3e -->
## OperatingSystems list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "image": "\/uploads\/20\/01\/29\/beatae-r_100x75.jpg",
            "is_active": 0,
            "rank": 313,
            "title": "Aut nam nihil natus possimus aliquid voluptas."
        },
        {
            "id": 2,
            "image": "\/uploads\/20\/01\/29\/rem-r_100x75.jpg",
            "is_active": 1,
            "rank": 597,
            "title": "Repudiandae eos ut eum."
        }
    ],
    "meta": {
        "pagination": {
            "total": 13,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 2,
            "links": {
                "next": "http:\/\/scms.loc\/api\/scms\/tariff\/operating-systems?page=2",
                "previous": null
            }
        }
    },
    "count": 13
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/operating-systems`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    is_active | integer |  optional  | optional    Active
    rank | integer |  optional  | optional    Rank
    title | string |  optional  | optional    Title

<!-- END_b572293b0e8f3565fa9aa95b580e2e3e -->

<!-- START_5fa7f1374356f56fa78b086a856acbbb -->
## OperatingSystems store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 14,
        "image": null,
        "svg_code": null,
        "is_active": 0,
        "rank": 50,
        "title": "Ut aliquam voluptatum cumque ipsa unde qui.",
        "ru": {
            "title": "Rerum dolores quidem quibusdam aut culpa ipsam."
        },
        "ua": {
            "title": "Rerum saepe aut enim est."
        },
        "en": {
            "title": "Ut aliquam voluptatum cumque ipsa unde qui."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/tariff/operating-systems`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | image |  optional  | optional  Image
    svg_code | string |  optional  | optional  SVG code
    is_active | integer |  required  | Active
    rank | integer |  required  | Rank
    lang[title] | string |  required  | Title

<!-- END_5fa7f1374356f56fa78b086a856acbbb -->

<!-- START_6732fcd9714601e2eb675dbb87b7bb17 -->
## OperatingSystems show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 16,
        "image": "\/uploads\/20\/01\/29\/ducimus-r_100x75.jpg",
        "svg_code": null,
        "is_active": 1,
        "rank": 767,
        "title": "Porro eum natus ab veniam rerum ad dicta.",
        "en": {
            "title": "Porro eum natus ab veniam rerum ad dicta."
        },
        "ru": {
            "title": "Ipsa iusto sint consectetur possimus."
        },
        "ua": {
            "title": "Aut dolor odit vero quisquam."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\OperatingSystem] 16",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/operating-systems/{operating_system}`


<!-- END_6732fcd9714601e2eb675dbb87b7bb17 -->

<!-- START_b06aca4e11f65d09fa9f8c5388f5be35 -->
## OperatingSystems update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 15,
        "image": "\/uploads\/20\/01\/29\/totam-r_100x75.jpg",
        "svg_code": null,
        "is_active": 1,
        "rank": 158,
        "title": "Et autem labore vel sed delectus.",
        "en": {
            "title": "Et autem labore vel sed delectus."
        },
        "ru": {
            "title": "Inventore vitae officiis sapiente veniam tempore."
        },
        "ua": {
            "title": "Harum minus ullam ut in sit."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\OperatingSystem] 15",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/tariff/operating-systems/{operating_system}`

`PATCH api/scms/tariff/operating-systems/{operating_system}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | image |  optional  | optional  Image
    svg_code | string |  optional  | optional  SVG code
    is_active | integer |  required  | Active
    rank | integer |  required  | Rank
    lang[title] | string |  required  | Title

<!-- END_b06aca4e11f65d09fa9f8c5388f5be35 -->

<!-- START_2d2305e811a12b5b0da952948e1647f1 -->
## OperatingSystems destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\OperatingSystem] 17",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/tariff/operating-systems/{operating_system}`


<!-- END_2d2305e811a12b5b0da952948e1647f1 -->

<!-- START_21e241bb4f8ba33129990b5311f919e4 -->
## Periods meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "title": {
            "creating": "Creating Period",
            "updating": "Updating Period",
            "index": "Periods"
        },
        "success": {
            "created": "Period success created",
            "updated": "Period success updated",
            "deleted": "Periods success deleted"
        },
        "fields": {
            "is_active": "Active",
            "rank": "Rank",
            "title": "Title"
        },
        "description": {
            "is_active": "",
            "rank": "",
            "title": ""
        }
    },
    "default": {
        "is_active": 1,
        "rank": 761
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/periods/meta`


<!-- END_21e241bb4f8ba33129990b5311f919e4 -->

<!-- START_298eecc8ceb817c90771febbc9cba6f5 -->
## Periods bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/tariff/periods/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | Period id.

<!-- END_298eecc8ceb817c90771febbc9cba6f5 -->

<!-- START_afcf40e54da29b20113e55ceb6a19937 -->
## Periods list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "is_active": 1,
            "rank": 625,
            "title": "Suscipit accusamus ea sint atque doloribus."
        },
        {
            "id": 2,
            "is_active": 0,
            "rank": 513,
            "title": "Quia ut quisquam ut maiores mollitia ea nihil."
        }
    ],
    "meta": {
        "pagination": {
            "total": 13,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 2,
            "links": {
                "next": "http:\/\/scms.loc\/api\/scms\/tariff\/periods?page=2",
                "previous": null
            }
        }
    },
    "count": 13
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/periods`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    is_active | integer |  optional  | optional    Active
    rank | integer |  optional  | optional    Rank
    title | string |  optional  | optional    Title

<!-- END_afcf40e54da29b20113e55ceb6a19937 -->

<!-- START_5c9d0441dc46ed2ea1a6568bafd82f3e -->
## Periods store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 22,
        "is_active": 1,
        "rank": 475,
        "title": "Iusto sunt ex et hic ad animi provident.",
        "ru": {
            "title": "Neque perferendis quaerat iure."
        },
        "ua": {
            "title": "Ut inventore dignissimos ut at aut."
        },
        "en": {
            "title": "Iusto sunt ex et hic ad animi provident."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/tariff/periods`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    is_active | integer |  required  | Active
    rank | integer |  required  | Rank
    lang[title] | string |  required  | Title

<!-- END_5c9d0441dc46ed2ea1a6568bafd82f3e -->

<!-- START_28fe75e9d7bc862be3ec4608c4d56d72 -->
## Periods show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 24,
        "is_active": 0,
        "rank": 537,
        "title": "Nisi aut consectetur eos.",
        "en": {
            "title": "Nisi aut consectetur eos."
        },
        "ru": {
            "title": "Vitae sunt neque et quis debitis itaque possimus."
        },
        "ua": {
            "title": "Omnis facere delectus qui voluptate porro."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Period] 24",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/periods/{period}`


<!-- END_28fe75e9d7bc862be3ec4608c4d56d72 -->

<!-- START_8878a61d7ff8b7fa468c386a1a8e5735 -->
## Periods update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 23,
        "is_active": 0,
        "rank": 653,
        "title": "Modi vel quia dolore sint.",
        "en": {
            "title": "Modi vel quia dolore sint."
        },
        "ru": {
            "title": "Iure excepturi qui repudiandae quia."
        },
        "ua": {
            "title": "Officia et illo ea consequatur voluptatem dolor."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Period] 23",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/tariff/periods/{period}`

`PATCH api/scms/tariff/periods/{period}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    is_active | integer |  required  | Active
    rank | integer |  required  | Rank
    lang[title] | string |  required  | Title

<!-- END_8878a61d7ff8b7fa468c386a1a8e5735 -->

<!-- START_a3bac248a6a7439cceb3d191d02d8ee6 -->
## Periods destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Period] 25",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/tariff/periods/{period}`


<!-- END_a3bac248a6a7439cceb3d191d02d8ee6 -->

<!-- START_3508ad46a7e2be66c48923e735e6afd3 -->
## Currencies meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "title": {
            "creating": "Creating Currency",
            "updating": "Updating Currency",
            "index": "Currencies"
        },
        "success": {
            "created": "Currency success created",
            "updated": "Currency success updated",
            "deleted": "Currencies success deleted"
        },
        "fields": {
            "is_active": "Active",
            "code": "Code",
            "title": "Title"
        },
        "description": {
            "is_active": "",
            "code": "",
            "title": ""
        }
    },
    "default": {
        "is_active": 1
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/currencies/meta`


<!-- END_3508ad46a7e2be66c48923e735e6afd3 -->

<!-- START_87872c5e7440db58906f2704599c6e64 -->
## Currencies bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/tariff/currencies/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | Currency id.

<!-- END_87872c5e7440db58906f2704599c6e64 -->

<!-- START_170a64923a183abf78573d5aac10e7d2 -->
## Currencies list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "is_active": 1,
            "code": "EUR",
            "title": "esse"
        },
        {
            "id": 2,
            "is_active": 1,
            "code": "RUB",
            "title": "voluptatum"
        }
    ],
    "meta": {
        "pagination": {
            "total": 5,
            "count": 5,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {
                "next": null,
                "previous": null
            }
        }
    },
    "count": 5
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/currencies`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    is_active | integer |  optional  | optional    Active
    code | string |  optional  | optional    Code
    title | string |  optional  | optional    Title

<!-- END_170a64923a183abf78573d5aac10e7d2 -->

<!-- START_89ae3db4a921dd9bb8b21047054b6ee3 -->
## Currencies store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 14,
        "is_active": 0,
        "code": "RUB",
        "title": "nulla",
        "ru": {
            "title": "cupiditate"
        },
        "ua": {
            "title": "nihil"
        },
        "en": {
            "title": "nulla"
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "code": [
            "The Code field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/tariff/currencies`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    is_active | integer |  required  | Active
    code | string |  required  | Code
    lang[title] | string |  required  | Title

<!-- END_89ae3db4a921dd9bb8b21047054b6ee3 -->

<!-- START_f23cd10557c051fd96be896ab01071d5 -->
## Currencies show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 16,
        "is_active": 0,
        "code": "UAH",
        "title": "quos",
        "en": {
            "title": "quos"
        },
        "ru": {
            "title": "quod"
        },
        "ua": {
            "title": "quod"
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Currency] 16",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/currencies/{currency}`


<!-- END_f23cd10557c051fd96be896ab01071d5 -->

<!-- START_070673e2548395ce48fa34ef6d6e91c6 -->
## Currencies update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 15,
        "is_active": 1,
        "code": "USD",
        "title": "voluptas",
        "en": {
            "title": "voluptas"
        },
        "ru": {
            "title": "ex"
        },
        "ua": {
            "title": "nihil"
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "is_active": [
            "The Active field is required."
        ],
        "code": [
            "The Code field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Currency] 15",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/tariff/currencies/{currency}`

`PATCH api/scms/tariff/currencies/{currency}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    is_active | integer |  required  | Active
    code | string |  required  | Code
    lang[title] | string |  required  | Title

<!-- END_070673e2548395ce48fa34ef6d6e91c6 -->

<!-- START_51a0946db66efa8278c879ad5fb2ac4f -->
## Currencies destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Currency] 17",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/tariff/currencies/{currency}`


<!-- END_51a0946db66efa8278c879ad5fb2ac4f -->

<!-- START_7b4eb7130161a436f65537fc29c9639a -->
## Tariffs meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "title": {
            "creating": "Creating Tariff",
            "updating": "Updating Tariff",
            "index": "Tariffs"
        },
        "success": {
            "created": "Tariff success created",
            "updated": "Tariff success updated",
            "deleted": "Tariffs success deleted"
        },
        "fields": {
            "operating_system_id": "Operating system",
            "period_id": "Period",
            "currency_id": "Currency",
            "is_active": "Active",
            "ram": "RAM",
            "cpu": "CPU",
            "hdd": "HDD",
            "rank": "Rank",
            "title": "Title"
        },
        "description": {
            "operating_system_id": "",
            "period_id": "",
            "currency_id": "",
            "is_active": "",
            "ram": "",
            "cpu": "",
            "hdd": "",
            "rank": "",
            "title": ""
        }
    },
    "default": {
        "is_active": 1,
        "rank": 10
    },
    "options": {
        "operatingSystems": [
            {
                "value": 1,
                "text": "Aut nam nihil natus possimus aliquid voluptas."
            },
            {
                "value": 2,
                "text": "Repudiandae eos ut eum."
            },
            {
                "value": 3,
                "text": "A neque delectus dolore eos repellendus et ut."
            },
            {
                "value": 4,
                "text": "Possimus est deleniti et et aut est."
            },
            {
                "value": 5,
                "text": "Veniam sint molestiae eius sit eos."
            },
            {
                "value": 6,
                "text": "Voluptatem mollitia ea fugit molestiae."
            },
            {
                "value": 7,
                "text": "Quod quo maiores vero corrupti."
            },
            {
                "value": 8,
                "text": "Ut placeat atque corrupti culpa nulla et."
            },
            {
                "value": 9,
                "text": "Porro et cupiditate aut dolorem officiis."
            },
            {
                "value": 10,
                "text": "Et possimus minima at porro animi."
            }
        ],
        "periods": [
            {
                "value": 1,
                "text": "Suscipit accusamus ea sint atque doloribus."
            },
            {
                "value": 2,
                "text": "Quia ut quisquam ut maiores mollitia ea nihil."
            },
            {
                "value": 3,
                "text": "Facere vero ratione temporibus quod labore est."
            },
            {
                "value": 4,
                "text": "Et ipsa ducimus libero quo maiores."
            },
            {
                "value": 5,
                "text": "Id vero nesciunt quibusdam est est."
            },
            {
                "value": 6,
                "text": "Neque non qui at et impedit."
            },
            {
                "value": 7,
                "text": "Laboriosam et itaque et."
            },
            {
                "value": 8,
                "text": "Aut molestiae aliquam qui fugiat."
            },
            {
                "value": 9,
                "text": "Fugiat aut ut consequuntur veritatis dolorem."
            },
            {
                "value": 10,
                "text": "Eligendi laudantium sit unde qui omnis ea."
            }
        ],
        "currencies": [
            {
                "value": 1,
                "text": "EUR"
            },
            {
                "value": 2,
                "text": "RUB"
            }
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/tariffs/meta`


<!-- END_7b4eb7130161a436f65537fc29c9639a -->

<!-- START_c3ffae5faf66d616895c203dcd39e6e5 -->
## Tariffs bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/tariff/tariffs/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | Tariff id.

<!-- END_c3ffae5faf66d616895c203dcd39e6e5 -->

<!-- START_6f30c8fc67d9abdbab66877eca2929ed -->
## Tariffs list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 19,
            "operating_system_id": 2,
            "period_id": 5,
            "currency_id": 2,
            "is_active": 1,
            "ram": "4 GB RAM",
            "cpu": "8 Core vCPU",
            "hdd": "80 GB SSD",
            "rank": 268,
            "title": "Et reiciendis ut ipsa voluptate."
        },
        {
            "id": 20,
            "operating_system_id": 10,
            "period_id": 8,
            "currency_id": 2,
            "is_active": 0,
            "ram": "8 GB RAM",
            "cpu": "12 Core vCPU",
            "hdd": "120 GB SSD",
            "rank": 57,
            "title": "Sint fugit nisi quia est et et laboriosam."
        }
    ],
    "meta": {
        "pagination": {
            "total": 3,
            "count": 3,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {
                "next": null,
                "previous": null
            }
        }
    },
    "count": 3
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/tariffs`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    operating_system_id | integer |  optional  | optional    Operating system
    period_id | integer |  optional  | optional    Period
    currency_id | integer |  optional  | optional    Currency
    is_active | integer |  optional  | optional    Active
    ram | string |  optional  | optional    RAM
    cpu | string |  optional  | optional    CPU
    hdd | string |  optional  | optional    HDD
    rank | integer |  optional  | optional    Rank
    title | string |  optional  | optional    Title

<!-- END_6f30c8fc67d9abdbab66877eca2929ed -->

<!-- START_b58a61394354d02ee15174bf926fb891 -->
## Tariffs store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 22,
        "operating_system_id": 10,
        "period_id": 6,
        "currency_id": 2,
        "is_active": 0,
        "ram": "8 GB RAM",
        "cpu": "2 Core vCPU",
        "hdd": "80 GB SSD",
        "rank": 888,
        "title": "Vero maiores atque voluptate a.",
        "ru": {
            "title": "Numquam vel est suscipit numquam."
        },
        "ua": {
            "title": "Et cumque numquam omnis."
        },
        "en": {
            "title": "Vero maiores atque voluptate a."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "operating_system_id": [
            "The Operating system field is required."
        ],
        "period_id": [
            "The Period field is required."
        ],
        "currency_id": [
            "The Currency field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "ram": [
            "The RAM field is required."
        ],
        "cpu": [
            "The CPU field is required."
        ],
        "hdd": [
            "The HDD field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/tariff/tariffs`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    operating_system_id | integer |  required  | Operating system
    period_id | integer |  required  | Period
    currency_id | integer |  required  | Currency
    is_active | integer |  required  | Active
    ram | string |  required  | RAM
    cpu | string |  required  | CPU
    hdd | string |  required  | HDD
    rank | integer |  required  | Rank
    lang[title] | string |  required  | Title

<!-- END_b58a61394354d02ee15174bf926fb891 -->

<!-- START_d95640374964dc065fb99c58c7832c96 -->
## Tariffs show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 24,
        "operating_system_id": 3,
        "period_id": 5,
        "currency_id": 2,
        "is_active": 1,
        "ram": "4 GB RAM",
        "cpu": "8 Core vCPU",
        "hdd": "40 GB SSD",
        "rank": 711,
        "title": "Consequatur voluptas vel ad est.",
        "en": {
            "title": "Consequatur voluptas vel ad est."
        },
        "ru": {
            "title": "Harum facilis qui dolore magnam dolorem aut ut."
        },
        "ua": {
            "title": "Omnis sed facilis est enim."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Tariff] 24",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/tariff/tariffs/{tariff}`


<!-- END_d95640374964dc065fb99c58c7832c96 -->

<!-- START_7a03c399115bd9ab8fffff890aee61a4 -->
## Tariffs update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 23,
        "operating_system_id": 2,
        "period_id": 2,
        "currency_id": 2,
        "is_active": 0,
        "ram": "2 GB RAM",
        "cpu": "6 Core vCPU",
        "hdd": "40 GB SSD",
        "rank": 622,
        "title": "Quo voluptatem error ut quidem nisi aut deserunt.",
        "en": {
            "title": "Quo voluptatem error ut quidem nisi aut deserunt."
        },
        "ru": {
            "title": "Aliquid eaque qui ea fugiat quibusdam esse."
        },
        "ua": {
            "title": "Nemo ut perspiciatis enim ut hic."
        }
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "operating_system_id": [
            "The Operating system field is required."
        ],
        "period_id": [
            "The Period field is required."
        ],
        "currency_id": [
            "The Currency field is required."
        ],
        "is_active": [
            "The Active field is required."
        ],
        "ram": [
            "The RAM field is required."
        ],
        "cpu": [
            "The CPU field is required."
        ],
        "hdd": [
            "The HDD field is required."
        ],
        "rank": [
            "The Rank field is required."
        ],
        "ru.title": [
            "The Title (ru) field is required."
        ],
        "ua.title": [
            "The Title (ua) field is required."
        ],
        "en.title": [
            "The Title (en) field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Tariff] 23",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/tariff/tariffs/{tariff}`

`PATCH api/scms/tariff/tariffs/{tariff}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    operating_system_id | integer |  required  | Operating system
    period_id | integer |  required  | Period
    currency_id | integer |  required  | Currency
    is_active | integer |  required  | Active
    ram | string |  required  | RAM
    cpu | string |  required  | CPU
    hdd | string |  required  | HDD
    rank | integer |  required  | Rank
    lang[title] | string |  required  | Title

<!-- END_7a03c399115bd9ab8fffff890aee61a4 -->

<!-- START_824790c5a7d7eefde20366eaa99be27a -->
## Tariffs destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\Tariff\\Models\\Tariff] 25",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/tariff/tariffs/{tariff}`


<!-- END_824790c5a7d7eefde20366eaa99be27a -->

#USER


<!-- START_2d70d8db24a85f502c81bd3b859b78dc -->
## Users meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "fields": {
            "id": "Id",
            "name": "Name",
            "email": "E-mail",
            "is_active": "Active",
            "position": "position",
            "image_file": "Image",
            "image": "Image",
            "password": "Password",
            "roles": "Roles",
            "created_at": "Created",
            "updated_at": "Updated"
        },
        "description": {
            "id": "Id",
            "name": "Name",
            "email": "E-mail",
            "is_active": "Active",
            "position": "position",
            "image_file": "Image",
            "image": "Image",
            "password": "Password",
            "roles": "Roles",
            "created_at": "Created",
            "updated_at": "Updated"
        },
        "title": {
            "creating": "Creating user",
            "updating": "Updating user",
            "index": "Users"
        },
        "success": {
            "created": "User success created",
            "updated": "User success updated",
            "deleted": "User success deleted"
        }
    },
    "roles": {
        "1": "Admin",
        "2": "User",
        "3": "Unverified"
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/user/users/meta`


<!-- END_2d70d8db24a85f502c81bd3b859b78dc -->

<!-- START_d8310b6cb36e1399956d081edfe6b660 -->
## Users update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 1228,
        "name": "Miss Leilani Terry V",
        "is_active": 1,
        "email": "mayra18@example.com",
        "position": null,
        "created_at": "2020-01-29 12:22:53",
        "updated_at": "2020-01-29 12:22:53",
        "image": null,
        "roles": []
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "email": [
            "The E-mail field is required."
        ],
        "name": [
            "The Name field is required."
        ],
        "is_active": [
            "The Active field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\User\\Models\\User] 1228",
    "errors": []
}
```

### HTTP Request
`POST api/scms/user/users/{user}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | name.
    email | string |  required  | email.
    is_active | integer |  required  | active.
    password | string |  optional  | optional password (required only create action)
    image_file | file |  optional  | optional user photo
    position | string |  optional  | optional user position
    roles | array |  optional  | optional roles.
    roles.* | integer |  optional  | optional roles item.

<!-- END_d8310b6cb36e1399956d081edfe6b660 -->

<!-- START_02afeb5533bfbd84008c96c03b483cfc -->
## Users bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/user/users/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | user id.

<!-- END_02afeb5533bfbd84008c96c03b483cfc -->

<!-- START_e8c7c354c6c53a0affd6da6879a7a41d -->
## Users list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "name": "LS",
            "is_active": 1,
            "email": "ls@sunbee.studio",
            "position": "Designer",
            "created_at": "2020-01-15 19:54:51",
            "updated_at": "2020-01-15 19:54:51",
            "image": null,
            "name_roles": "Admin"
        },
        {
            "id": 2,
            "name": "VD",
            "is_active": 1,
            "email": "vasyldorosh@gmail.com",
            "position": "Backend developer",
            "created_at": "2020-01-15 19:54:51",
            "updated_at": "2020-01-29 12:14:08",
            "image": "\/uploads\/20\/01\/18\/zvuzv5ps-r_60x80.jpeg",
            "name_roles": "Admin"
        }
    ],
    "meta": {
        "pagination": {
            "total": 10,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {
                "next": null,
                "previous": null
            }
        }
    },
    "count": 10
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/user/users`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    name | string |  optional  | optional name.
    email | string |  optional  | optional email.
    is_active | integer |  optional  | optional active.
    position | string |  optional  | optional user position

<!-- END_e8c7c354c6c53a0affd6da6879a7a41d -->

<!-- START_ca90c040f0c2aed316495639822bedd5 -->
## Users store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 1226,
        "name": "Josefa Trantow",
        "is_active": 1,
        "email": "julian11@example.net",
        "position": null,
        "created_at": "2020-01-29 12:22:52",
        "updated_at": "2020-01-29 12:22:52",
        "image": null,
        "roles": []
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "email": [
            "The E-mail field is required."
        ],
        "name": [
            "The Name field is required."
        ],
        "password": [
            "The Password field is required."
        ],
        "is_active": [
            "The Active field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/user/users`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | name.
    email | string |  required  | email.
    is_active | integer |  required  | active.
    password | string |  optional  | optional password (required only create action)
    image_file | file |  optional  | optional user photo
    position | string |  optional  | optional user position
    roles | array |  optional  | optional roles.
    roles.* | integer |  optional  | optional roles item.

<!-- END_ca90c040f0c2aed316495639822bedd5 -->

<!-- START_2417b63550c8f786f8a6582b4a5f01ba -->
## Users show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 1230,
        "name": "Dexter Robel",
        "is_active": 1,
        "email": "witting.amina@example.com",
        "position": null,
        "created_at": "2020-01-29 12:22:53",
        "updated_at": "2020-01-29 12:22:53",
        "image": null,
        "roles": []
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\User\\Models\\User] 1230",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/user/users/{user}`


<!-- END_2417b63550c8f786f8a6582b4a5f01ba -->

<!-- START_3778864f954682c23d7061e6cd3ad8d3 -->
## Users destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\User\\Models\\User] 1232",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/user/users/{user}`


<!-- END_3778864f954682c23d7061e6cd3ad8d3 -->

<!-- START_103ca72d18eb666e94c52e75d38259ff -->
## Roles meta

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "labels": {
        "fields": {
            "id": "Id",
            "name": "Name",
            "slug": "Slug",
            "description": "Description",
            "permissions": "Permissions"
        },
        "description": {
            "id": "Id",
            "name": "Name",
            "slug": "Slug",
            "description": "Description",
            "permissions": "Permissions"
        },
        "title": {
            "creating": "Creating role",
            "updating": "Updating role",
            "index": "Roles"
        },
        "success": {
            "created": "Role success created",
            "updated": "Role success updated",
            "deleted": "Role success deleted"
        }
    },
    "permissions": {
        "1": "event.event.index",
        "2": "event.event.store",
        "3": "event.event.update",
        "4": "event.event.destroy",
        "5": "event.event.show",
        "6": "event.queue.index",
        "7": "event.queue.destroy",
        "8": "event.queue.show",
        "9": "log.log.index",
        "10": "log.log.destroy",
        "11": "menu.menu.index",
        "12": "menu.menu.store",
        "13": "menu.menu.update",
        "14": "menu.menu.show",
        "15": "menu.menu.destroy",
        "16": "menu.item.index",
        "17": "menu.item.store",
        "18": "menu.item.update",
        "19": "menu.item.show",
        "20": "menu.item.destroy",
        "21": "structure.domain.index",
        "22": "structure.domain.store",
        "23": "structure.domain.update",
        "24": "structure.domain.destroy",
        "25": "structure.domain.show",
        "26": "structure.page.index",
        "27": "structure.page.store",
        "28": "structure.page.update",
        "29": "structure.page.destroy",
        "30": "structure.page.show",
        "31": "structure.page.move",
        "32": "structure.page.copy",
        "33": "structure.block.index",
        "34": "structure.block.insert",
        "35": "structure.block.destroy",
        "36": "user.user.index",
        "37": "user.user.store",
        "38": "user.user.update",
        "39": "user.user.destroy",
        "40": "user.user.show",
        "41": "user.role.index",
        "42": "user.role.store",
        "43": "user.role.update",
        "44": "user.role.destroy",
        "45": "user.role.show",
        "46": "contentblock.contentblock.meta",
        "47": "contentblock.contentblock.index",
        "48": "contentblock.contentblock.store",
        "49": "contentblock.contentblock.update",
        "50": "contentblock.contentblock.show",
        "51": "contentblock.contentblock.destroy",
        "52": "advantage.advantage.meta",
        "53": "advantage.advantage.index",
        "54": "advantage.advantage.store",
        "55": "advantage.advantage.update",
        "56": "advantage.advantage.show",
        "57": "advantage.advantage.destroy",
        "58": "advantage.category.meta",
        "59": "advantage.category.index",
        "60": "advantage.category.store",
        "61": "advantage.category.update",
        "62": "advantage.category.show",
        "63": "advantage.category.destroy",
        "72": "shop.brand.index",
        "73": "shop.brand.store",
        "74": "shop.brand.update",
        "75": "shop.brand.show",
        "76": "shop.brand.destroy",
        "77": "shop.category.index",
        "78": "shop.category.store",
        "79": "shop.category.update",
        "80": "shop.category.show",
        "81": "shop.category.destroy",
        "82": "shop.product.index",
        "83": "shop.product.store",
        "84": "shop.product.update",
        "85": "shop.product.show",
        "86": "shop.product.destroy",
        "87": "contentblock.contentblock.photo.index",
        "88": "contentblock.contentblock.photo.store",
        "89": "contentblock.contentblock.photo.update",
        "90": "contentblock.contentblock.photo.show",
        "91": "contentblock.contentblock.photo.destroy",
        "92": "tariff.operatingsystem.index",
        "93": "tariff.operatingsystem.store",
        "94": "tariff.operatingsystem.update",
        "95": "tariff.operatingsystem.show",
        "96": "tariff.operatingsystem.destroy",
        "97": "tariff.period.index",
        "98": "tariff.period.store",
        "99": "tariff.period.update",
        "100": "tariff.period.show",
        "101": "tariff.period.destroy",
        "102": "tariff.currency.index",
        "103": "tariff.currency.store",
        "104": "tariff.currency.update",
        "105": "tariff.currency.show",
        "106": "tariff.currency.destroy",
        "107": "tariff.tariff.index",
        "108": "tariff.tariff.store",
        "109": "tariff.tariff.update",
        "110": "tariff.tariff.show",
        "111": "tariff.tariff.destroy"
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/user/roles/meta`


<!-- END_103ca72d18eb666e94c52e75d38259ff -->

<!-- START_68a72d48e17933fa5c736a935e767db5 -->
## Roles bulk destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "ids": [
            "The ids field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/scms/user/roles/bulk-destroy`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    ids | array |  required  | ids.
    ids.* | integer |  required  | role id.

<!-- END_68a72d48e17933fa5c736a935e767db5 -->

<!-- START_37fcf6e695b2d75f0c8cfa8269bfca35 -->
## Roles list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "name": "Admin",
            "slug": "admin",
            "description": "Admin Role"
        },
        {
            "id": 2,
            "name": "User",
            "slug": "user",
            "description": "User Role"
        }
    ],
    "meta": {
        "pagination": {
            "total": 3,
            "count": 3,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 1,
            "links": {
                "next": null,
                "previous": null
            }
        }
    },
    "count": 3
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "page": [
            "The filter.page must be an integer."
        ],
        "per_page": [
            "The Per page must be an integer."
        ]
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/user/roles`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    page | integer |  optional  | optional page
    per_page | integer |  optional  | optional per page
    sort_dir | string |  optional  | optional sorting dir
    sort_attr | string |  optional  | optional sorting attribute
    id | integer |  optional  | optional id
    name | string |  optional  | optional name.
    slug | string |  optional  | optional slug.
    description | string |  optional  | optional description.

<!-- END_37fcf6e695b2d75f0c8cfa8269bfca35 -->

<!-- START_8538ef83fe8b928f133b78214ce42acc -->
## Roles store

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
{
    "data": {
        "id": 34,
        "name": "Robyn Lind",
        "slug": "robyn.lind",
        "description": "Doloribus assumenda quasi repudiandae non aut eius placeat quod.",
        "permissions": []
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "slug": [
            "The Slug field is required."
        ],
        "name": [
            "The Name field is required."
        ]
    }
}
```

### HTTP Request
`POST api/scms/user/roles`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | name.
    slug | string |  required  | slug.
    description | string |  optional  | optional description.
    permissions | array |  optional  | optional permissions.
    permissions.* | integer |  optional  | optional permissions item.

<!-- END_8538ef83fe8b928f133b78214ce42acc -->

<!-- START_4a271709a7fba341353bb5ddc46c1718 -->
## Roles show

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 36,
        "name": "Dean Goodwin Sr.",
        "slug": "dean.goodwin.sr",
        "description": "Maiores quis quaerat iusto fugit. Autem dolores quisquam totam.",
        "permissions": []
    }
}
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\User\\Models\\Role] 36",
    "errors": []
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated.",
    "errors": []
}
```

### HTTP Request
`GET api/scms/user/roles/{role}`


<!-- END_4a271709a7fba341353bb5ddc46c1718 -->

<!-- START_ec7753a67e43d9f0eaa4d0b6be26bb02 -->
## Roles update

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": {
        "id": 35,
        "name": "Retta Schneider",
        "slug": "retta.schneider",
        "description": "Consectetur consequatur non cumque.",
        "permissions": []
    }
}
```
> Example response (422):

```json
{
    "message": "validation.the_given_data_was_invalid",
    "errors": {
        "slug": [
            "The Slug field is required."
        ],
        "name": [
            "The Name field is required."
        ]
    }
}
```
> Example response (404):

```json
{
    "message": "No query results for model [App\\Modules\\User\\Models\\Role] 35",
    "errors": []
}
```

### HTTP Request
`PUT api/scms/user/roles/{role}`

`PATCH api/scms/user/roles/{role}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | name.
    slug | string |  required  | slug.
    description | string |  optional  | optional description.
    permissions | array |  optional  | optional permissions.
    permissions.* | integer |  optional  | optional permissions item.

<!-- END_ec7753a67e43d9f0eaa4d0b6be26bb02 -->

<!-- START_09ef9316100336792d0d92f7a2c2d8d2 -->
## Roles destroy

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (204):

```json
[]
```
> Example response (422):

```json
{
    "message": "No query results for model [App\\Modules\\User\\Models\\Role] 37",
    "errors": []
}
```

### HTTP Request
`DELETE api/scms/user/roles/{role}`


<!-- END_09ef9316100336792d0d92f7a2c2d8d2 -->


