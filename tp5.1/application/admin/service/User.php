<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// |  后台用户服务
// +----------------------------------------------------------------------
namespace app\admin\service;

use think\facade\Session;

class User
{
    //当前登录会员详细信息
    private static $userInfo = array();
    //单例模式
    protected static $instance = null;

    /**
     * 获取示例
     * @param array $options 实例配置
     * @return static
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($options);
        }

        return self::$instance;
    }

    /**
     * 检验用户是否已经登陆
     * @return boolean 失败返回false，成功返回当前登陆用户基本信息
     */
    public function isLogin()
    {
        $user = Session::get('admin_user_auth');
        if (empty($user)) {
            return 0;
        } else {
            return Session::get('admin_user_auth_sign') == data_auth_sign($user) ? (int) $user['uid'] : 0;
        }
    }

    /**
     * 检查当前用户是否超级管理员
     * @return boolean
     */
    public function isAdministrator($uid = null)
    {
        $userInfo = $this->getInfo();
        if (!empty($userInfo) && $userInfo['roleid'] == ADMIN_ROLEID) {
            return true;
        }
        return false;
    }

    /**
     * 获取当前登录用户资料
     * @return array
     */
    public function getInfo()
    {
        if (empty(self::$userInfo)) {
            self::$userInfo = $this->getUserInfo($this->isLogin());
        }
        return !empty(self::$userInfo) ? self::$userInfo : false;
    }

    /**
     * 获取用户信息
     * @param type $identifier 用户名或者用户ID
     * @return boolean|array
     */
    private function getUserInfo($identifier, $password = null)
    {
        if (empty($identifier)) {
            return false;
        }
        return model('admin/AdminUser')->getUserInfo($identifier, $password);
    }

    /**
     * 注销登录状态
     * @return boolean
     */
    public function logout()
    {
        Session::clear();
        return true;
    }
}
