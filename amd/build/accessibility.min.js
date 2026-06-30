define(['jquery'], function($) {
    var settings = {
        fontScale: 1.0,
        grayscale: false,
        darkmode: false,
        contrast: false,
        hideToasts: false,
        themePreset: 'orange',
        layoutContainer: 'wide',
        fontFamily: 'inherit',
        themeTextColor: '#334155',
        themePrimary: '#F6A02A',
        themePrimaryHover: '#db891b',
        themeBg: '#ffffff',
        headerStyle: 'light'
    };

    var loadSettings = function() {
        var saved = localStorage.getItem('uena_accessibility_settings');
        if (saved) {
            try {
                var loaded = JSON.parse(saved);
                settings = $.extend({}, settings, loaded);
            } catch (e) {
                // Ignore parsing errors
            }
        }
    };

    var saveSettings = function() {
        localStorage.setItem('uena_accessibility_settings', JSON.stringify(settings));
    };

    var applySettings = function() {
        // Resolve theme presets
        if (settings.themePreset === 'orange') {
            settings.themePrimary = '#F6A02A';
            settings.themePrimaryHover = '#db891b';
            settings.themeBg = '#ffffff';
            settings.themeTextColor = '#334155';
        } else if (settings.themePreset === 'blue') {
            settings.themePrimary = '#0D6EFD';
            settings.themePrimaryHover = '#0b5ed7';
            settings.themeBg = '#ffffff';
            settings.themeTextColor = '#1E293B';
        } else if (settings.themePreset === 'green') {
            settings.themePrimary = '#198754';
            settings.themePrimaryHover = '#157347';
            settings.themeBg = '#ffffff';
            settings.themeTextColor = '#2F3E36';
        }

        // Apply font scale
        document.documentElement.style.setProperty('--accessibility-font-scale', settings.fontScale);

        // Apply grayscale
        if (settings.grayscale) {
            $('body').addClass('accessibility-grayscale');
        } else {
            $('body').removeClass('accessibility-grayscale');
        }

        // Apply dark mode
        if (settings.darkmode) {
            $('body').addClass('dark-mode');
            $('body').attr('data-theme-version', 'dark');
            // Sync with existing darkmode toggle button icon if present
            var toggleIcon = $('#dark-mode-toggle i');
            if (toggleIcon.length) {
                toggleIcon.removeClass('fa-moon').addClass('fa-sun');
            }
        } else {
            // Only remove dark mode if not explicitly enabled by other means
            var savedDarkMode = localStorage.getItem('theme_uena_darkmode');
            if (savedDarkMode !== 'dark') {
                $('body').removeClass('dark-mode');
                $('body').removeAttr('data-theme-version');
                var toggleIcon = $('#dark-mode-toggle i');
                if (toggleIcon.length) {
                    toggleIcon.removeClass('fa-sun').addClass('fa-moon');
                }
            }
        }

        // Apply high contrast
        if (settings.contrast) {
            $('body').addClass('accessibility-highcontrast');
        } else {
            $('body').removeClass('accessibility-highcontrast');
        }

        // Apply hide toasts
        if (settings.hideToasts) {
            $('body').addClass('accessibility-notoasts');
            $('#toast-status-badge').removeClass('bg-success').addClass('bg-secondary').text('Ocultas');
        } else {
            $('body').removeClass('accessibility-notoasts');
            $('#toast-status-badge').removeClass('bg-secondary').addClass('bg-success').text('Ativas');
        }

        // Apply font family
        document.documentElement.style.setProperty('--theme-font-family', settings.fontFamily);
        $('[data-style-action="font-family"]').val(settings.fontFamily);

        // Apply layout container width
        var containerWidth = '100%';
        if (settings.layoutContainer === 'boxed') {
            containerWidth = '1200px';
        } else if (settings.layoutContainer === 'wideboxed') {
            containerWidth = '1500px';
        }
        document.documentElement.style.setProperty('--theme-container-width', containerWidth);
        $('[data-style-action="layout-container"]').val(settings.layoutContainer || 'wide');

        // Apply text color
        document.documentElement.style.setProperty('--theme-text-color', settings.themeTextColor);
        $('.text-color-swatch').removeClass('active');
        var activeTextSwatch = $('.text-color-swatch[data-style-text-color="' + settings.themeTextColor + '"]');
        if (activeTextSwatch.length) {
            activeTextSwatch.addClass('active');
        }

        // Apply theme colors
        document.documentElement.style.setProperty('--theme-primary', settings.themePrimary);
        document.documentElement.style.setProperty('--theme-primary-hover', settings.themePrimaryHover);
        document.documentElement.style.setProperty('--theme-bg', settings.themeBg);
        
        // Highlight active swatch
        $('.color-swatch').removeClass('active');
        var activeSwatch = $('.color-swatch[data-style-color="' + settings.themePrimary + '"]');
        if (activeSwatch.length) {
            activeSwatch.addClass('active');
        }

        // Highlight active preset button
        $('[data-preset]').removeClass('active btn-primary').addClass('btn-outline-secondary');
        if (settings.themePreset && settings.themePreset !== 'custom') {
            $('[data-preset="' + settings.themePreset + '"]').addClass('active btn-primary').removeClass('btn-outline-secondary');
        }

        // Apply header styles
        var headerBg = '#ffffff';
        var headerColor = '#1d2125';
        var headerBorder = '#ced4da';
        var headerActiveBg = 'rgba(0, 0, 0, 0.05)';
        
        if (settings.headerStyle === 'dark') {
            headerBg = '#1d2125';
            headerColor = '#ffffff';
            headerBorder = '#2c3034';
            headerActiveBg = 'rgba(255, 255, 255, 0.15)';
        } else if (settings.headerStyle === 'theme') {
            headerBg = settings.themePrimary;
            headerColor = '#ffffff';
            headerBorder = settings.themePrimary;
            headerActiveBg = 'rgba(255, 255, 255, 0.2)';
        }
        
        document.documentElement.style.setProperty('--theme-header-bg', headerBg);
        document.documentElement.style.setProperty('--theme-header-color', headerColor);
        document.documentElement.style.setProperty('--theme-header-border', headerBorder);
        document.documentElement.style.setProperty('--theme-header-active-bg', headerActiveBg);
        
        // Highlight active header button
        $('[data-style-header]').removeClass('active btn-primary').addClass('btn-outline-secondary');
        $('[data-style-header="' + settings.headerStyle + '"]').addClass('active btn-primary').removeClass('btn-outline-secondary');
    };

    return {
        init: function() {
            loadSettings();
            applySettings();

            // Toggle Panel
            $(document).on('click', '[data-action="accessibility-toggle"]', function(e) {
                e.preventDefault();
                $('#accessibility-panel').toggleClass('d-none');
            });

            // Close panel when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#accessibility-panel').length && !$(e.target).closest('[data-action="accessibility-toggle"]').length) {
                    $('#accessibility-panel').addClass('d-none');
                }
            });

            // Font Increase (A+)
            $(document).on('click', '[data-accessibility="font-increase"]', function(e) {
                e.preventDefault();
                if (settings.fontScale < 1.5) {
                    settings.fontScale = parseFloat((settings.fontScale + 0.1).toFixed(1));
                    saveSettings();
                    applySettings();
                }
            });

            // Font Decrease (A-)
            $(document).on('click', '[data-accessibility="font-decrease"]', function(e) {
                e.preventDefault();
                if (settings.fontScale > 0.8) {
                    settings.fontScale = parseFloat((settings.fontScale - 0.1).toFixed(1));
                    saveSettings();
                    applySettings();
                }
            });

            // Grayscale Toggle
            $(document).on('click', '[data-accessibility="grayscale"]', function(e) {
                e.preventDefault();
                settings.grayscale = !settings.grayscale;
                saveSettings();
                applySettings();
            });

            // Dark Mode Toggle
            $(document).on('click', '[data-accessibility="darkmode"]', function(e) {
                e.preventDefault();
                settings.darkmode = true;
                settings.contrast = false; // Disable high contrast when changing theme
                localStorage.setItem('theme_uena_darkmode', 'dark'); // Sync darkmode theme setting
                saveSettings();
                applySettings();
            });

            // Light Mode Toggle
            $(document).on('click', '[data-accessibility="lightmode"]', function(e) {
                e.preventDefault();
                settings.darkmode = false;
                settings.contrast = false;
                localStorage.setItem('theme_uena_darkmode', 'light'); // Sync darkmode theme setting
                saveSettings();
                applySettings();
            });

             // High Contrast Toggle
            $(document).on('click', '[data-accessibility="contrast"]', function(e) {
                e.preventDefault();
                settings.contrast = !settings.contrast;
                if (settings.contrast) {
                    settings.grayscale = false; // Disable grayscale to prioritize high contrast colors
                }
                saveSettings();
                applySettings();
            });

            // Toggle Toasts click
            $(document).on('click', '[data-accessibility="toggle-toasts"]', function(e) {
                e.preventDefault();
                settings.hideToasts = !settings.hideToasts;
                saveSettings();
                applySettings();

                // If toasts are enabled, show a test toast!
                if (!settings.hideToasts) {
                    require(['core/toast'], function(Toast) {
                        Toast.add('Esta é uma notificação de teste para validar o novo visual!', {
                            title: 'Teste de Toast',
                            subtitle: 'Configurações de Acessibilidade',
                            type: 'info'
                        });
                    });
                }
            });

            // Preset themes click
            $(document).on('click', '[data-preset]', function(e) {
                e.preventDefault();
                settings.themePreset = $(this).attr('data-preset');
                saveSettings();
                applySettings();
            });

            // Font Family Dropdown select change
            $(document).on('change', '[data-style-action="font-family"]', function() {
                settings.fontFamily = $(this).val();
                saveSettings();
                applySettings();
            });

            // Layout Container Dropdown select change
            $(document).on('change', '[data-style-action="layout-container"]', function() {
                settings.layoutContainer = $(this).val();
                saveSettings();
                applySettings();
            });

            // Text Color Swatches click
            $(document).on('click', '[data-style-text-color]', function(e) {
                e.preventDefault();
                settings.themePreset = 'custom';
                settings.themeTextColor = $(this).attr('data-style-text-color');
                saveSettings();
                applySettings();
            });

            // Theme Color Swatches click
            $(document).on('click', '[data-style-color]', function(e) {
                e.preventDefault();
                settings.themePreset = 'custom';
                settings.themePrimary = $(this).attr('data-style-color');
                settings.themePrimaryHover = $(this).attr('data-style-color-hover');
                saveSettings();
                applySettings();
            });

            // Header Style Buttons click
            $(document).on('click', '[data-style-header]', function(e) {
                e.preventDefault();
                settings.headerStyle = $(this).attr('data-style-header');
                saveSettings();
                applySettings();
            });

            // Reset Accessibility Settings
            $(document).on('click', '[data-accessibility="reset"]', function(e) {
                e.preventDefault();
                settings.fontScale = 1.0;
                settings.grayscale = false;
                settings.darkmode = false;
                settings.contrast = false;
                settings.hideToasts = false;
                settings.themePreset = 'orange';
                settings.layoutContainer = 'wide';
                settings.fontFamily = 'inherit';
                settings.themeTextColor = '#334155';
                settings.themePrimary = '#F6A02A';
                settings.themePrimaryHover = '#db891b';
                settings.themeBg = '#ffffff';
                settings.headerStyle = 'light';
                localStorage.removeItem('theme_uena_darkmode');
                saveSettings();
                applySettings();
            });
        }
    };
});
