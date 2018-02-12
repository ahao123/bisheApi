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
Route::rule('api/:version/upload/:type','api/:version.Upload/upload');

//动态版本号
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');

//http://bisheapi.project.com/api/v1/theme/ids/1
Route::get('api/:version/theme','api/:version.Theme/getSimpleList');
Route::get('api/:version/theme/:id','api/:version.Theme/getComplexOne');

Route::get('api/:version/product/by_category','api/:version.Product/getAllInGategory');//获取分类
Route::get('api/:version/product/:id','api/:version.Product/getOne',[],['id' => '\d+']);//获取商品详情
Route::get('api/:version/product/recent','api/:version.Product/getRecent');//最近新品

Route::get('api/:version/product/recent','api/:version.Product/getRecent');