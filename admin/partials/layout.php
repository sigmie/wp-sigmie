<?php

/**
 * Form options admin template partial.
 */

?>

<div class="">
    <h1>
        <img class="sgm-h-10 sgm-w-auto sgm-my-5" src="https://github.com/sigmie/art/raw/main/logo/png/logo-full-black.png" alt="Sigmie Logo" />
        <!-- <button type="button" class="sigmie-reindex-button button button-primary">
            <?php esc_html_e('Re-index all Products', 'sigmie'); ?>
        </button> -->
    </h1>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/resources/themes/aura-light-noir/theme.min.css" integrity="sha512-BscXyYLp90BO2aA7AHMPjY5POxLE5B6MPhsgD+QaMo3qhXvURXUynkuZtnOp+LoIJETO/rzUNBr6YwGwCXZpGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.4.21/vue.global.min.js" integrity="sha512-gEM2INjX66kRUIwrPiTBzAA6d48haC9kqrWZWjzrtnpCtBNxOXqXVFEeRDOeVC13pw4EOBrvlsJnNr2MXiQGvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/core/core.min.js" integrity="sha512-iiXT7reLIb9iSt+6eZ3cPWf6rwYyHrZBRypGrwEI0GRyebOEqFWrb0J1QVyvvZwRxY4vEb3oUpuiqDmIQ8SiSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/selectbutton/selectbutton.min.js" integrity="sha512-KobHihWFWszUiw/hnOsOQRdwPij7gy7SzcgSyp2mxoDRwgjNQa0p978/dQTRgbqwlP2zhAKkDpc7OnQ3PxM8ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/inlinemessage/inlinemessage.min.js" integrity="sha512-WJMJ7mcImbMReTxum35Vga7ad6GfBD31FhuZPSXxYtpB7ZHq+KSFpN7A9Kcfp18SuoH988s7LW8PrW9b+/VICQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/password/password.min.js" integrity="sha512-Qckm6ATq7+vssrRpm0c/tAt5JYbJI8p9khkYdBiPe8A7SVfZ5+t9mVxlhxS8Fuj2fm+kZi5Ap2KycBBBkdehsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <form method="post" action="options.php">
        <div id="sigmie-admin">
            <?php
            echo $this->render_component();
            ?>
        </div>
    </form>
</div>
