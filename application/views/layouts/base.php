<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <title>{page_title}</title>
  <link rel="stylesheet" href="assets/stylesheets/vendor.min.css" />
  <link rel="stylesheet" href="assets/stylesheets/application.min.css" />
  {styles}
  <?php if (!empty($path)) { ?>
  <link rel="stylesheet" href="assets/stylesheets/{path}/{name}.min.css" />
  <?php } else { ?>
  <link rel="stylesheet" href="assets/stylesheets/{name}.min.css" />
  <?php } ?>
  {/styles}
</head>

<body>
  <header>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand navigate" href="top">CodeIgniter Sample</a>
        </div>
      </div>
    </nav>
  </header>
  <main class="page-main container container-fluid">
    <div class="row">
      <header class="page-title col-sm-12 hidden-xs">
        <h1>CodeIgniter Sample</h1>
      </header>
    </div>
    <div class="row">
      <div class="col-md-9 col-sm-8 col-xs-12">
        <div>
          <div class="panel panel-default">
            <div class="panel-body">
              {content}
            </div>
          </div>
        </div>
        <nav>
          <ul class="pager">
            <li class="previous"><a href="#">Older</a>
            </li>
            <li class="next"><a href="#">Newer</a>
            </li>
          </ul>
        </nav>
      </div>
      <aside id="page-aside" class="col-md-3 col-sm-4 hidden-xs">
        <div class="panel panel-default">
          <div class="panel-heading">Profile</div>
          <div class="panel-body">
            Author: okugawa3210
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">Search</div>
          <div class="panel-body">
            <form class="form" type="get">
              <div class="input-group">
                <input type="text" class="form-control">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </form>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">Link</div>
          <div class="panel-body">
            <ul class="list">
              <li>hogehogehoge</li>
            </ul>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">Latest</div>
          <div class="panel-body">
            <ul class="list">
              <li>hogehogehoge</li>
            </ul>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">Category</div>
          <div class="panel-body">
            <ul class="list">
              <li>hogehogehoge</li>
            </ul>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">Archive</div>
          <div class="panel-body">
            <ul class="tree">
              <li class="tree-branche">
                <div class="tree-label">
                  <span class="tree-expand"><a href="javascript:void(0)"><i class="fa fa-fw fa-chevron-right"></i></a></span>
                  <span class="tree-collapse hidden"><a href="javascript:void(0)"><i class="fa fa-fw fa-chevron-down"></i></a></span>
                  <a href="top">2015年</a>
                  <span class="badge">5</span>
                </div>
                <ul class="tree hidden">
                  <li class="tree-branche">
                    <div class="tree-label">
                      <a href="top">7月</a>
                      <span class="badge">1</span>
                    </div>
                  </li>
                  <li class="tree-branche">
                    <div class="tree-label">
                      <a href="top">8月</a>
                      <span class="badge">1</span>
                    </div>
                  </li>
                  <li class="tree-branche">
                    <div class="tree-label">
                      <a href="top">9月</a>
                      <span class="badge">3</span>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </aside>
    </div>
  </main>
  <script type="text/javascript" src="assets/javascripts/vendor.min.js"></script>
  <script type="text/javascript" src="assets/javascripts/application.min.js"></script>
  {scripts}
  <?php if (!empty($path)) { ?>
  <script type="text/javascript" src="assets/javascripts/{path}/{name}.min.js"></script>
  <?php } else { ?>
  <script type="text/javascript" src="assets/javascripts/{name}.min.js"></script>
  <?php } ?>
  {/scripts}
</body>

</html>
