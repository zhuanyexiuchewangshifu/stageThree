<?php

// 载入全部公共函数
require_once '../functions.php';
// 判断是否登录
xiu_get_current_user();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul id="pagination" class="pagination pagination-sm pull-right"></ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th width="100">作者</th>
            <th>评论</th>
            <th width="180">评论在</th>
            <th width="180">提交于</th>
            <th width="80">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody id="list"></tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'comments'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/jsrender/jsrender.js"></script>
  <script src="/static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <!-- 建议模板类型格式 text/x-<template-engine-name> -->
  <script id="comments_tmpl" type="text/x-jsrender">
    {{for comments}}
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>{{: author }}</td>
      <td>{{: content }}</td>
      <td>《{{: post_title }}》</td>
      <td>{{: created }}</td>
      <td>{{: status === 'approved' ? '已批准' : status === 'held' ? '待审' : '拒绝' }}</td>
      <td class="text-center">
        <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    {{/for}}
  </script>
  <!-- 页面中的JS最终需要摘取到单独的JS文件中 -->
  <script>
    $(function ($) {
      // 发送AJAX加载指定页码对应的数据
      function loadData (page) {
        $.ajax({
          // 一般把AJAX请求的这种地址称之为接口（数据接口）
          url: '/admin/api/comments.php',
          type: 'get',
          data: { page: page },
          // 如果服务端响应的 Content-Type 为 application/json 这里可以不用设置
          dataType: 'json',
          success: function (res) {
            console.log(res.total_pages)
            // res => []
            // res => { comments: [] }

            // 将数据渲染到表格中
            // 模板引擎使用：
            // 1. 引入模板引擎
            // 2. 准备一个模板
            // 3. 准备一个数据
            var context = { comments: res.comments }
            // 4. 通过模板引擎提供某个API将模板和数据融合在一起
            var html = $('#comments_tmpl').render(context)
            // console.log(html)

            // 将HTML放到tbody中
            $('#list').fadeOut(function () {
              $(this).html(html).fadeIn()
            })

            // 当能够获取到总页数的时候，再去正确的展示一个分页组件
          }
        })
      }

      // twbsPagination 的作用就是在指定元素上呈现一个分页组件
      $('#pagination').twbsPagination({
        // 总页数不能写死也是需要通过服务端获取
        totalPages: 10,
        visiablePages: 5,
        onPageClick: function (e, page) {
          // 页码发生改变的事件
          loadData(page)
        }
      })
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
