<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@.cgmailom>
// +----------------------------------------------------------------------

use think\Route;

//Route::rule('banner/:id','api/v1.Banner/getBanner');
//动态版本号
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');