<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
 | --------------------------------------------------------------------------
 | Status
 | --------------------------------------------------------------------------
 */
defined('STATUS_ACTIVE')            || define('STATUS_ACTIVE', 1);
defined('STATUS_INACTIVE')          || define('STATUS_INACTIVE', 0);

/*
 | --------------------------------------------------------------------------
 | Status Post
 | --------------------------------------------------------------------------
 */
defined('STATUS_POST_READY')        || define('STATUS_POST_READY', 1);
defined('STATUS_POST_ACTIVE')       || define('STATUS_POST_ACTIVE', 0);
defined('STATUS_POST_INACTIVE')     || define('STATUS_POST_INACTIVE', 2);
defined('STATUS_POST_HIDDEN')       || define('STATUS_POST_HIDDEN', 3);

/*
 | --------------------------------------------------------------------------
 | Featured VIP
 | --------------------------------------------------------------------------
 */
defined('FEATURED_ACTIVE')          || define('FEATURED_ACTIVE', 1);
defined('FEATURED_INACTIVE')        || define('FEATURED_INACTIVE', 0);

/*
 | --------------------------------------------------------------------------
 | Path URL Image
 | --------------------------------------------------------------------------
 */
defined('PATH_CATEGORY_IMAGE')      || define('PATH_CATEGORY_IMAGE', 'uploads/category/');
defined('PATH_BANNER_IMAGE')        || define('PATH_BANNER_IMAGE', 'uploads/banner/');
defined('PATH_USER_IMAGE')          || define('PATH_USER_IMAGE', 'uploads/user/');
defined('PATH_POST_IMAGE')          || define('PATH_POST_IMAGE', 'uploads/post/');
defined('PATH_POST_SMALL_IMAGE')    || define('PATH_POST_SMALL_IMAGE', 'uploads/post/small/');
defined('PATH_POST_MEDIUM_IMAGE')   || define('PATH_POST_MEDIUM_IMAGE', 'uploads/post/medium/');
defined('PATH_DEFAULT_AVATAR')      || define('PATH_DEFAULT_AVATAR', 'app-assets/images/portrait/small/avatar-s.png');
defined('PATH_LAZY_LOADING')        || define('PATH_LAZY_LOADING', 'app-assets/images/default/loader.gif');
defined('PATH_POST_IMAGE_DEFAULT')  || define('PATH_POST_IMAGE_DEFAULT', 'app-assets/images/default/no-image.jpg');

/*
 | --------------------------------------------------------------------------
 | Banner
 | --------------------------------------------------------------------------
 */
defined('BANNER_TOP')               || define('BANNER_TOP', '0');
defined('BANNER_MIDDLE')            || define('BANNER_MIDDLE', '1');
defined('BANNER_BOTTOM')            || define('BANNER_BOTTOM', '2');

/*
 | --------------------------------------------------------------------------
 | Group
 | --------------------------------------------------------------------------
 */
defined('ADMINISTRATOR')            || define('ADMINISTRATOR', '1');
defined('USER')                     || define('USER', '2');

/*
 | --------------------------------------------------------------------------
 | Gender
 | --------------------------------------------------------------------------
 */
defined('GENDER_FEMALE')            || define('GENDER_FEMALE', 0);
defined('GENDER_MALE')              || define('GENDER_MALE', 1);