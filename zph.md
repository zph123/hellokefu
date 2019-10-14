# zph的开发过程

## 1. 开发环境<http://laradock.io/>

- 配置虚拟主机/Users/zph/mysoft/docker/laradock/nginx/sites

  ```
  /Users/zph/mysoft/docker/laradock/nginx/sites/hellokefu.conf
  ```

- 修改vim /etc/hosts

  ```
  127.0.0.1       hellokefu.com
  ```

- docker容器启动Run your containers:

  ```
  docker-compose up -d nginx mysql phpmyadmin redis workspace  #启动容器
  docker-compose stop  #关闭容器
  ```
## 2. 环境支持swoole

- 更改配置

  ```
  cd laradock
  
  vim .env
  找到 ### WORKSPACE #############################################
  修改：WORKSPACE_INSTALL_SWOOLE=true
  添加WORKSPACE_WS_PORT=9501
  
  vim docker-compose.yml
  找到 ### Workspace Utilities ##################################
  ports:
   - "${WORKSPACE_SSH_PORT}:22"
   -"${WORKSPACE_WS_PORT}:9501"
  ```

- 重新编译workspace

  ```
  sudo docker-compose build workspace
  ```

- 重启容器

- 进入workspace bash

  ```
  docker-compose exec workspace bash
  php -m #能看到swoole
  ```


## 2. 创建 

- 进入命令行模式

  ```
  cd laradock
  docker-compose exec workspace bash
  ```

- 创建一个启动命令

  ```
  cd hellokefu
  php artisan make:command SwooleWebsocket
  ```

- 修改

  ```
  vim hellokefu/app/Console/Commands/Kernel.php
  protected function commands()
  {
  $this->load(__DIR__.'/Commands');
  require base_path('routes/console.php');
  }
  ```
- 启动swoole

  ```
  cd hellokefu/
  php artisan swoole:websocket
  ```
- 启动js代码监听
  ```
  npm run watch
  ```

