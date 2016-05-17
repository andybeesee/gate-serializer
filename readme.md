# Use AndyBeesee\Gate\Serializer

For serializing user permissions on objects to pass to clients.

## Requires Laravel authorization package, and use of [policies](https://laravel.com/docs/5.2/authorization#policies)

## Example usage
Lets say we have a forum with two different classes of user: member and moderator. Members can add posts and edit their own posts. Moderators can add posts, edit their own and delete others posts.

The goal is to send back each object with the appropriate user permissions attached like so:

```json
{
  "data": {
    "posts": [
      {
        "id": 1,
        "post": "something...",
        "user": 1,
        "permissions": {
          "edit": true,
          "delete": false
        },
      },
      {
        "id": 2,
        "post": "other thing...",
        "user": 2,
        "permissions": {
          "edit": false,
          "delete": false
        },        
      }
    ]
  }
}
```

You have two approaches to attaching those permissions.

## The HasPermissionsAttribute trait
On any Model class use the AndyBeesee\Gate\HasPermissionAttribute trait, and append the permissions attribute.

```php
use AndyBeesee\Gate\HasPermissionsAttribute;

class Something extends Model {
  use HasPermissionsAttribute;
  
  // Make sure to append permissions to the output
  public $appends = ['permissions'];
}
```

## The GateSerializer class
On any object associated with a policy model:

```php
use Andybeesee\Gate\Serializer as GateSerializer;

$serializer = new GateSerializer();

// Get current user's permissions on post
$post = Post::findOrFail(3);
$permissions = $serializer->get($post);
//$permissions = ['edit' => false, 'delete' => false]

//Get Specific user's permissisons on post
$user = User::findOrFail(3);
$permissions = $serializer->get($post, $user);
//$permission = ['edit' => true, 'delete' => true]

```