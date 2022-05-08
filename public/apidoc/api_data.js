define({ "api": [
  {
    "type": "get",
    "url": "#",
    "title": "Admin结构体",
    "group": "02Body",
    "name": "Admin",
    "description": "<p>管理用户登陆表</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>管理用户id</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "pass",
            "description": "<p>密码（明文）</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "is_login",
            "description": "<p>是否自动登陆0否1是</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "created_at",
            "description": "<p>添加时间</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "updated_at",
            "description": "<p>最后修改时间</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Models/Admin.php",
    "groupTitle": "02Body"
  },
  {
    "type": "get",
    "url": "#",
    "title": "ApiLog结构体",
    "group": "02Body",
    "name": "ApiLog",
    "description": "<p>接口访问记录</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>接口历史记录id</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "interface",
            "description": "<p>接口</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "param",
            "description": "<p>参数</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "callback",
            "description": "<p>回调参数</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "time",
            "description": "<p>时间</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "created_at",
            "description": "<p>添加时间</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "updated_at",
            "description": "<p>最后修改时间</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Models/ApiLog.php",
    "groupTitle": "02Body"
  },
  {
    "type": "get",
    "url": "#",
    "title": "Config结构体",
    "group": "02Body",
    "name": "Config",
    "description": "<p>配置表</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>配置id</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "type",
            "description": "<p>类型1文本2列表</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "key",
            "description": "<p>KEY值</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "value",
            "description": "<p>值</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "description",
            "description": "<p>描述</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "created_at",
            "description": "<p>添加时间</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "updated_at",
            "description": "<p>最后修改时间</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "KEY",
            "description": "<p>KEY列表 <br> key：QUALITY_LEVEL 描述：画质-画质 <br> key：QUALITY_RATE 描述：画质-码率 <br> key：OSD_FORMAT 描述：OSD-OSD格式 <br> key：OSD_POSITION 描述：OSD-OSD位置  1：左上角  2：右上角 3：左下角 4：右下角 <br> key：PUSH_RTMP_URL 描述：OSD-RTMP推流地址 <br> key：PUSH_VIDEOSAVE_URL 描述：OSD-录像文件保存路径 <br> key：3D_SDL 描述：3D设置-双SDL输出 <br> key：NETWORK_IP 描述：网络-IP <br> key：NETWORK_SUBNET 描述：网络-子网掩码 <br> key：NETWORK_GATEWAY 描述：网络-网关 <br> key：NETWORK_DNS 描述：网络-DNS <br> key：NETWORK_AUTO 描述：网络-自动配置 1：关闭  2：开启 <br> key：DISC_FULLACTION 描述：磁盘-磁盘满后的动作 <br> key：COMMON_TIMEFORMAT 描述：通用-时间格式 <br> key：DISPLAY_LIGHT 描述：显示-亮度 <br> key：DISPLAY_RATIO 描述：显示-对比度 <br> key：DISPLAY_SATURATION 描述：显示-饱和度 <br></p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Models/Config.php",
    "groupTitle": "02Body"
  },
  {
    "type": "get",
    "url": "#",
    "title": "Files结构体",
    "group": "02Body",
    "name": "Files",
    "description": "<p>用户文件表</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>文件id</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "patient_case_id",
            "description": "<p>病人病历id</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "type",
            "description": "<p>文件类型1图片2视频</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>文件名字</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "path",
            "description": "<p>储存路径</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "created_at",
            "description": "<p>添加时间</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "updated_at",
            "description": "<p>最后修改时间</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Models/Files.php",
    "groupTitle": "02Body"
  },
  {
    "type": "get",
    "url": "#",
    "title": "PatientCase结构体",
    "group": "02Body",
    "name": "PatientCase",
    "description": "<p>病人信息表</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>病人id</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "sex",
            "description": "<p>性别</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "surgery_date",
            "description": "<p>手术日期</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "hospital_number",
            "description": "<p>住院号</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "bed_number",
            "description": "<p>床位号</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "department",
            "description": "<p>科室</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "operating_room",
            "description": "<p>手术室</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "surgery_name",
            "description": "<p>手术名称</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "age",
            "description": "<p>年龄</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "ward",
            "description": "<p>病区</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "surgery_doctor",
            "description": "<p>手术医生</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "created_at",
            "description": "<p>添加时间</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "updated_at",
            "description": "<p>最后修改时间</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Models/PatientCase.php",
    "groupTitle": "02Body"
  },
  {
    "type": "get",
    "url": "#",
    "title": "Report",
    "group": "02Body",
    "name": "Report",
    "description": "<p>报告表</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>报告id</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "templete_html",
            "description": "<p>模板html</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>报告名字</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "config",
            "description": "<p>表单配置</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "config_value",
            "description": "<p>表单配置带value值</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "templete_final",
            "description": "<p>最终模板html</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "created_at",
            "description": "<p>添加时间</p>"
          },
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "updated_at",
            "description": "<p>最后修改时间</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Models/Report.php",
    "groupTitle": "02Body"
  },
  {
    "type": "post",
    "url": "/user/login",
    "title": "1、用户登录",
    "sampleRequest": [
      {
        "url": "/user/login"
      }
    ],
    "group": "Common_user",
    "name": "login",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "pass",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "is_login",
            "description": "<p>是否自动登录 0不登录  1 登陆</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Common/UserController.php",
    "groupTitle": "Common_user"
  },
  {
    "type": "post",
    "url": "/user/login-info",
    "title": "3、获取用户信息",
    "sampleRequest": [
      {
        "url": "/user/login-info"
      }
    ],
    "group": "Common_user",
    "name": "login_info",
    "version": "0.0.0",
    "filename": "app/Controllers/Common/UserController.php",
    "groupTitle": "Common_user"
  },
  {
    "type": "get",
    "url": "/user/login-sign",
    "title": "2、自动登录",
    "sampleRequest": [
      {
        "url": "/user/login-sign"
      }
    ],
    "group": "Common_user",
    "name": "login_sign",
    "version": "0.0.0",
    "filename": "app/Controllers/Common/UserController.php",
    "groupTitle": "Common_user"
  },
  {
    "type": "post",
    "url": "/user/logout",
    "title": "4、用户退出",
    "sampleRequest": [
      {
        "url": "/user/logout"
      }
    ],
    "group": "Common_user",
    "name": "logout",
    "version": "0.0.0",
    "filename": "app/Controllers/Common/UserController.php",
    "groupTitle": "Common_user"
  },
  {
    "type": "post",
    "url": "/user/reset-root",
    "title": "5、系统设置-重置root账号",
    "sampleRequest": [
      {
        "url": "/user/reset-root"
      }
    ],
    "group": "Common_user",
    "name": "reset_root",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "pass",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Common/UserController.php",
    "groupTitle": "Common_user"
  },
  {
    "type": "get",
    "url": "/switch/reboot",
    "title": "1、系统重启",
    "sampleRequest": [
      {
        "url": "/switch/reboot"
      }
    ],
    "group": "ConfigSwitch",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SwitchController.php",
    "groupTitle": "ConfigSwitch",
    "name": "GetSwitchReboot"
  },
  {
    "type": "get",
    "url": "/system",
    "title": "1、系统设置-列表",
    "sampleRequest": [
      {
        "url": "/system"
      }
    ],
    "group": "Config_system",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system",
    "name": "GetSystem"
  },
  {
    "type": "get",
    "url": "/system/get-key",
    "title": "3、系统设置（录像设置）-获取某一个key的值",
    "sampleRequest": [
      {
        "url": "/system/get-key"
      }
    ],
    "group": "Config_system",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "key",
            "description": "<p>key名字</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system",
    "name": "GetSystemGetKey"
  },
  {
    "type": "get",
    "url": "/admin/",
    "title": "1、系统设置-用户列表",
    "sampleRequest": [
      {
        "url": "/admin"
      }
    ],
    "group": "Config_system_admin",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/AdminController.php",
    "groupTitle": "Config_system_admin",
    "name": "GetAdmin"
  },
  {
    "type": "post",
    "url": "/admin/add",
    "title": "2、系统设置-用户新增",
    "sampleRequest": [
      {
        "url": "/admin/add"
      }
    ],
    "group": "Config_system_admin",
    "name": "admin_add",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "pass",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "repass",
            "description": "<p>重复密码</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "is_login",
            "description": "<p>自动登陆： 0否 1 是】</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/AdminController.php",
    "groupTitle": "Config_system_admin"
  },
  {
    "type": "post",
    "url": "/admin/del",
    "title": "4、系统设置-用户删除",
    "sampleRequest": [
      {
        "url": "/admin/del"
      }
    ],
    "group": "Config_system_admin",
    "name": "admin_del",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>用户名</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/AdminController.php",
    "groupTitle": "Config_system_admin"
  },
  {
    "type": "post",
    "url": "/admin/edit",
    "title": "3、系统设置-账号自动登陆",
    "sampleRequest": [
      {
        "url": "/admin/edit"
      }
    ],
    "group": "Config_system_admin",
    "name": "admin_edit",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "pass",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "repass",
            "description": "<p>重复密码</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "is_login",
            "description": "<p>【自动登陆： 0否 1 是】</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/AdminController.php",
    "groupTitle": "Config_system_admin"
  },
  {
    "type": "get",
    "url": "/system/get-linux-net",
    "title": "3、系统设置-获取当前linux系统上的网络配置",
    "sampleRequest": [
      {
        "url": "/system/get-linux-net"
      }
    ],
    "group": "Config_system_network",
    "name": "system_getLinuxNet",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system_network"
  },
  {
    "type": "get",
    "url": "/system/get-network-key",
    "title": "2、系统设置-获取网络key值",
    "sampleRequest": [
      {
        "url": "/system/get-network-key"
      }
    ],
    "group": "Config_system_network",
    "name": "system_getNetworkKey",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system_network"
  },
  {
    "type": "get",
    "url": "/system/net-reset",
    "title": "4、系统设置-重置网络配置",
    "sampleRequest": [
      {
        "url": "/system/net-reset"
      }
    ],
    "group": "Config_system_network",
    "name": "system_netReset",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system_network"
  },
  {
    "type": "post",
    "url": "/system/network-edit",
    "title": "1、系统设置-网络编辑",
    "sampleRequest": [
      {
        "url": "/system/network-edit"
      }
    ],
    "group": "Config_system_network",
    "name": "system_networkEdit",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "NETWORK_IP",
            "description": "<p>网络-IP</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "NETWORK_SUBNET",
            "description": "<p>网络-子网掩码</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "NETWORK_GATEWAY",
            "description": "<p>网络-网关</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "NETWORK_DNS",
            "description": "<p>网络-DNS</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "NETWORK_AUTO",
            "description": "<p>网络-自动配置 【1：关闭  2：开启】</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system_network"
  },
  {
    "type": "get",
    "url": "/system/get-time",
    "title": "1、系统设置-获取系统时间",
    "sampleRequest": [
      {
        "url": "/system/get-time"
      }
    ],
    "group": "Config_system_setTime",
    "name": "system_getTime",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system_setTime"
  },
  {
    "type": "post",
    "url": "/system/set-time",
    "title": "1、系统设置-设置系统时间",
    "sampleRequest": [
      {
        "url": "/system/set-time"
      }
    ],
    "group": "Config_system_setTime",
    "name": "system_setTime",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "time",
            "description": "<p>值样例：时间戳</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system_setTime"
  },
  {
    "type": "get",
    "url": "/system/get-signal",
    "title": "1、系统设置-获取信号源类型",
    "sampleRequest": [
      {
        "url": "/system/get-signal"
      }
    ],
    "group": "Config_system_signal",
    "name": "system_getSignal",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system_signal"
  },
  {
    "type": "post",
    "url": "/system/signal-edit",
    "title": "2、系统设置-编辑信号源类型",
    "sampleRequest": [
      {
        "url": "/system/signal-edit"
      }
    ],
    "group": "Config_system_signal",
    "name": "system_signalEdit",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "value",
            "description": "<p>value值样例：{&quot;SDI-1&quot;:&quot;SDI_1信号&quot;,&quot;HDMI-1&quot;:&quot;HDMI_1信号&quot;}</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system_signal"
  },
  {
    "type": "post",
    "url": "/system/edit",
    "title": "2、系统设置-编辑(全局)",
    "sampleRequest": [
      {
        "url": "/system/edit"
      }
    ],
    "group": "Config_system",
    "name": "system_edit",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "key",
            "description": "<p>键名 样例：{key:value}</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/SystemController.php",
    "groupTitle": "Config_system"
  },
  {
    "type": "post",
    "url": "/video/edit",
    "title": "2、录像设置-编辑",
    "sampleRequest": [
      {
        "url": "/video/edit"
      }
    ],
    "group": "Config_video",
    "name": "video_edit",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "key",
            "description": "<p>键名 样例：{key:value}</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Config/VideoController.php",
    "groupTitle": "Config_video"
  },
  {
    "type": "get",
    "url": "/video",
    "title": "1、录像设置-列表",
    "sampleRequest": [
      {
        "url": "/video"
      }
    ],
    "group": "Config_video",
    "name": "video_list",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/VideoController.php",
    "groupTitle": "Config_video"
  },
  {
    "type": "post",
    "url": "/files/add",
    "title": "3、添加资源",
    "sampleRequest": [
      {
        "url": "/files/add"
      }
    ],
    "group": "Files",
    "name": "add",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "patient_case_id",
            "description": "<p>病人资源id</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "type",
            "description": "<p>文件类型1图片2视频</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "path",
            "description": "<p>储存路径</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "name",
            "description": "<p>文件名字</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/IndexController.php",
    "groupTitle": "Files"
  },
  {
    "type": "post",
    "url": "/files/delete",
    "title": "5、删除资源",
    "sampleRequest": [
      {
        "url": "/files/delete"
      }
    ],
    "group": "Files",
    "name": "delete",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>资源id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/IndexController.php",
    "groupTitle": "Files"
  },
  {
    "type": "post",
    "url": "/files/edit",
    "title": "4、录制视频的状态修改",
    "sampleRequest": [
      {
        "url": "/files/edit"
      }
    ],
    "group": "Files",
    "name": "edit",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>资源id</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "status",
            "description": "<p>录制的视频状态 0 正在录制  1 停止录制</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/IndexController.php",
    "groupTitle": "Files"
  },
  {
    "type": "get",
    "url": "/files-web",
    "title": "2、病人资源列表(PC接口)",
    "sampleRequest": [
      {
        "url": "/files-web"
      }
    ],
    "group": "Files",
    "name": "files_web",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "patient_case_id",
            "description": "<p>病人病历id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/IndexController.php",
    "groupTitle": "Files"
  },
  {
    "type": "get",
    "url": "/files",
    "title": "1、病人资源列表（不包括录制中）",
    "sampleRequest": [
      {
        "url": "/files"
      }
    ],
    "group": "Files",
    "name": "list",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "patient_case_id",
            "description": "<p>病人病历id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/IndexController.php",
    "groupTitle": "Files"
  },
  {
    "type": "post",
    "url": "/folder/add",
    "title": "1、创建目录",
    "sampleRequest": [
      {
        "url": "/folder/add"
      }
    ],
    "group": "Folder",
    "name": "add",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "root_path",
            "description": "<p>盘符路径</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "path",
            "description": "<p>相对路径</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "get",
    "url": "/folder/clear-disk",
    "title": "11、磁盘清空",
    "sampleRequest": [
      {
        "url": "/folder/clear-disk"
      }
    ],
    "group": "Folder",
    "name": "clear_disk",
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "post",
    "url": "/folder/copy",
    "title": "4、拷贝文件",
    "sampleRequest": [
      {
        "url": "/folder/copy"
      }
    ],
    "group": "Folder",
    "name": "copy",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "path",
            "description": "<p>复制的路径  /1979/1.mp4</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "new_path",
            "description": "<p>粘贴的绝对路径</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "root_path",
            "description": "<p>复制的盘符地址，不填默认本地盘符</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "root_new_path",
            "description": "<p>粘贴的盘符地址，不填默认本地盘符</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "name",
            "description": "<p>文件名字</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "post",
    "url": "/folder/del",
    "title": "3、删除文件、文件夹",
    "sampleRequest": [
      {
        "url": "/folder/del"
      }
    ],
    "group": "Folder",
    "name": "del",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "root_path",
            "description": "<p>盘符路径</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "path",
            "description": "<p>相对路径</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "name",
            "description": "<p>文件夹名字/文件名</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "get",
    "url": "/folder/download",
    "title": "7、web资源文件下载",
    "sampleRequest": [
      {
        "url": "/folder/download"
      }
    ],
    "group": "Folder",
    "name": "download",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>文件id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "get",
    "url": "/folder/file-out",
    "title": "10、文件导出",
    "sampleRequest": [
      {
        "url": "/folder/file-out"
      }
    ],
    "group": "Folder",
    "name": "file_out",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "path",
            "description": "<p>要复制的文件绝对路径，是绝对路径！</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "new_path",
            "description": "<p>粘贴的绝对路径，是绝对路径！</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>文件新名字</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "get",
    "url": "/folder/get",
    "title": "2、获取目录",
    "sampleRequest": [
      {
        "url": "/folder/get"
      }
    ],
    "group": "Folder",
    "name": "get",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "root_path",
            "description": "<p>盘符路径</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "path",
            "description": "<p>相对路径</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "type",
            "description": "<p>类型 数据类型的 0:全部  1：文件夹，2：文件</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "str",
            "optional": false,
            "field": "type",
            "description": "<p>返回数据类型的1：文件夹，2：文件</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "get",
    "url": "/folder/get-file-size",
    "title": "8、获取文件大小",
    "sampleRequest": [
      {
        "url": "/folder/get-file-size"
      }
    ],
    "group": "Folder",
    "name": "getFileSize",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "filePath",
            "description": "<p>文件绝对路径!,是绝对路径！</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "get",
    "url": "/folder/get-disk",
    "title": "5、获取磁盘信息",
    "sampleRequest": [
      {
        "url": "/folder/get-disk"
      }
    ],
    "group": "Folder",
    "name": "get_disk",
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "post",
    "url": "/folder/umount",
    "title": "12、卸载磁盘",
    "sampleRequest": [
      {
        "url": "/folder/umount"
      }
    ],
    "group": "Folder",
    "name": "umount",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "diskDir",
            "description": "<p>磁盘路径 例如：/mnt/disk2</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "post",
    "url": "/folder/upload-file",
    "title": "6、上传文件",
    "sampleRequest": [
      {
        "url": "/folder/upload-file"
      }
    ],
    "group": "Folder",
    "name": "upload_file",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "file",
            "description": "<p>文件参数名</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "fileType",
            "description": "<p>文件类型 logo图标：logo</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Files/FolderController.php",
    "groupTitle": "Folder"
  },
  {
    "type": "get",
    "url": "/init",
    "title": "1、初始化",
    "sampleRequest": [
      {
        "url": "/init"
      }
    ],
    "group": "Init",
    "name": "index",
    "version": "0.0.0",
    "filename": "app/Controllers/Init/IndexController.php",
    "groupTitle": "Init"
  },
  {
    "type": "post",
    "url": "/patient/add",
    "title": "2、添加病人",
    "sampleRequest": [
      {
        "url": "/patient/add"
      }
    ],
    "group": "Patient",
    "name": "add",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "sex",
            "description": "<p>性别</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_date",
            "description": "<p>手术日期</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "hospital_number",
            "description": "<p>住院号</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "bed_number",
            "description": "<p>床位号</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "department",
            "description": "<p>科室</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "operating_room",
            "description": "<p>手术室</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_name",
            "description": "<p>手术名称</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "age",
            "description": "<p>年龄</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "ward",
            "description": "<p>病区</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_doctor",
            "description": "<p>手术医生</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Patient/IndexController.php",
    "groupTitle": "Patient"
  },
  {
    "type": "post",
    "url": "/case-csv/input-csv",
    "title": "6、病例管理-导入病例",
    "sampleRequest": [
      {
        "url": "/case-csv/input-csv"
      }
    ],
    "group": "Patient",
    "name": "casecsv_inputcsv",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "filePath",
            "description": "<p>导入文件的路径【绝对路径】</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Patient/CaseCsvController.php",
    "groupTitle": "Patient"
  },
  {
    "type": "post",
    "url": "/case-csv/output-csv",
    "title": "5、病例管理-导出病例",
    "sampleRequest": [
      {
        "url": "/case-csv/output-csv"
      }
    ],
    "group": "Patient",
    "name": "casecsv_outputcsv",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "filePath",
            "description": "<p>文件导出路径【绝对路径】</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Patient/CaseCsvController.php",
    "groupTitle": "Patient"
  },
  {
    "type": "post",
    "url": "/patient/delete",
    "title": "4、删除病人",
    "sampleRequest": [
      {
        "url": "/patient/delete"
      }
    ],
    "group": "Patient",
    "name": "delete",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>病人id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>文件类型  1录像文件 2捉拍文件  4所以文件和病人信息</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Patient/IndexController.php",
    "groupTitle": "Patient"
  },
  {
    "type": "post",
    "url": "/patient/edit",
    "title": "3、编辑病人",
    "sampleRequest": [
      {
        "url": "/patient/edit"
      }
    ],
    "group": "Patient",
    "name": "edit",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>病人id</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>名字</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "sex",
            "description": "<p>性别</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_date",
            "description": "<p>手术日期</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "hospital_number",
            "description": "<p>住院号</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "bed_number",
            "description": "<p>床位号</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "department",
            "description": "<p>科室</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "operating_room",
            "description": "<p>手术室</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_name",
            "description": "<p>手术名称</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "age",
            "description": "<p>年龄</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "ward",
            "description": "<p>病区</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_doctor",
            "description": "<p>手术医生</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Patient/IndexController.php",
    "groupTitle": "Patient"
  },
  {
    "type": "get",
    "url": "/patient",
    "title": "1、病人列表",
    "sampleRequest": [
      {
        "url": "/patient"
      }
    ],
    "group": "Patient",
    "name": "list",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "name",
            "description": "<p>过滤名字</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "sex",
            "description": "<p>性别</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_date",
            "description": "<p>手术日期</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "hospital_number",
            "description": "<p>住院号</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "bed_number",
            "description": "<p>床位号</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "department",
            "description": "<p>科室</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "operating_room",
            "description": "<p>手术室</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_name",
            "description": "<p>手术名称</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "age",
            "description": "<p>年龄</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "ward",
            "description": "<p>病区</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "surgery_doctor",
            "description": "<p>手术医生</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": true,
            "field": "created_at",
            "description": "<p>创建时间</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Patient/IndexController.php",
    "groupTitle": "Patient"
  },
  {
    "type": "get",
    "url": "/patient/time-index",
    "title": "5、时间检索导航",
    "sampleRequest": [
      {
        "url": "/patient/time-index"
      }
    ],
    "group": "Patient",
    "name": "time_index",
    "version": "0.0.0",
    "filename": "app/Controllers/Patient/IndexController.php",
    "groupTitle": "Patient"
  },
  {
    "type": "get",
    "url": "/scan",
    "title": "1、扫描服务",
    "sampleRequest": [
      {
        "url": "/scan"
      }
    ],
    "group": "Scan",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/ScanController.php",
    "groupTitle": "Scan",
    "name": "GetScan"
  },
  {
    "type": "get",
    "url": "/scan/verify",
    "title": "1、扫描验证",
    "sampleRequest": [
      {
        "url": "/scan/verify"
      }
    ],
    "group": "Scan",
    "version": "0.0.0",
    "filename": "app/Controllers/Config/ScanController.php",
    "groupTitle": "Scan",
    "name": "GetScanVerify"
  },
  {
    "type": "post",
    "url": "/delete",
    "title": "4、sql删除",
    "sampleRequest": [
      {
        "url": "/delete"
      }
    ],
    "group": "Sql",
    "name": "delete",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "Sql",
            "description": "<p>sql查询语句</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Sql/SqlController.php",
    "groupTitle": "Sql"
  },
  {
    "type": "post",
    "url": "/insert",
    "title": "2、sql插入",
    "sampleRequest": [
      {
        "url": "/insert"
      }
    ],
    "group": "Sql",
    "name": "insert",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "Sql",
            "description": "<p>sql查询语句</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Sql/SqlController.php",
    "groupTitle": "Sql"
  },
  {
    "type": "post",
    "url": "/select",
    "title": "1、sql查询",
    "sampleRequest": [
      {
        "url": "/select"
      }
    ],
    "group": "Sql",
    "name": "select",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "Sql",
            "description": "<p>sql查询语句</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Sql/SqlController.php",
    "groupTitle": "Sql"
  },
  {
    "type": "post",
    "url": "/update",
    "title": "3、sql更新",
    "sampleRequest": [
      {
        "url": "/update"
      }
    ],
    "group": "Sql",
    "name": "update",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "Sql",
            "description": "<p>sql查询语句</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Sql/SqlController.php",
    "groupTitle": "Sql"
  },
  {
    "type": "get",
    "url": "/log",
    "title": "1、日志列表",
    "sampleRequest": [
      {
        "url": "/log"
      }
    ],
    "group": "log",
    "version": "0.0.0",
    "filename": "app/Controllers/Log/IndexController.php",
    "groupTitle": "log",
    "name": "GetLog"
  },
  {
    "type": "post",
    "url": "/log/add",
    "title": "2、日志新增",
    "sampleRequest": [
      {
        "url": "/log/add"
      }
    ],
    "group": "log",
    "name": "log_add",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "interface",
            "description": "<p>接口</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "param",
            "description": "<p>参数</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "callback",
            "description": "<p>回调参数</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Log/IndexController.php",
    "groupTitle": "log"
  },
  {
    "type": "post",
    "url": "/log/del",
    "title": "3、日志删除",
    "sampleRequest": [
      {
        "url": "/log/del"
      }
    ],
    "group": "log",
    "name": "log_del",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>日志序号</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Log/IndexController.php",
    "groupTitle": "log"
  },
  {
    "type": "get",
    "url": "/report/detail",
    "title": "2、获取报告详情",
    "sampleRequest": [
      {
        "url": "/report/detail"
      }
    ],
    "group": "report",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>报告id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Report/ReportController.php",
    "groupTitle": "report",
    "name": "GetReportDetail"
  },
  {
    "type": "post",
    "url": "/report/add",
    "title": "3、添加报告",
    "sampleRequest": [
      {
        "url": "/report/add"
      }
    ],
    "group": "report",
    "name": "add",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "patient_id",
            "description": "<p>病人id</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>报告名称</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "key",
            "description": "<p>模板key</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "form",
            "description": "<p>值为json字符串 例如：{&quot;Patient_name&quot;:&quot;李四&quot;,&quot;Hospital_name&quot;:&quot;歼击机互联网医院&quot;}</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Report/ReportController.php",
    "groupTitle": "report"
  },
  {
    "type": "post",
    "url": "/report/del",
    "title": "5、删除报告",
    "sampleRequest": [
      {
        "url": "/report/del"
      }
    ],
    "group": "report",
    "name": "del",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>报告id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Report/ReportController.php",
    "groupTitle": "report"
  },
  {
    "type": "post",
    "url": "/report/edit",
    "title": "4、编辑报告",
    "sampleRequest": [
      {
        "url": "/report/edit"
      }
    ],
    "group": "report",
    "name": "edit",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>报告id</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "patient_id",
            "description": "<p>病人id</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "name",
            "description": "<p>报告名称</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "form",
            "description": "<p>值为json字符串 例如：{&quot;Patient_name&quot;:&quot;李四&quot;,&quot;Hospital_name&quot;:&quot;歼击机互联网医院&quot;}</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Report/ReportController.php",
    "groupTitle": "report"
  },
  {
    "type": "get",
    "url": "/report",
    "title": "1、报告列表",
    "sampleRequest": [
      {
        "url": "/report"
      }
    ],
    "group": "report",
    "name": "list",
    "version": "0.0.0",
    "filename": "app/Controllers/Report/ReportController.php",
    "groupTitle": "report"
  },
  {
    "type": "get",
    "url": "/report/view",
    "title": "6、预览报告",
    "sampleRequest": [
      {
        "url": "/report/view"
      }
    ],
    "group": "report",
    "name": "view",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "id",
            "description": "<p>报告id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Report/ReportController.php",
    "groupTitle": "report"
  },
  {
    "type": "get",
    "url": "/templete",
    "title": "1、模板列表",
    "sampleRequest": [
      {
        "url": "/templete"
      }
    ],
    "group": "templete",
    "name": "list",
    "version": "0.0.0",
    "filename": "app/Controllers/Report/TemplateController.php",
    "groupTitle": "templete"
  },
  {
    "type": "post",
    "url": "/templete/templ-Form",
    "title": "1、模板表单",
    "sampleRequest": [
      {
        "url": "/templete/templ-Form"
      }
    ],
    "group": "templete",
    "name": "templ_Form",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "key",
            "description": "<p>模板key值</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Report/TemplateController.php",
    "groupTitle": "templete"
  },
  {
    "type": "post",
    "url": "/templete/templ-upload",
    "title": "1、模板上传",
    "sampleRequest": [
      {
        "url": "/templete/templ-upload"
      }
    ],
    "group": "templete",
    "name": "templ_upload",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "file",
            "description": "<p>模板压缩包，zip格式</p>"
          },
          {
            "group": "Parameter",
            "type": "str",
            "optional": false,
            "field": "is_cover",
            "description": "<p>模板名称相同是否进行覆盖文件 1:不覆盖 ，2：覆盖</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Controllers/Report/TemplateController.php",
    "groupTitle": "templete"
  },
  {
    "type": "get",
    "url": "/test",
    "title": "1、专门用于测试的控制器",
    "sampleRequest": [
      {
        "url": "/test"
      }
    ],
    "group": "test",
    "name": "test",
    "version": "0.0.0",
    "filename": "app/Controllers/Test/TestController.php",
    "groupTitle": "test"
  }
] });
