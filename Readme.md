# Demo App based on Symfony 4 

Application presents custom normalization mechanism as an alternative to bundles like JMS Serializer.

This implementation of normalizer is very light and fast. 


Installation:
-----------------
```
1. cp .env.dist .env
2. fill own database credentials in .env file
3. bin/console doctrine:database:create 
4. bin/console doctrine:schema:update -f
5. bin/console hautelook:fixtures: load
6. bin/console server:run
```

How to use:
-----------------
Core mechanism is here:
```
Src/Normalizer/Base/NormalizerFactory.php
```

You can check results for one entity object and 1000 of them
```
{hostname}/api/users/1

{hostname}/api/users
```

Also you can check performance tests at:

```
{hostname}/performance/users/1

{hostname}/performance/users  
```

Bonus
---
On git branches `step-1`, `step-2`, `step-3`, `step-4` you can check process of code refactor from old style of services definition through Symfony 3.3 and 3.4 features until newest way of defining symfony services.