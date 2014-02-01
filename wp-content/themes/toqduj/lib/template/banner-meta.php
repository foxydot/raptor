<div class="my_meta_control" id="banner_metabox">
    <p>
        <?php $mb->the_field('title'); ?>
        <label>Title</label>
        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
    </p>
    <p>
        <?php $mb->the_field('subtitle'); ?>
        <label>Subtitle</label>
        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
    </p>
    <p>
        <em>Note: Place banner image in "Featured Image" for this page.</em>
    </p>
</div>