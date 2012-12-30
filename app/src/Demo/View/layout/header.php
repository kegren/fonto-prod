<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($themeTitle) ? $themeTitle : 'Fonto Framework' ?></title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?><?php echo isset($themeFile) ? $themeFile : 'web/app/Demo/css/fonty.css' ?>">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div id="fontoContainer">
    <header class="row-fluid">
        <a href="<?php echo $baseUrl; ?>">
            <?php echo $this->createImgLink(isset($themeLogo) ? $themeLogo : 'web/app/Demo/img/fontoLogov1.png', 'Fonto logo'); ?>
        </a>
        <h1><?php echo isset($themeHeading) ? $themeHeading : 'Fonto Framework'; ?></h1>
        <?php $session->has('user'); ?>
            <span class="pull-right">
            <?php if ($session->has('user')) : ?>
                <p><?php echo $session->get('username'); ?> <a href="<?php echo $baseUrl.'user/logout'; ?>">Logout</a></p>
                <?php else : ?>
                <p><?php echo $this->createLink(array('user', 'login'), 'Login'); ?></p>
                <?php endif; ?>
            </span>
    </header>