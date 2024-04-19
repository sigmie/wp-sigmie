<?php

/**
 * Form options admin template partial.
 */

?>

<div class="sgm-max-w-5xl sgm-mt-6 sgm-shadow-md sgm-bg-white sgm-rounded-md sgm-px-6 sgm-py-6">
    <img class="sgm-h-10 sgm-w-auto sgm-my-4" src="https://github.com/sigmie/art/raw/main/logo/png/logo-full-black.png" alt="Sigmie Logo" />
    <!-- <button type="button" class="sigmie-reindex-button button button-primary">
            <?php esc_html_e('Re-index all Products', 'sigmie'); ?>
        </button> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/resources/themes/aura-light-noir/theme.min.css" integrity="sha512-BscXyYLp90BO2aA7AHMPjY5POxLE5B6MPhsgD+QaMo3qhXvURXUynkuZtnOp+LoIJETO/rzUNBr6YwGwCXZpGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.4.21/vue.global.min.js" integrity="sha512-gEM2INjX66kRUIwrPiTBzAA6d48haC9kqrWZWjzrtnpCtBNxOXqXVFEeRDOeVC13pw4EOBrvlsJnNr2MXiQGvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/core/core.min.js" integrity="sha512-iiXT7reLIb9iSt+6eZ3cPWf6rwYyHrZBRypGrwEI0GRyebOEqFWrb0J1QVyvvZwRxY4vEb3oUpuiqDmIQ8SiSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/selectbutton/selectbutton.min.js" integrity="sha512-KobHihWFWszUiw/hnOsOQRdwPij7gy7SzcgSyp2mxoDRwgjNQa0p978/dQTRgbqwlP2zhAKkDpc7OnQ3PxM8ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/inlinemessage/inlinemessage.min.js" integrity="sha512-WJMJ7mcImbMReTxum35Vga7ad6GfBD31FhuZPSXxYtpB7ZHq+KSFpN7A9Kcfp18SuoH988s7LW8PrW9b+/VICQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/password/password.min.js" integrity="sha512-Qckm6ATq7+vssrRpm0c/tAt5JYbJI8p9khkYdBiPe8A7SVfZ5+t9mVxlhxS8Fuj2fm+kZi5Ap2KycBBBkdehsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/tabmenu/tabmenu.min.js" integrity="sha512-NO85jlmQHdCh90aAYvdX47u/AZ/Kz5OYiNw4J8nZ4y8bmLSpmXkK18VsjmaPcJP9yNnLz2awrMqPLZlDqHbmHQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/multiselect/multiselect.min.js" integrity="sha512-a4kQIiT3Jalf6exhLE5BF0FRGNy6JFK8t63jyZr562nXjq0DNarjAhpZmDI7JVLXiAbkxU1H1UOF1yv7HkZduA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/datatable/datatable.min.js" integrity="sha512-dlyFGXcd8+hiFyxBy5rNAI3/KPtypxobzHcYISdhfbFORv1c6XjYkNfgm/ofl3fajkODelWIBNf4nHkzTrYeEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/column/column.min.js" integrity="sha512-XQtHLI+r+xHNkBvL+jXurXMZ4vctIqCKvYkYI8W+bRvCBs74A6V9rAFD7RgYc4xGnaWLhI6ZiuD3fTIPdFkGJg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/picklist/picklist.min.js" integrity="sha512-ABGr5pnqCpdnCpQuS0HDMlEXJRv4BLmY91YLTQzpOAnTmvKbnFD0gEjFfziotEq41+dorzCcM7GK7d8ga6cRGw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/divider/divider.min.js" integrity="sha512-r9+Lk0wr7Nm7PX31L0N49kPisFcp7HNVSR4RpqT3wNP9kESucb/jDhnK6kdyzWAM+jzPmu6o1FNIUx1fY07BHg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/colorpicker/colorpicker.min.js" integrity="sha512-oR0xEMVqBjqHJD/PAFH17x73JB6Rbs+KklVxaGsEfZSmXtgMx2FJOJ0Oa4QTn7LTCESv/1hY8gfJoHSvDdP1RQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/primevue/3.51.0/inputnumber/inputnumber.min.js" integrity="sha512-g9krSgvy/kTeFLjh/GdRT6S3p2tDFEzoYtbNrYxAYLxziaP9A6Nx5AvxP6P6gvDYGagI3AjyLM0ZTjqYawlxfA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <form method="post" action="options.php">
        <div class="" id="sigmie-admin">
            <?php
            echo $this->render_component();
            ?>
        </div>
    </form>
</div>
