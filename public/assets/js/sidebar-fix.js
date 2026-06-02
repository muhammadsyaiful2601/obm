$(document).ready(function() {
    // Fungsi pembantu untuk mereset NiceScroll bawaan template agar tidak freeze
    function updateNiceScrollSyaiful() {
        if (typeof $.fn.niceScroll !== 'undefined') {
            var $sidebar = $(".main-sidebar");
            if ($sidebar.getNiceScroll().length > 0) {
                $sidebar.getNiceScroll().resize();
            }
        }
    }

    // Memicu trigger klik toggle burger tanpa merusak fungsi internal Stisla
    $(document).on('click', '[data-toggle="sidebar"]', function() {
        setTimeout(function() {
            // Menyegarkan nicescroll agar kalkulasi tinggi sidebar tidak membeku di desktop/mobile
            updateNiceScrollSyaiful();
        }, 400);
    });
});