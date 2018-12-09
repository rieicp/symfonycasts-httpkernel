Journey to the Center of Symfony
================================

See http://knpuniversity.com/screencast/symfony-journey.

### Kernel->handle()流程重要注解
```
10) HttpKernel.php::handleRaw()首先创建一个event
    $event = new GetResponseEvent($this, $request, $type);
    $this->dispatcher->dispatch(KernelEvents::REQUEST, $event);
    
20) RouterListener.php::onKernelRequest()响应该event
    . 从event中获取request
      $request = $event->getRequest();
    
    . 解析routing信息
    if ($this->matcher instanceof RequestMatcherInterface) {
      $parameters = $this->matcher->matchRequest($request);
    } else {
      $parameters = $this->matcher->match($request->getPathInfo());
    }
  
    . 将parameter设置到request->attributes中
      $request->attributes->add($parameters);
      unset($parameters['_route'], $parameters['_controller']);
      $request->attributes->set('_route_params', $parameters);
    
30) app/cache/dev/appDevUrlMatcher.php中存储了所有的routing匹配的结果
    
40) HttpKernel.php::handleRaw()使用
      vendor/symfony/symfony/src/Symfony/Component/HttpKernel/Controller/ControllerResolver.php中的
            $controller = $this->resolver->getController($request)
      来转换为callable的形式，
      其中调用了
      vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Controller/ControllerResolver.php中的
      createController()方法。
      该方法中可以看到，会去处理"::"分割符，并在最后$controller->setContainer()
      
50) vendor/symfony/symfony/src/Symfony/Component/HttpKernel/Controller/ControllerResolver.php
    中有getArgumetns(), doGetArguments(Request $request, $controller, array $parameters)
    利用反射技术获取/分析controller的参数。
    其中，$parameters是反射技术分析出的controller的参数列表，
    而$request->attributes->all()则是routing中(定义)的参数，
    系统分析$parameters中的每一个，是否为routing参数，是否为request，是否设置有缺省值，
    若皆否，则会抛出异常
    
60) 若Controller最后返回的不是response，而是普通的类对象，
    则 Httpkernel.php中释放kernel.view事件
        $this->dispatcher->dispatch(KernelEvents::VIEW, $event);
    而TemplateListener.php会捕捉到该事件，并将Controller的输出转化为view
    
70) 另外还有kernel.exception事件，会被ExceptionListener捕获、处理    
        
```
### 其它技术要点
```
在event响应过程中，可以用
  $event->setResponse($response)
来返回Response，生成最终结果

```
Installation
------------

1) Download the "Code" from any screencast page (available
   once you're susbcribed). Or, you can clone this repository
   from GitHub

2) If you downloaded the code, unzip it, open up a terminal,
   and move into the `start` directory:

```
cd start
```

3) Download the vendor libraries via [Composer](https://getcomposer.org/):

```
composer install
```

You will be asked for your database credentials at the end, which save
into the app/config/parameters.yml file.

4) Build the database and load in the test data!

```
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console doctrine:fixtures:load
```

5) Start the built-in PHP web server:

```
php app/console server:run
```

6) Load up the app in your browser!

    http://localhost:8000

Have fun!

Collaboration
-------------

As we start writing the content for this tutorial, we invite you to read
through it, try things out, and offer improvements, either as issues on this
repository or as pull requests. Stuff is hard, so the more smart minds we
can have on it, the better it will be for everyone.

Cheers!
