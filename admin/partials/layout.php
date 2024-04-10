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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/resources/themes/lara-light-amber/theme.min.css" integrity="sha512-aXsmKa5Voo3V5iB9BuUXE+iNZuC5wRGyZza5rOpFRHA24mYptZreQRy5bI+8nymMdh0X6jbUXDT06JuLDG4fkQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.4.21/vue.global.min.js" integrity="sha512-gEM2INjX66kRUIwrPiTBzAA6d48haC9kqrWZWjzrtnpCtBNxOXqXVFEeRDOeVC13pw4EOBrvlsJnNr2MXiQGvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/core/core.min.js" integrity="sha512-iiXT7reLIb9iSt+6eZ3cPWf6rwYyHrZBRypGrwEI0GRyebOEqFWrb0J1QVyvvZwRxY4vEb3oUpuiqDmIQ8SiSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/selectbutton/selectbutton.min.js" integrity="sha512-KobHihWFWszUiw/hnOsOQRdwPij7gy7SzcgSyp2mxoDRwgjNQa0p978/dQTRgbqwlP2zhAKkDpc7OnQ3PxM8ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <form method="post" action="options.php">
        <div id="sigmie-backend">
            <?php
            echo $this->render_component();
            ?>
        </div>
    </form>
</div>
