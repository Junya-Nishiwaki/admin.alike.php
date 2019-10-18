<div>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $index => $breadcrumb) { ?>
        <li>
            <?php if (array_key_exists('url', $breadcrumb)) { ?>
            <a href="<?php echo $breadcrumb['url']; ?>">
                <?php echo $breadcrumb['title']; ?>
            </a>
            <?php } else { ?>
            <?php echo $breadcrumb['title']; ?>
            <?php } ?>
            <?php if ($index + 1 < count($breadcrumbs)) { ?>
            <span class="divider">/</span>
            <?php } ?>
        </li>
        <?php } ?>
    </ul>
</div>
