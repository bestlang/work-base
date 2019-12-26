---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#产品信息相关
<!-- START_86e0ac5d4f8ce9853bc22fd08f2a0109 -->
## api/products
> Example request:

```bash
curl -X GET -G "/api/products" \
    -H "Content-Type: application/json" \
    -d '{"token":"eos"}'

```
```javascript
const url = new URL("/api/products");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "token": "eos"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (401):

```json
{
    "message": "Token not provided"
}
```

### HTTP Request
`GET api/products`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    token | 字符串 |  required  | token.

<!-- END_86e0ac5d4f8ce9853bc22fd08f2a0109 -->

<!-- START_d5a3d0c0add9ae4109a8d270310cf6c0 -->
## api/products/{id}
> Example request:

```bash
curl -X GET -G "/api/products/1" 
```
```javascript
const url = new URL("/api/products/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (401):

```json
{
    "message": "Token not provided"
}
```

### HTTP Request
`GET api/products/{id}`


<!-- END_d5a3d0c0add9ae4109a8d270310cf6c0 -->

<!-- START_05b4383f00fd57c4828a831e7057e920 -->
## api/products
> Example request:

```bash
curl -X POST "/api/products" 
```
```javascript
const url = new URL("/api/products");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST api/products`


<!-- END_05b4383f00fd57c4828a831e7057e920 -->

<!-- START_241fd2204f9f5b65c7aa7c9618dcca22 -->
## api/products/{id}
> Example request:

```bash
curl -X PUT "/api/products/1" 
```
```javascript
const url = new URL("/api/products/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT api/products/{id}`


<!-- END_241fd2204f9f5b65c7aa7c9618dcca22 -->

<!-- START_160dac2b00e86335715987c6d1c1f3eb -->
## api/products/{id}
> Example request:

```bash
curl -X DELETE "/api/products/1" 
```
```javascript
const url = new URL("/api/products/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE api/products/{id}`


<!-- END_160dac2b00e86335715987c6d1c1f3eb -->

#登录注册相关
<!-- START_c3fa189a6c95ca36ad6ac4791a873d23 -->
## api/login
> Example request:

```bash
curl -X POST "/api/login" \
    -H "Content-Type: application/json" \
    -d '{"email":"optio","password":"pariatur"}'

```
```javascript
const url = new URL("/api/login");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "optio",
    "password": "pariatur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU2MDc2MzcwNCwiZXhwIjoxNTYwNzY3MzA0LCJuYmYiOjE1NjA3NjM3MDQsImp0aSI6ImtSazV2YWtsUThoN2toOTgiLCJzdWIiOjIsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.kw_sN4yLIbpF596bmiV6bviImHuRf_wPRWYn044WwEY"
}
```

### HTTP Request
`POST api/login`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | 字符串 |  required  | 注册邮箱.
    password | 字符串 |  required  | 密码.

<!-- END_c3fa189a6c95ca36ad6ac4791a873d23 -->

<!-- START_d7b7952e7fdddc07c978c9bdaf757acf -->
## api/register
> Example request:

```bash
curl -X POST "/api/register" \
    -H "Content-Type: application/json" \
    -d '{"name":"ea","email":"vel","password":"odit"}'

```
```javascript
const url = new URL("/api/register");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "ea",
    "email": "vel",
    "password": "odit"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "success": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9yZWdpc3RlciIsImlhdCI6MTU2MDc2MzgwOCwiZXhwIjoxNTYwNzY3NDA4LCJuYmYiOjE1NjA3NjM4MDgsImp0aSI6ImNORW1vT3JReGRyVUxyR1EiLCJzdWIiOjQsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.v9CbCV6Pob1eVZjjVL2mfCaWDK1DitlbbfawHwMm4zM"
}
```

### HTTP Request
`POST api/register`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | 字符串 |  required  | 注册用户名.
    email | 字符串 |  required  | 注册邮箱.
    password | 字符串 |  required  | 密码.

<!-- END_d7b7952e7fdddc07c978c9bdaf757acf -->

<!-- START_00e7e21641f05de650dbe13f242c6f2c -->
## api/logout
> Example request:

```bash
curl -X GET -G "/api/logout" \
    -H "Content-Type: application/json" \
    -d '{"token":"eos"}'

```
```javascript
const url = new URL("/api/logout");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "token": "eos"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (401):

```json
{
    "message": "Token not provided"
}
```

### HTTP Request
`GET api/logout`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    token | 字符串 |  required  | token.

<!-- END_00e7e21641f05de650dbe13f242c6f2c -->

<!-- START_2b6e5a4b188cb183c7e59558cce36cb6 -->
## api/user
> Example request:

```bash
curl -X GET -G "/api/user" \
    -H "Content-Type: application/json" \
    -d '{"token":"omnis"}'

```
```javascript
const url = new URL("/api/user");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "token": "omnis"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "user": {
        "id": 4,
        "name": "luzhang",
        "email": "luzhang110@163.com",
        "email_verified_at": null,
        "created_at": "2019-06-17 09:30:08",
        "updated_at": "2019-06-17 09:30:08"
    }
}
```

### HTTP Request
`GET api/user`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    token | 字符串 |  required  | token.

<!-- END_2b6e5a4b188cb183c7e59558cce36cb6 -->


