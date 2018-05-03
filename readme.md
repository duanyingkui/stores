## 项目搭建
1. git clone git@github.com:duanyingkui/stores.git
2. 配置虚拟主机 (ubuntu: https://blog.csdn.net/qq_33430445/article/details/79158975)
3. composer install
4. cp .env.example .env
5. php artisan key:generate
6. 修改数据库连接
7. php artisan migrate  (数据库迁移，不执行 )
8. php artisan db:seed  (数据填充，不执行)
9. cnpm install(建议)/npm install
10. npm run watch
- 访问 http://虚拟主机地址/wx#/  看是否成功

## 项目帮助
1. VUX 2.x：https://vux.li/#/
2. ElementUI 2.2：http://element.eleme.io/2.2/#/zh-CN/component/installation
3. EasyWeChat 3.x：https://www.easywechat.com/docs/3.x
4. ionic icon：http://www.runoob.com/ionic/ionic-icon.html

# 注意：每次 git push 前，必须有 git pull 操作，有冲突必须解决冲突
*（未完，后续补充......）*

## Git 使用
1. git add .
2. git commit -m "注释"
3. git pull origin master
4. git checkout master
5. git pull
6. git merge 自己分支名
7. git push
8. git checkout 自己分支名
