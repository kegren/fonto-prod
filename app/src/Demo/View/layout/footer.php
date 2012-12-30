<footer id="footer" class="row-fluid">
    <p>
        <?php echo isset($themeCopyright) ? $themeCopyright : 'Fonto Framework'; ?>

        <span class="pull-right">
        <?php if(!empty($themeMenu)) : ?>
            <?php foreach($themeMenu as $title => $target) : ?>
                <?php echo $this->createLink(array($target), $title); ?>
            <?php endforeach; ?>
        <?php endif; ?>
        </span>
    </p>
</footer>
</div>
<script src="<?php echo $baseUrl; ?>web/app/Content/js/less-1.3.1.min.js" type="text/javascript"></script>
</body>
</html>