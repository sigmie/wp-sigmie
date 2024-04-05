<?php

/**
 * Form options admin template partial.
 */

?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?>
        <button type="button" class="sigmie-reindex-button button button-primary">
            <?php esc_html_e('Re-index all Products', 'sigmie'); ?>
        </button>
    </h1>
    <?php if (!has_action('wpswa_pro_override_settings_output')) : ?>
        <form method="post" action="options.php">
            <div id="sigmie-backend">
                <indexing></indexing>
            </div>
            <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
            <?php
            settings_fields($this->option_group);
            do_settings_sections($this->slug);
            submit_button();
            ?>
        </form>
    <?php else : ?>
        <?php do_action('wpswa_pro_override_settings_output'); ?>
    <?php endif; ?>
</div>
