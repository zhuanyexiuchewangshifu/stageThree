<?php

// 载入全部公共函数
require_once '../functions.php';
// 判断是否登录
xiu_get_current_user();

// 连接数据库
// 执行查询条数的语句
// 拿到查询结果
// 输出到指定位置

$all_posts_count = xiu_fetch_one('select count(1) as count from posts;')['count'];
$drafted_posts_count = xiu_fetch_one("select count(1) as count from posts where status = 'drafted';")['count'];
$categories_count = xiu_fetch_one('select count(1) as count from categories;')['count'];
$all_comments_count = xiu_fetch_one('select count(1) as count from comments;')['count'];
$held_comments_count = xiu_fetch_one("select count(1) as count from comments where status = 'held';")['count'];


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <!-- / 指的是网站根目录 网站根目录是谁取决于 你 Apache 的配置 -->
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
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.html" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $all_posts_count; ?></strong>篇文章（<strong><?php echo $drafted_posts_count; ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $categories_count; ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $all_comments_count; ?></strong>条评论（<strong><?php echo $held_comments_count; ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>

  <?php $current_page = 'index'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
