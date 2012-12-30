<?php $this->load('layout/header'); ?>
<div class="row-fluid">
    <div class="span9">
        <h2>Documentation</h2>
        <p>
            Fonto is built as a PHP framework with flexibility in mind.
            You, as an user, can easily decide what kind of packages you need by making use of composer and just download
            them through the composer repository. Fonto is in no way meant to be competing with other
            frameworks, it's just a little project that I made. As you will notice, Fonto, is a work in progress
            and over time it will change dramatically.
        </p>
        <h3>Enabled controllers and their methods</h3>
        <?php if(sizeof($controllers)) : ?>
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
        <section>
            <h3>Models</h3>
            <h4>Doctrine models: </h4>
            <?php if(!empty($models)) : ?>
            <ul>
                <?php foreach($models as $name => $methods) : ?>
                <?php if($methods['type'] == 'FormModel') : ?>
                    <?php continue; ?>
                    <?php endif; ?>
                <li>
                    <?php echo $name; ?>
                    <ul>
                        <?php foreach($methods as $method) : ?>
                        <?php if($method == 'Entity') continue; ?>
                        <li><?php echo $method; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else:  ?>
            <p>-</p>
            <?php endif; ?>
        </section>
        <section>
            <h4>Form models: </h4>
            <?php if(!empty($models)) : ?>
            <ul>
                <?php foreach($models as $name => $methods) : ?>
                <?php if($methods['type'] == 'Entity') : ?>
                    <?php continue; ?>
                    <?php endif; ?>
                <li>
                    <?php echo $name; ?>
                    <ul>
                        <?php foreach($methods as $id => $method) : ?>
                        <?php if(!is_numeric($id)) continue; ?>
                        <li>
                            <?php echo $method; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </section>
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
