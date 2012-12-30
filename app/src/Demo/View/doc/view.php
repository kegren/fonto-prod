<?php $this->load('layout/header'); ?>
<div class="row-fluid">
    <div class="span9">
        <h2>Documentation for: <em><?php echo $classDoc['name']; ?></em></h2>
        <h3>Description</h3>
        <p><?php echo nl2br($classDoc['doc']); ?></p>
        <?php if (!empty($classDoc['publicMethods'])) : ?>
        <h3>Public methods</h3>
        <?php foreach ($methodsDoc as $method) : ?>
            <?php if ($method['isPublic']) : ?>
                <h4><?php echo $method['name']; ?></h4>
                <p><?php echo nl2br($method['doc']); ?></p>
                <p>Between lines: <?php echo $method['startline']; ?>-<?php echo $method['endline']; ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (!empty($classDoc['protectedMethods'])) : ?>
        <h3>Protected methods</h3>
        <?php foreach ($methodsDoc as $method) : ?>
            <?php if ($method['isProtected']) : ?>
                <h4><?php echo $method['name']; ?></h4>
                <p><?php echo nl2br($method['doc']); ?></p>
                <p>Between lines: <?php echo $method['startline']; ?>-<?php echo $method['endline']; ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (!empty($classDoc['privateMethods'])) : ?>
        <h3>Private methods</h3>
        <?php foreach ($methodsDoc as $method) : ?>
            <?php if ($method['isPrivate']) : ?>
                <h4><?php echo $method['name']; ?></h4>
                <p><?php echo nl2br($method['doc']); ?></p>
                <p>Between lines: <?php echo $method['startline']; ?>-<?php echo $method['endline']; ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="span3">
        <h2>Core services</h2>
        <ul>
            <?php foreach($services as $class => $args) : ?>
            <li>
                <?php echo $this->createLink(array('doc', 'view',  $args['id']), $class); ?>
                <ul>
                    <?php foreach ($args as $name => $arg) : ?>
                    <?php if (is_numeric($name)) : ?>
                        <li><?php echo $arg; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
            <?php endforeach; ?>
        </ul>
        <h2>Core objects</h2>
        <ul>
            <?php foreach ($objects as $class => $namespace) : ?>
            <li>
                <?php echo $this->createLink(array('doc', 'view',  $class), $namespace); ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php $this->load('layout/footer'); ?>
