# Simple DataMapper ORM


## Create your mapper
> Simple DataMapper implementation
> 
---
```php 
use App\Entity\User;
use Core\Component\ORM\AbstractDataMapper;
use Core\Component\ORM\EntityInterface;

class UserMapper extends AbstractDataMapper
{
    protected $table = 'user';

    protected $entity = User::class;

    protected function createEntity(array $row): ?EntityInterface
    {
        return (new User)
            ->setId($row['id'])
            ->setFullname($row['fullname'])
            ->setCreatedAt($row['created_at']);
    }
}
```


## Use finders


* findAll()

```php 
use App\DataMapper\UserMapper;
use Core\Component\ORM\Storage\PDOStorage;

$pdoStorage = new PDOStorage('sqlite:'.dirname(__FILE__).'/database.sqlite');
$userMapper = new UserMapper($pdoStorage);
$users = $userMapper->findAll();

var_dump($users);

```

* findById()

```php 
use App\DataMapper\UserMapper;
use Core\Component\ORM\Storage\PDOStorage;

$pdoStorage = new PDOStorage('sqlite:'.dirname(__FILE__).'/database.sqlite');
$userMapper = new UserMapper($pdoStorage);
$user = $userMapper->findById(19);

var_dump($user);

```

* save() 
```php 
$user = new User();
$user->setFullname('John Doe');
$user->setCreatedAt((new DateTime())->format('Y-m-d'));


$userMapper = new UserMapper($pdoStorage);
$userMapper->save($user);
var_dump($userMapper->findById(20));


$user->setFullname('Doe John');
$userMapper->save($user);

var_dump($userMapper->findById(20));

```