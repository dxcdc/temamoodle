define(['jquery'], function($) {
    return {
        init: function() {
            var toggleBtn = $('#dark-mode-toggle');
            var icon = toggleBtn.find('i');
            
            // Check local storage
            var currentMode = localStorage.getItem('theme_uena_darkmode');
            if (currentMode === 'dark') {
                $('body').addClass('dark-mode');
                $('body').attr('data-theme-version', 'dark');
                icon.removeClass('fa-moon').addClass('fa-sun');
            }
            
            toggleBtn.on('click', function(e) {
                e.preventDefault();
                $('body').toggleClass('dark-mode');
                
                if ($('body').hasClass('dark-mode')) {
                    $('body').attr('data-theme-version', 'dark');
                    localStorage.setItem('theme_uena_darkmode', 'dark');
                    icon.removeClass('fa-moon').addClass('fa-sun');
                } else {
                    $('body').removeAttr('data-theme-version');
                    localStorage.setItem('theme_uena_darkmode', 'light');
                    icon.removeClass('fa-sun').addClass('fa-moon');
                }
            });
        }
    };
});
