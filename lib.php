<?php
/**
 * Uena Moodle Theme library functions
 *
 * @package    theme_cdc_moodle
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Returns pre SCSS containing variable overrides.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_cdc_moodle_get_pre_scss($theme) {
    $scss = '';
    
    // Uena Core Colors
    $scss .= '$primary: #FF720D !default;' . "\n";
    $scss .= '$secondary: #DB891B !default;' . "\n";
    $scss .= '$success: #68CF29 !default;' . "\n";
    $scss .= '$info: #3A82EF !default;' . "\n";
    $scss .= '$warning: #FFAB2D !default;' . "\n";
    $scss .= '$danger: #f72b50 !default;' . "\n";
    $scss .= '$light: #c8c8c8 !default;' . "\n";
    
    // Backgrounds and Typography
    $scss .= '$body-bg: #ffffff !default;' . "\n";
    $scss .= '$body-color: #7e7e7e !default;' . "\n";
    $scss .= '$font-family-base: "Roboto", sans-serif !default;' . "\n";
    $scss .= '$border-radius: 0.75rem !default;' . "\n";
    $scss .= '$border-color: #EEEEEE !default;' . "\n";
    
    // Card overrides
    $scss .= '$card-border-radius: 0.75rem !default;' . "\n";
    $scss .= '$card-border-color: rgba(0,0,0,0) !default;' . "\n";
    $scss .= '$card-spacer-x: 1.875rem !default;' . "\n";
    $scss .= '$card-spacer-y: 1.875rem !default;' . "\n";

    // Uena custom layout variables
    $scss .= '$dz-pos-right: right !default;' . "\n";
    $scss .= '$dz-pos-left: left !default;' . "\n";
    $scss .= '$radius: 0.75rem !default;' . "\n";
    $scss .= '$white: #fff !default;' . "\n";
    $scss .= '$d-bg: #1e1e1e !default;' . "\n";
    $scss .= '$d-border: #333 !default;' . "\n";
    
    // Complete Uena variables set
    $scss .= '
$strong:#646c9a;
$border: rgba(238, 238, 238, 1);
$shadow: 0px 0px 40px 0px rgba(0,0,0,0.06);
$charade: #23252F;

$d-ctd: #ddd;
$d-ctl: #828690;
$d-border: #3E3E3E;
$d-bg: #0E0803;
$dark-card: #2B2623;
$dark_bg_lighter: #1E2A4A;

$primary-light: lighten($primary, 40%);
$secondary-light: lighten($secondary, 40%);
$success-light: lighten($success, 45%);
$warning-light: lighten($warning, 34%);
$danger-light: lighten($danger, 38%);
$info-light: lighten($info, 37%);

$primary-opacity: rgba($primary, 0.2);
$secondary-opacity: rgba($secondary, 0.5);
$success-opacity: rgba($success, 0.1);
$warning-opacity: rgba($warning, 0.1);
$danger-opacity: rgba($danger, 0.15);
$info-opacity: rgba($info, 0.1);

$l-ctd: #464a53;
$l-ctl: #828690;
$l-border: #eaeaea;
$l-bg: #f2f4fa;
$heading: #333;

$dusty-gray: #999999;
$gallery: #EEEEEE;
$gray: #898989;
$input-border-color: $border;

$facebook: #3b5998;
$twitter: #1da1f2;
$youtube: #FF0000;
$google-plus: #db4439;
$linkedin: #007bb6;
$instagram: #c32aa3;
$pinterest: #bd081c;
$google: #4285f4;
$snapchat: #fffc00;
$whatsapp: #25d366;
$tumblr: #35465d;
$reddit: #ff4500;
$spotify: #1ed760;
$yahoo: #430297;
$dribbble: #ea4c89;
$skype: #00aff0;
$quora: #aa2200;
$riverBed: #4C585C;
$vimeo: #1ab7ea;

$iron: #DDDFE1;
$grey: #D2D6DE;
$pale-sky: #6a707e;
$athensGray: #F0F0F2;
$sky: #2290FF;

$color_pallate_1: $white;
$color_pallate_2: #6610f2;
$color_pallate_3: $primary;
$color_pallate_4: #e83e8c;
$color_pallate_5: #dc3545;
$color_pallate_6:  #fd7e14;
$color_pallate_7: #ffc107;
$color_pallate_8: #28a745;
$color_pallate_9:  #20c997;
$color_pallate_10:  #17a2b8;
$color_pallate_11: #6c757d;
$color_pallate_12:#343a40 ;
$color_pallate_13: #2a2a2a;
$color_pallate_14: #4885ed;
$color_pallate_15: #4cb32b;

$dark: #2e384d !default;
$dark-opacity: rgba(46, 56, 77, 0.35) !default;
$dark-light: rgba(46, 56, 77, 0.1) !default;
';

    return $scss;
}

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_cdc_moodle_get_main_scss_content($theme) {
    global $CFG;
    $scss = '';
    
    // Custom CSS rules to apply Uena's feel (Cards, Shadows, Buttons)
    $scss .= '
        .card {
            box-shadow: 0px 0px 40px 0px rgba(0, 0, 0, 0.06) !important;
            border-radius: 0.75rem !important;
            border: 1px solid #ced4da !important;
            margin-bottom: 1.875rem;
        }
        /* Search input border styling to match filters button */
        .searchbar input.form-control, 
        .simplesearchform input.form-control,
        input[data-action="search"] {
            border: 1px solid #ced4da !important;
            box-shadow: none !important;
        }
        .searchbar input.form-control:focus, 
        .simplesearchform input.form-control:focus,
        input[data-action="search"]:focus {
            border-color: #FF720D !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 114, 13, 0.25) !important;
        }
        .btn {
            border-radius: 0.75rem;
            font-weight: 500;
        }
        #page-wrapper, #page {
            background-color: var(--theme-bg, #ffffff) !important;
        }
        /* Uena Authentication Page Overrides */
        .authincation {
            background: url(\'' . $CFG->wwwroot . '/login_bg.png\') no-repeat center center !important;
            background-size: cover !important;
            min-height: 100vh;
            height: auto !important;
        }
        .authincation-content {
            background: #fff;
            box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
            border-radius: 0.75rem;
        }
        .auth-form {
            padding: 50px;
        }
        .path-login .login-wrapper {
            background: none !important;
            box-shadow: none !important;
        }
        /* Uena Navigation & Header Overrides (Safe CSS approach) */
        .navbar.fixed-top {
            background-color: #fff !important;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
            height: 5.5rem;
            border-bottom: none;
        }
        .navbar-brand {
            font-weight: 600;
            color: #FF720D !important;
            font-size: 1.5rem;
        }
        
        /* Remove borders and style usermenu toggle dropdown in navbar */
        #usernavigation {
            align-items: center !important;
        }
        #usernavigation .usermenu {
            display: flex !important;
            align-items: center !important;
        }
        #user-menu-toggle {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            height: auto !important;
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
        }
        #user-menu-toggle::after {
            display: none !important;
        }
        #user-menu-toggle:focus,
        #user-menu-toggle:active {
            outline: none !important;
            box-shadow: none !important;
            border: none !important;
        }
        .usermenu-container {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
        .usermenu .avatars {
            display: flex !important;
            align-items: center !important;
        }
        .usermenu .avatar {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .usermenu .userpicture,
        .usermenu .avatar img {
            border: none !important;
            border-radius: 50% !important;
            width: 38px !important;
            height: 38px !important;
            max-width: 38px !important;
            max-height: 38px !important;
            object-fit: cover !important;
        }
        .usermenu .avatar span.userinitials {
            background-color: rgba(255, 114, 13, 0.1) !important;
            color: #FF720D !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 50% !important;
            width: 38px !important;
            height: 38px !important;
        }
        .drawer {
            background-color: #fff !important;
            box-shadow: 5px 0px 20px rgba(0, 0, 0, 0.05);
            border-right: none;
        }
        .drawer .list-group-item {
            border: none;
            border-radius: 0.5rem;
            margin: 0.2rem 1rem;
            color: #7e7e7e;
        }
        .drawer .list-group-item:hover, .drawer .list-group-item.active {
            background-color: rgba(255, 114, 13, 0.1) !important;
            color: #FF720D !important;
            font-weight: 500;
        }
        /* Course cards action menu transparency overrides */
        .course-card, .dashboard-card {
            .dropdown, .action-menu, .btn-link, .btn-icon, .bg-white, [data-region="course-content"] .bg-white {
                background-color: transparent !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
            }
        }
        /* Floating help button red-crimson style floating above footer */
        .btn-footer-popover {
            background-color: #F6A02A !important;
            color: #ffffff !important;
            border: none !important;
            bottom: 120px !important;
            box-shadow: 0px 4px 10px rgba(246, 160, 42, 0.3) !important;
            z-index: 1050 !important;
        }
        .btn-footer-popover:hover, .btn-footer-popover:focus {
            background-color: #db891b !important;
            color: #ffffff !important;
        }
        /* Moodle primary buttons override using new brand color #F6A02A */
        .btn-primary, #loginbtn {
            background-color: #F6A02A !important;
            border-color: #F6A02A !important;
            color: #ffffff !important;
        }
        .btn-primary:hover, .btn-primary:focus, #loginbtn:hover, #loginbtn:focus {
            background-color: #db891b !important;
            border-color: #db891b !important;
            color: #ffffff !important;
        }
        /* Inline password login button alignments */
        .login-form-password button#loginbtn {
            height: calc(1.5em + 1rem + 2px) !important; /* Perfect height matching password input */
            padding: 0.5rem 1rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 600 !important;
        }
        /* Prevent password visibility toggle button from wrapping on login form */
        .toggle-sensitive-wrapper {
            display: flex !important;
            flex-wrap: nowrap !important;
            width: 100% !important;
            position: relative !important;
        }
        .toggle-sensitive-wrapper .form-control {
            flex-grow: 1 !important;
            width: auto !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        .toggle-sensitive-wrapper .toggle-sensitive-btn {
            flex-shrink: 0 !important;
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
            border-top-right-radius: 0.75rem !important;
            border-bottom-right-radius: 0.75rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0.5rem 0.75rem !important;
            border-left: none !important;
            height: calc(1.5em + 1rem + 2px) !important;
        }
        /* Orange social icons override on login page */
        .login-socials a, .login-socials i {
            color: #F6A02A !important;
            transition: color 0.2s ease-in-out;
        }
        .login-socials a:hover i {
            color: #db891b !important;
        }
        /* Reduce language menu and cookie notice spacing on login form */
        .login-languagemenu {
            margin-top: 1rem !important;
            margin-bottom: 0.5rem !important;
        }
        .login-cookiesnotice {
            margin-top: 0.5rem !important;
        }
        /* Header signup button styling */
        .header-signup-btn {
            border-color: #F6A02A !important;
            color: #F6A02A !important;
            background-color: transparent !important;
            transition: all 0.25s ease-in-out !important;
        }
        .header-signup-btn:hover, .header-signup-btn:focus {
            background-color: #F6A02A !important;
            border-color: #F6A02A !important;
            color: #ffffff !important;
        }
        /* Footer social icons style */
        .login-socials-footer a {
            color: #ffffff !important;
            font-size: 1.25rem !important;
            transition: all 0.2s ease-in-out !important;
        }
        .login-socials-footer a:hover i {
            color: #1d2125 !important;
        }
        
        /* Registration Page (Signup) UX Overrides */
        .path-login-signup .authincation-content {
            max-width: 680px !important; /* Make card wider on desktop for registration fields */
        }
        .path-login-signup .mform {
            width: 100% !important;
        }
        .path-login-signup .mform legend {
            font-size: 1.15rem !important;
            font-weight: 700 !important;
            color: #2d3748 !important;
            border-bottom: 2px solid rgba(246, 160, 42, 0.1) !important;
            padding-bottom: 0.5rem !important;
            margin-bottom: 1.5rem !important;
            width: 100% !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }
        .path-login-signup .form-control {
            border-radius: 0.75rem !important;
            padding: 0.6rem 1rem !important;
            border: 1px solid #ced4da !important;
            transition: all 0.2s ease-in-out !important;
        }
        .path-login-signup .form-control:focus {
            border-color: #F6A02A !important;
            box-shadow: 0 0 0 3px rgba(246, 160, 42, 0.15) !important;
        }
        .path-login-signup .col-form-label {
            font-weight: 600 !important;
            color: #495057 !important;
            font-size: 0.9rem !important;
            margin-bottom: 0.25rem !important;
        }
        .path-login-signup .req {
            color: #f72b50 !important;
            font-weight: bold !important;
        }
        .path-login-signup .form-buttons, 
        .path-login-signup .fitem_fsubmit {
            margin-top: 1.5rem !important;
            border-top: 1px solid #e9ecef !important;
            padding-top: 1.5rem !important;
            display: flex !important;
            justify-content: flex-end !important;
            gap: 10px !important;
        }
        .path-login-signup #id_submitbutton {
            background-color: #F6A02A !important;
            border-color: #F6A02A !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            border-radius: 0.75rem !important;
            padding: 0.6rem 2rem !important;
            transition: all 0.2s ease-in-out !important;
        }
        .path-login-signup #id_submitbutton:hover {
            background-color: #db891b !important;
            border-color: #db891b !important;
        }
        .path-login-signup #id_cancel {
            border-radius: 0.75rem !important;
            padding: 0.6rem 2rem !important;
            font-weight: 600 !important;
            background-color: #f8f9fa !important;
            border-color: #ced4da !important;
            color: #495057 !important;
            transition: all 0.2s ease-in-out !important;
        }
        .path-login-signup #id_cancel:hover {
            background-color: #e2e6ea !important;
            color: #212529 !important;
        }
        /* Custom styles for tool_policy checkboxes */
        .path-login-signup .form-check {
            padding-left: 1.75rem !important;
            margin-bottom: 0.75rem !important;
        }
        .path-login-signup .form-check-input {
            width: 1.15rem !important;
            height: 1.15rem !important;
            margin-left: -1.75rem !important;
            border-radius: 0.25rem !important;
            border-color: #ced4da !important;
            cursor: pointer !important;
        }
        .path-login-signup .form-check-input:checked {
            background-color: #F6A02A !important;
            border-color: #F6A02A !important;
        }
        .path-login-signup .form-check-label {
            font-size: 0.875rem !important;
            color: #495057 !important;
            cursor: pointer !important;
        }
        .path-login-signup .form-check-label a {
            color: #F6A02A !important;
            font-weight: 600 !important;
            text-decoration: underline !important;
        }
        
        /* Uena Premium Alert & Modal Entrance Animations */
        @keyframes alertFadeIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes modalScaleIn {
            from {
                opacity: 0;
                transform: scale(0.96) translateY(-10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        /* Uena Premium Alert Style Overrides for Moodle */
        .alert {
            border: none !important;
            border-left: 4px solid transparent !important;
            border-radius: 0.5rem !important;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05) !important;
            padding: 1rem 1.25rem !important;
            font-size: 0.875rem !important;
            animation: alertFadeIn 0.22s ease-out forwards !important;
        }
        .alert-primary {
            background-color: rgba(255, 114, 13, 0.08) !important;
            border-left-color: #FF720D !important;
            color: #FF720D !important;
        }
        .alert-secondary {
            background-color: rgba(172, 76, 188, 0.08) !important;
            border-left-color: #AC4CBC !important;
            color: #AC4CBC !important;
        }
        .alert-success {
            background-color: rgba(104, 207, 41, 0.08) !important;
            border-left-color: #68CF29 !important;
            color: #68CF29 !important;
        }
        .alert-info {
            background-color: rgba(58, 130, 239, 0.08) !important;
            border-left-color: #3A82EF !important;
            color: #3A82EF !important;
        }
        .alert-warning {
            background-color: rgba(255, 171, 45, 0.08) !important;
            border-left-color: #FFAB2D !important;
            color: #FFAB2D !important;
        }
        .alert-danger {
            background-color: rgba(247, 43, 80, 0.08) !important;
            border-left-color: #f72b50 !important;
            color: #f72b50 !important;
        }

        /* Uena Premium Modal Style Overrides for Moodle */
        .modal-content {
            border-radius: 1rem !important;
            border: none !important;
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.15) !important;
            background-color: #ffffff !important;
        }
        .modal.show .modal-dialog {
            animation: modalScaleIn 0.28s cubic-bezier(0.34, 1.56, 0.64, 1) forwards !important;
        }
        .modal-header {
            border-bottom: 1px solid #f0f0f0 !important;
            padding: 1.25rem 1.5rem !important;
        }
        .modal-footer {
            border-top: 1px solid #f0f0f0 !important;
            padding: 1rem 1.5rem !important;
        }
        
        body.dark-mode .modal-content {
            background-color: #1e293b !important;
            color: #ffffff !important;
            border: 1px solid #334155 !important;
        }
        body.dark-mode .modal-header {
            border-bottom: 1px solid #334155 !important;
        }
        body.dark-mode .modal-footer {
            border-top: 1px solid #334155 !important;
        }

        body.accessibility-highcontrast .alert {
            background-color: #0F172A !important;
            border: 2px solid #38BDF8 !important;
            color: #38BDF8 !important;
            animation: none !important;
        }
        body.accessibility-highcontrast .modal-content {
            background-color: #1E293B !important;
            border: 2px solid #475569 !important;
            color: #F8FAFC !important;
        }

        /* Uena Premium Toast Overrides for Moodle */
        .toast-wrapper {
            top: auto !important;
            bottom: 20px !important;
            right: 20px !important;
            left: auto !important;
            position: fixed !important;
            width: 350px !important;
            max-width: 350px !important;
            z-index: 1080 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
        }
        .toast {
            border-radius: 0.5rem !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0px 10px 35px rgba(0, 0, 0, 0.08) !important;
            background-color: #ffffff !important;
            color: #1d2125 !important;
            width: 100% !important;
            max-width: 100% !important;
            opacity: 1 !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .toast-header {
            background-color: #ffffff !important;
            color: #1d2125 !important;
            border-bottom: 1px solid #f0f0f0 !important;
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
        }
        .toast-title {
            font-weight: 600 !important;
            color: #1d2125 !important;
        }
        .toast-subtitle {
            color: #6c757d !important;
            font-size: 0.75rem !important;
        }
        .toast-body {
            padding: 0.75rem 1rem !important;
            font-size: 0.825rem !important;
            background-color: #ffffff !important;
            border-bottom-left-radius: 0.5rem !important;
            border-bottom-right-radius: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
        }
        .toast-message {
            color: #495057 !important;
            line-height: 1.4 !important;
        }
        body.dark-mode .toast,
        body.dark-mode .toast-header,
        body.dark-mode .toast-body {
            background-color: #1e293b !important;
            color: #ffffff !important;
            border-color: #334155 !important;
        }
        body.dark-mode .toast-title {
            color: #ffffff !important;
        }
        body.dark-mode .toast-message {
            color: #e2e8f0 !important;
        }
        body.dark-mode .toast-header {
            border-bottom-color: #334155 !important;
        }
        body.accessibility-highcontrast .toast {
            background-color: #0F172A !important;
            border: 2px solid #38BDF8 !important;
            color: #F8FAFC !important;
        }
        body.accessibility-highcontrast .toast-header,
        body.accessibility-highcontrast .toast-body {
            background-color: #0F172A !important;
            color: #F8FAFC !important;
            border-color: #38BDF8 !important;
        }

        /* Uena Premium Toast Inner Elements */
        .toast-alert-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(255, 114, 13, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .toast-success .toast-alert-icon {
            background-color: rgba(104, 207, 41, 0.08) !important;
        }
        .toast-danger .toast-alert-icon {
            background-color: rgba(247, 43, 80, 0.08) !important;
        }
        .toast-warning .toast-alert-icon {
            background-color: rgba(255, 171, 45, 0.08) !important;
        }
        .toast-info .toast-alert-icon {
            background-color: rgba(58, 130, 239, 0.08) !important;
        }
        
        .toast-avatar-img {
            border-radius: 0.35rem !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }
        .toast-avatar-placeholder {
            border-radius: 0.35rem !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }
        body.dark-mode .toast-avatar-placeholder {
            background-color: #334155 !important;
            border-color: #475569 !important;
        }
        body.dark-mode .toast-avatar-img {
            border-color: #334155 !important;
        }

        /* Option to disable Toast notifications */
        body.accessibility-notoasts .toast-wrapper {
            display: none !important;
        }

        /* Form Inline Validation Feedback Overrides */
        .invalid-feedback,
        .form-control-feedback,
        .error {
            color: #f72b50 !important;
            font-size: 0.775rem !important;
            font-weight: 500 !important;
            margin-top: 0.35rem !important;
            display: block !important;
        }
        .is-invalid,
        input.error {
            border-color: #f72b50 !important;
        }
        .is-invalid:focus,
        input.error:focus {
            box-shadow: 0 0 0 0.2rem rgba(247, 43, 80, 0.2) !important;
        }

        /* Global Accessibility Styling */
        
        :root {
            --accessibility-font-scale: 1.0;
            --theme-primary: #F6A02A;
            --theme-primary-hover: #db891b;
            --theme-bg: #ffffff;
            --theme-container-width: 100%;
            --theme-font-family: inherit;
            --theme-text-color: #1d2125;
            --theme-header-bg: #ffffff;
            --theme-header-color: #1d2125;
            --theme-header-border: #ced4da;
            --theme-header-active-bg: rgba(0, 0, 0, 0.05);
        }
        
        /* Container layout width overrides */
        #page.drawers .main-inner,
        .main-inner {
            max-width: var(--theme-container-width, 100%) !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: 100% !important;
            transition: max-width 0.22s ease-in-out !important;
        }
        
        /* Font Family Override */
        body, p, span, div, h1, h2, h3, h4, h5, h6, input, select, textarea, button, a {
            font-family: var(--theme-font-family) !important;
        }

        /* Body Font Color Override (Only in light mode) */
        body:not(.dark-mode):not(.accessibility-highcontrast), 
        body:not(.dark-mode):not(.accessibility-highcontrast) p, 
        body:not(.dark-mode):not(.accessibility-highcontrast) span:not(.badge):not(.fa):not(.fab):not(.fas), 
        body:not(.dark-mode):not(.accessibility-highcontrast) li, 
        body:not(.dark-mode):not(.accessibility-highcontrast) td, 
        body:not(.dark-mode):not(.accessibility-highcontrast) th, 
        body:not(.dark-mode):not(.accessibility-highcontrast) label {
            color: var(--theme-text-color) !important;
        }

        /* Primary Colors Override */
        /* Primary Colors Override */
        .btn-primary, #loginbtn, .btn-outline-primary:hover, .btn-outline-primary:focus,
        button[data-action="toggle-block-editing"], .btn[data-action="toggle-block-editing"],
        a[href*="editblocks"], .btn[href*="editblocks"],
        #theme_boost-drawers-blocks .btn-secondary, #theme_boost-drawers-blocks .btn-light,
        #theme_boost-drawers-blocks button, #theme_boost-drawers-blocks a.btn,
        #blocks-drawer .btn-secondary, #blocks-drawer .btn-light,
        #blocks-drawer button, #blocks-drawer a.btn {
            background-color: var(--theme-primary) !important;
            border-color: var(--theme-primary) !important;
            color: #ffffff !important;
        }
        .btn-primary:hover, .btn-primary:focus, #loginbtn:hover, #loginbtn:focus,
        button[data-action="toggle-block-editing"]:hover, .btn[data-action="toggle-block-editing"]:hover,
        a[href*="editblocks"]:hover, .btn[href*="editblocks"]:hover,
        #theme_boost-drawers-blocks .btn-secondary:hover, #theme_boost-drawers-blocks .btn-light:hover,
        #theme_boost-drawers-blocks button:hover, #theme_boost-drawers-blocks a.btn:hover,
        #blocks-drawer .btn-secondary:hover, #blocks-drawer .btn-light:hover,
        #blocks-drawer button:hover, #blocks-drawer a.btn:hover {
            background-color: var(--theme-primary-hover) !important;
            border-color: var(--theme-primary-hover) !important;
            color: #ffffff !important;
        }
        .text-primary, a.text-primary {
            color: var(--theme-primary) !important;
        }
        
        /* Header Signup Button Override */
        .header-signup-btn {
            border-color: var(--theme-primary) !important;
            color: var(--theme-primary) !important;
            background-color: transparent !important;
            transition: all 0.25s ease-in-out !important;
        }
        .header-signup-btn:hover, .header-signup-btn:focus {
            background-color: var(--theme-primary) !important;
            border-color: var(--theme-primary) !important;
            color: #ffffff !important;
        }

        /* Top Header / Moodle Navbar Styling (targets bg-body and bg-white to override utility classes) */
        header.bg-white, 
        .navbar.fixed-top, 
        .navbar.fixed-top.bg-body, 
        .navbar.fixed-top.bg-white {
            background-color: var(--theme-header-bg) !important;
            color: var(--theme-header-color) !important;
            border-bottom: 1px solid var(--theme-header-border) !important;
            height: 60px !important;
            min-height: 60px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        .navbar.fixed-top .container-fluid {
            height: 100% !important;
        }
        
        /* Force color variables on specific Bootstrap and Moodle Navbar elements */
        .navbar.fixed-top .nav-link,
        .navbar.fixed-top .nav-link i,
        .navbar.fixed-top .nav-link .icon,
        .navbar.fixed-top .navbar-brand,
        .navbar.fixed-top .navbar-brand *,
        .navbar.fixed-top .primary-navigation .nav-link,
        .navbar.fixed-top .primary-navigation .nav-link *,
        .navbar.fixed-top #usernavigation .nav-link,
        .navbar.fixed-top #usernavigation .nav-link i,
        .navbar.fixed-top #usernavigation .nav-link .icon,
        .navbar.fixed-top #usernavigation .nav-link *,
        .navbar.fixed-top #usernavigation .btn,
        .navbar.fixed-top #usernavigation .btn i,
        .navbar.fixed-top #usernavigation .btn .icon,
        .navbar.fixed-top #usernavigation .btn *,
        .navbar.fixed-top #usernavigation .popover-region-toggle,
        .navbar.fixed-top #usernavigation .popover-region-toggle i,
        .navbar.fixed-top #usernavigation .popover-region-toggle .icon,
        .navbar.fixed-top #usernavigation .popover-region-toggle *,
        .navbar.fixed-top .editmode-switch-text,
        .navbar.fixed-top .editmode-switch-form,
        .navbar.fixed-top .editmode-switch-form *,
        .navbar.fixed-top .editmode-switch-form label,
        .navbar.fixed-top .editmode-switch-form span,
        .navbar.fixed-top .navbar-toggler,
        .navbar.fixed-top .navbar-toggler-icon,
        .navbar.fixed-top .divider,
        .navbar.fixed-top i,
        .navbar.fixed-top .icon {
            color: var(--theme-header-color) !important;
            border-color: var(--theme-header-color) !important;
        }
        
        /* Navbar active element background bubble */
        .navbar.fixed-top .primary-navigation .moremenu .nav-link.active,
        .navbar.fixed-top #usernavigation .nav-link.active {
            background-color: var(--theme-header-active-bg) !important;
            color: var(--theme-header-color) !important;
        }
        
        /* Keep dropdown menu contents dark/readable when opened */
        .navbar.fixed-top .dropdown-menu,
        .navbar.fixed-top .dropdown-menu *,
        .navbar.fixed-top .dropdown-menu a,
        .navbar.fixed-top .dropdown-menu span {
            color: #1d2125 !important;
            background-color: #ffffff !important;
        }
        .navbar.fixed-top .dropdown-menu a:hover {
            background-color: #f8f9fa !important;
        }
        
        /* Force Dark Mode styles on Navbar background, text and icons */
        body.dark-mode header.bg-white, 
        body.dark-mode .navbar.fixed-top, 
        body.dark-mode .navbar.fixed-top.bg-body, 
        body.dark-mode .navbar.fixed-top.bg-white {
            background-color: #1d2125 !important;
            border-bottom: 1px solid #2c3034 !important;
        }
        
        body.dark-mode .navbar.fixed-top .nav-link,
        body.dark-mode .navbar.fixed-top .nav-link i,
        body.dark-mode .navbar.fixed-top .nav-link .icon,
        body.dark-mode .navbar.fixed-top .navbar-brand,
        body.dark-mode .navbar.fixed-top .navbar-brand *,
        body.dark-mode .navbar.fixed-top .primary-navigation .nav-link,
        body.dark-mode .navbar.fixed-top .primary-navigation .nav-link *,
        body.dark-mode .navbar.fixed-top #usernavigation .nav-link,
        body.dark-mode .navbar.fixed-top #usernavigation .nav-link i,
        body.dark-mode .navbar.fixed-top #usernavigation .nav-link .icon,
        body.dark-mode .navbar.fixed-top #usernavigation .nav-link *,
        body.dark-mode .navbar.fixed-top #usernavigation .btn,
        body.dark-mode .navbar.fixed-top #usernavigation .btn i,
        body.dark-mode .navbar.fixed-top #usernavigation .btn .icon,
        body.dark-mode .navbar.fixed-top #usernavigation .btn *,
        body.dark-mode .navbar.fixed-top #usernavigation .popover-region-toggle,
        body.dark-mode .navbar.fixed-top #usernavigation .popover-region-toggle i,
        body.dark-mode .navbar.fixed-top #usernavigation .popover-region-toggle .icon,
        body.dark-mode .navbar.fixed-top #usernavigation .popover-region-toggle *,
        body.dark-mode .navbar.fixed-top .editmode-switch-text,
        body.dark-mode .navbar.fixed-top .editmode-switch-form,
        body.dark-mode .navbar.fixed-top .editmode-switch-form *,
        body.dark-mode .navbar.fixed-top .editmode-switch-form label,
        body.dark-mode .navbar.fixed-top .editmode-switch-form span,
        body.dark-mode .navbar.fixed-top .navbar-toggler,
        body.dark-mode .navbar.fixed-top .navbar-toggler-icon,
        body.dark-mode .navbar.fixed-top .divider,
        body.dark-mode .navbar.fixed-top i,
        body.dark-mode .navbar.fixed-top .icon {
            color: #ffffff !important;
            border-color: #ffffff !important;
        }
        
        /* Swatch Border customizer styling */
        .color-swatch {
            border: 2px solid #dee2e6 !important;
            transition: all 0.15s ease-in-out;
        }
        .color-swatch.active {
            border: 2px solid #111111 !important;
        }
        body.dark-mode .color-swatch.active {
            border: 2px solid #ffffff !important;
        }
        .text-color-swatch {
            border: 1px solid #ced4da !important;
            transition: all 0.15s ease-in-out;
        }
        .text-color-swatch.active {
            border: 2px solid var(--theme-primary, #F6A02A) !important;
        }
        
        html {
            font-size: calc(16px * var(--accessibility-font-scale)) !important;
        }
        body.accessibility-grayscale {
            filter: grayscale(100%) !important;
        }
        body.accessibility-highcontrast {
            background-color: #0F172A !important; /* Deep Slate Background */
            color: #F8FAFC !important; /* White-Gray text */
            
            p, span:not(.badge):not(.fa):not(.fab):not(.fas), li, label, td, th, 
            h1, h2, h3, h4, h5, h6 {
                color: #F8FAFC !important;
            }
            
            a {
                color: #38BDF8 !important; /* High contrast cyan/light-blue for readable links */
                text-decoration: underline !important;
            }
            a:hover {
                color: #F6A02A !important;
                text-decoration: none !important;
            }
            
            .card, .navbar, footer, header, #page-content, .authincation-content, 
            #region-main, .drawer {
                background-color: #1E293B !important; /* Lighter Slate Gray */
                color: #F8FAFC !important;
                border: 1px solid #475569 !important; /* High contrast border */
            }
            
            .navbar.fixed-top .nav-link,
            .navbar.fixed-top .nav-link *,
            .navbar.fixed-top i,
            .navbar.fixed-top .icon {
                color: #F8FAFC !important;
            }
            
            .btn, button, input[type="submit"], input[type="button"] {
                background-color: #F6A02A !important; /* Brand yellow/orange */
                color: #0F172A !important; /* Deep dark text */
                border: 2px solid #FBAF29 !important;
                font-weight: bold !important;
            }
            .btn:hover, button:hover, input[type="submit"]:hover {
                background-color: #DB891B !important;
                border-color: #DB891B !important;
                color: #ffffff !important;
            }
            
            .btn-secondary, .btn-outline-secondary, .btn-outline-primary {
                background-color: transparent !important;
                color: #38BDF8 !important;
                border: 2px solid #38BDF8 !important;
            }
            .btn-secondary:hover, .btn-outline-secondary:hover, .btn-outline-primary:hover {
                background-color: #38BDF8 !important;
                color: #0F172A !important;
            }
            
            input[type="text"], input[type="password"], input[type="email"], 
            select, textarea, .form-control {
                background-color: #0F172A !important;
                color: #F8FAFC !important;
                border: 2px solid #64748B !important;
            }
            input:focus, select:focus, textarea:focus {
                border-color: #F6A02A !important;
                box-shadow: 0 0 0 0.25rem rgba(246, 160, 42, 0.25) !important;
            }
        }
        /* Shrink login page titles */
        .auth-form h1.h2 {
            font-size: 1.35rem !important;
            margin-bottom: 0.25rem !important;
        }
        .auth-form p.text-muted {
            font-size: 0.85rem !important;
            margin-bottom: 1rem !important;
        }
        
        /* Sequential Policy Acceptance Page (view.php) Premium Styling */
        .path-admin-tool-policy .policy-document,
        .path-admin-tool-policy .policy-content,
        .path-admin-tool-policy .policy-text,
        .path-admin-tool-policy .policy-body {
            max-height: 380px !important;
            overflow-y: auto !important;
            border: 1px solid #e2e8f0 !important;
            padding: 1.5rem !important;
            border-radius: 0.75rem !important;
            background-color: #f8f9fa !important;
            margin-bottom: 1.5rem !important;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06) !important;
        }
        .path-admin-tool-policy h3, 
        .path-admin-tool-policy h2 {
            color: #F6A02A !important;
            font-weight: 700 !important;
            font-size: 1.4rem !important;
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }
        .path-admin-tool-policy button, 
        .path-admin-tool-policy input[type="submit"],
        .path-admin-tool-policy .btn-primary,
        .path-admin-tool-policy #id_submitbutton,
        .path-admin-tool-policy a.btn-primary,
        .path-admin-tool-policy .policy-buttons button,
        .path-admin-tool-policy a[href*="policy/agree.php"] {
            background-color: #F6A02A !important;
            border-color: #F6A02A !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            text-transform: uppercase !important; /* Avoid lowercase! */
            letter-spacing: 0.5px !important;
            border-radius: 0.75rem !important;
            padding: 0.6rem 2.5rem !important;
            font-size: 0.9rem !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: 0 4px 6px -1px rgba(246, 160, 42, 0.2) !important;
        }
        .path-admin-tool-policy button:hover, 
        .path-admin-tool-policy input[type="submit"]:hover,
        .path-admin-tool-policy .btn-primary:hover,
        .path-admin-tool-policy a.btn-primary:hover {
            background-color: #db891b !important;
            border-color: #db891b !important;
            color: #ffffff !important;
        }
        /* Site policy consent banner styles */
        .sitepolicyconfirm,
        .policiesagreement,
        .tool_policy_agreement,
        .moodle-policy-consent-banner,
        .policiesagreement-consent {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border-top: 4px solid #F6A02A !important;
            padding: 1.5rem 2rem !important;
            box-shadow: 0 -10px 25px -5px rgba(0, 0, 0, 0.15) !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            line-height: 1.6 !important;
        }
        .policiesagreement a,
        .sitepolicyconfirm a,
        .tool_policy_agreement a {
            color: #F6A02A !important;
            font-weight: 700 !important;
            text-decoration: underline !important;
        }
        .policiesagreement a[href*="agree.php"],
        .sitepolicyconfirm a[href*="agree.php"],
        .policiesagreement-consent a.btn,
        .policiesagreement a.btn {
            background-color: #F6A02A !important;
            border-color: #F6A02A !important;
            color: #ffffff !important;
            padding: 0.6rem 2.5rem !important;
            border-radius: 0.75rem !important;
            text-transform: uppercase !important;
            font-weight: 700 !important;
            display: inline-block !important;
            text-decoration: none !important;
            margin-left: 15px !important;
            box-shadow: 0 4px 6px -1px rgba(246, 160, 42, 0.2) !important;
            transition: all 0.2s ease-in-out !important;
        }
        .policiesagreement a[href*="agree.php"]:hover,
        .sitepolicyconfirm a[href*="agree.php"]:hover {
            background-color: #db891b !important;
            border-color: #db891b !important;
            color: #ffffff !important;
        }
        /* Style any generic links inside policy agreement that act as Continue buttons */
        .policiesagreement .policy-agree-link,
        .policiesagreement a:last-child {
            background-color: #F6A02A !important;
            color: #ffffff !important;
            padding: 0.5rem 1.5rem !important;
            border-radius: 0.5rem !important;
            text-transform: uppercase !important;
            font-weight: 700 !important;
            display: inline-block !important;
            margin-top: 5px !important;
            text-decoration: none !important;
            box-shadow: 0 2px 4px rgba(246, 160, 42, 0.2) !important;
        }
    ';

    // Import Uena SCSS Component Files
    $scss_path = __DIR__ . '/scss/uena/';

    $files_to_import = [
        '_mixin.scss',
        'ui/_ui-alert.scss',
        'ui/_ui-badge.scss',
        'ui/_ui-dropdown.scss',
        'ui/_ui-modal.scss',
        'tables/_table-basic.scss',
        'tables/_table-datatable.scss',
        '_dark-mode.scss'
    ];

    foreach ($files_to_import as $file) {
        $full_path = $scss_path . $file;
        if (file_exists($full_path)) {
            $scss .= "\n" . file_get_contents($full_path) . "\n";
        }
    }

    return $scss;
}
