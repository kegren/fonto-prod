<?php $this->load('layout/header'); ?>
<div class="row-fluid">
    <div class="span9">
        <?php $this->load('include/message'); ?>
        <h2>Home Controller</h2>
        <p>Welcome to Fontos home controller. This is right now set as the default controller.
            You can of course change this behavior in the routes.php file.</p>
        <h3>Download</h3>
        <p>You can download Fonto from github or clone it directly from:</p>
        <p>git@github.com:kenren/fonto-prod.git</p>
        <p>You can view its source on github: <a href="https://github.com/kenren/fonto-prod">link</a></p>
        <h3>Installation</h3>
        <p>Before you can start using Fonto you need to install some database tables. You
        can do this manually or by clicking on <?php echo $this->createLink(array('home', 'install'), 'this'); ?> link.
        This will install the following tables:</p>
        <ul>
            <li>User</li>
            <li>Roles</li>
            <li>Userroles</li>
            <li>Content</li>
            <li>Guestbook</li>
        </ul>
        <p>You will automatically get an admin account with the following credentials: admin/admin</p>
    </div>
    <div class="span3">
        <h2>Available Controllers</h2>
        <?php if(!empty($controllers)) : ?>
        <ul>
            <?php foreach($controllers as $name => $methods) : ?>
            <li><?php echo $this->createLink(array($name), $name); ?>
                <ul>
                    <?php foreach($methods as $method) : ?>
                    <li><?php echo $this->createLink(array($name, $method), $method); ?></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
<?php $this->load('layout/footer'); ?>
