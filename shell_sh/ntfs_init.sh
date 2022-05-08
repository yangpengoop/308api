#!/bin/sh

#ntfs程序

#复制ntfs程序bin并添加可执行权限
cp -r /link/web/core309/shell_sh/ntfs/bin/ntfs* /usr/bin/ && cd /usr/bin/ && chmod +x ntfs*
#复制ntfs程序lib
cp -r /link/web/core309/shell_sh/ntfs/lib/libntfs-3g.so* /usr/lib/
cd /usr/lib/ && chmod +x libntfs-3g.so* && ln -s ./libntfs-3g.so.88.0.0 ./libntfs-3g.so.88 &&  ln -s ./libntfs-3g.so.88.0.0 ./libntfs-3g.so

#fuse模块
mkdir -p /lib/modules/3.18.20
cd /lib/modules/3.18.20 && cp -r /link/web/core309/shell_sh/ntfs/ko/*.ko ./
depmod -a && modprobe fuse.ko && modprobe ntfs.ko
