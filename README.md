# raspiberrry-Remote-monitoring-SG90-steering-gear-control-
raspiberrry Remote monitoring (SG90 steering gear control)
you can learn how to use it by this website:
https://blog.csdn.net/LZJSTUDY/article/details/88953737
教程网址：
https://blog.csdn.net/LZJSTUDY/article/details/88953737

我这里是用了NATAPP提供的内网穿透服务，可以再任何地方访问网站进行操作，其中一个对应端口8888，一个对应端口8080，前面的8888端口是在nginx里面设置的，8080端口是提供视频服务的，因为这里我采用的是MJPG-Streamer，它自己会占用8080端口的。

当然你也可以用本地局域网，不需要内网穿透也就意味着不需要花钱，只能在局域网使用。

下图是采用端口映射的方式，在natapp里面的设置之一。

简介：用PHP远程控制树莓派对舵机进行四个方向的旋转和位置的重置，并且将视频流推送出来。可以把MJPG-Streamer的javascript的代码拿出来贴到页面上，也可以采用ifream的方式引用代码，但是两者的本质都是采用javascript对视频流的读帧操作。这里我是将MJPG-Streamer的javascript实现的js代码提取出来，放到了我的网页中去。

 

操作步骤：
一.在树莓派上安装MJPG-Streamer
安装好了即可访问本地ip:8080展示出来视频流。

可以看这个链接学一下怎么安装。

https://blog.csdn.net/little_bobo/article/details/78769745
如果是局域网的话，什么都不用管。安好了直接本地ip:8080来访问。

如果想用在广域网的话，需要先将本地IP+8080端口进行端口映射，然后就像这样



这样做了，就可以通过域名直接访问这个MJPG-Streamer这个网页。

二.安装ngxin和PHP
这个看我的前两次的教程

安装Nginx和php7.0的教程树莓派安装nginx和php7.0

https://blog.csdn.net/LZJSTUDY/article/details/88809314
(重点！敲黑板！)

如果要本地局域网使用，可以接下来不进行操作。

如果要广域网使用，需要我们在php里面解禁pcntl_exec这个函数，应为在远程命令中调用服务器的shell命令是非常不安全的,咱们是需要再网页中进行对舵机的控制，需要引用RPi.GPIO模块，对舵机参数的控制还需要引用configparser这个模块，解禁这个函数就可以这么操作

$rec=exec("python  a.py")
这是用php在shell中控制python脚本，重点！如果不用解禁这个的话，在python脚本中import自己下载的python库会出现没权限这个问题。

三.下载代码并且部署
我的代码是用python2.7环境运行的，3以上的也没有问题，但是你得有configparser这个模块。

我的代码已经上传的GitHub上了

代码链接：github的reapiberry steer-control代码链接

nginx配置好之后，部署到/var/www/html里面，ngxin里面开启8888端口，本地直接访问，广域网需要端口映射，之后就可以操作了。

SG90舵机参数配置在config.ini里面，采用BOARD物理引脚编码，水平旋转舵机是38号，竖直旋转舵机是40号

流程:
从PHP网页operate.php传参点击的参数到get_args.php，然后在get_args.php调用shell命令exec传参给py脚本，py脚本在本地控制舵机，并且返回结果给php。

主要就是php调用shell命令操作，和python对舵机的控制，和mjpg-streamer的推流

代码很简单，不懂得可以读读代码。

舵机的操作就是：

舵机对象每次用完之后需要析构，因为这个操作是响应式的，点一次返回一个结果，所以点一次生成一个对象，旋转结束释放对象。并且每一次旋转操作都会更改config.ini配置文件，因为下一次的旋转是在上一次的旋转的基础上进行的。reset重置功能是设定了一个固定的数值，一个水平角度，一个数值角度。这样旋转结束之后点击重置可以返回一开始的状态。

其他的配置问题可以上网查查，这个项目需要对php python nginx html js linux有点了解。
--------------------- 
作者：星空下的枫 
来源：CSDN 
原文：https://blog.csdn.net/LZJSTUDY/article/details/88953737 
版权声明：本文为博主原创文章，转载请附上博文链接！
