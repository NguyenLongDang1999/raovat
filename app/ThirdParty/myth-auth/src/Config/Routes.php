<?php

/*
 * Myth:Auth routes file.
 */
$routes->group('', ['namespace' => 'Myth\Auth\Controllers'], function ($routes) {
    // Update User
    $routes->post('user-update', 'AuthController::update', ['as' => 'user.user.update']);
    $routes->post('change-password', 'AuthController::changePassword', ['as' => 'user.user.changePassword']);
    $routes->post('postChangeEmail', 'AuthController::postChangeEmail', ['as' => 'user.auth.changeEmail']);
    $routes->get('confirm-email', 'AuthController::confirmNewEmail');

    // Login/out
    $routes->get('dang-nhap', 'AuthController::login', ['as' => 'login']);
    $routes->post('dang-nhap', 'AuthController::attemptLogin');
    $routes->get('dang-xuat', 'AuthController::logout', ['as' => 'logout']);

    // Social
    $routes->get('social-login', 'AuthController::socialLogin', ['as' => 'user.user.socialLogin']);

    // Registration
    $routes->get('dang-ky', 'AuthController::register', ['as' => 'register']);
    $routes->post('dang-ky', 'AuthController::attemptRegister');
    $routes->post('checkEmail', 'AuthController::checkEmail', ['as' => 'user.auth.checkEmail']);

    // Activation
    $routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/Resets
    $routes->get('quen-mat-khau', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('quen-mat-khau', 'AuthController::attemptForgot');
    $routes->get('dat-lai-mat-khau', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('dat-lai-mat-khau', 'AuthController::attemptReset');
});
