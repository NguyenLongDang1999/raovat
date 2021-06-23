<?php

namespace Myth\Auth\Controllers;

use Config\Email;
use CodeIgniter\Controller;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use Hybridauth\Hybridauth;
use Hybridauth\Storage\Session;

class AuthController extends Controller
{
	protected $auth;
	/**
	 * @var Auth
	 */
	protected $config;

	/**
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	public function __construct()
	{
		// Most services in this controller require
		// the session to be started - so fire it up!
		$this->session = service('session');
		helper(['form', 'html', 'auth', 'all', 'text']);
		$this->config = config('Auth');
		$this->auth = service('authentication');
	}

	//--------------------------------------------------------------------
	// Login/out
	//--------------------------------------------------------------------

	/**
	 * Displays the login form, or redirects
	 * the user to their destination/home if
	 * they are already logged in.
	 */
	public function login()
	{
		// No need to show a login form if the user
		// is already logged in.
		if ($this->auth->check()) {
			return redirect()->route('user.home.index');
		}

		return $this->_render($this->config->views['login'], ['config' => $this->config]);
	}

	/**
	 * Attempts to verify the user's credentials
	 * through a POST request.
	 */
	public function attemptLogin()
	{
		$login = $this->request->getPost('login');
		$password = $this->request->getPost('password');
		$remember = (bool) $this->request->getPost('remember');

		// Determine credential type
		$type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		// Try to log them in...
		if (!$this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
			return redirect()->back()->withInput()->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
		}

		// Is the user being forced to reset their password?
		if ($this->auth->user()->force_pass_reset === true) {
			return redirect()->to(route_to('reset-password') . '?token=' . $this->auth->user()->reset_hash)->withCookies();
		}

		return redirect()->route('user.user.myProfile')->withCookies()->with('message', lang('Auth.loginSuccess'));
	}

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		if ($this->auth->check()) {
			$this->auth->logout();
		}

		return redirect()->to(site_url('dang-nhap'));
	}

	//--------------------------------------------------------------------
	// Register
	//--------------------------------------------------------------------

	/**
	 * Displays the user registration page.
	 */
	public function register()
	{
		// check if already logged in.
		if ($this->auth->check()) {
			return redirect()->route('user.home.index');
		}

		// Check if registration is allowed
		if (!$this->config->allowRegistration) {
			return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
		}

		return $this->_render($this->config->views['register'], ['config' => $this->config]);
	}

	/**
	 * Attempt to register a new user.
	 */
	public function attemptRegister()
	{
		// Check if registration is allowed
		if (!$this->config->allowRegistration) {
			return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
		}

		$users = model(UserModel::class);

		// Save the user
		$allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
		$user = new User($this->request->getPost($allowedPostFields));

		$this->config->requireActivation !== false ? $user->generateActivateHash() : $user->activate();

		// Ensure default group gets assigned if set
		if (!empty($this->config->defaultUserGroup)) {
			$users = $users->withGroup($this->config->defaultUserGroup);
		}

		if (!$users->save($user)) {
			return redirect()->back()->withInput()->with('errors', $users->errors());
		}

		if ($this->config->requireActivation !== false) {
			$activator = service('activator');
			$sent = $activator->send($user);

			if (!$sent) {
				return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
			}

			// Success!
			return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
		}

		// Success!
		return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
	}

	//--------------------------------------------------------------------
	// Forgot Password
	//--------------------------------------------------------------------

	/**
	 * Displays the forgot password form.
	 */
	public function forgotPassword()
	{
		if (!$this->config->activeResetter) {
			return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
		}

		return $this->_render($this->config->views['forgot'], ['config' => $this->config]);
	}

	/**
	 * Attempts to find a user account with that password
	 * and send password reset instructions to them.
	 */
	public function attemptForgot()
	{
		if (!$this->config->activeResetter) {
			return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
		}

		$users = model(UserModel::class);

		$user = $users->where('email', $this->request->getPost('email'))->first();

		if (is_null($user)) {
			return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
		}

		// Save the reset hash /
		$user->generateResetHash();
		$users->save($user);

		$resetter = service('resetter');
		$sent = $resetter->send($user);

		if (!$sent) {
			return redirect()->back()->withInput()->with('error', $resetter->error() ?? lang('Auth.unknownError'));
		}

		return redirect()->route('reset-password')->with('message', lang('Auth.forgotEmailSent'));
	}

	/**
	 * Displays the Reset Password form.
	 */
	public function resetPassword()
	{
		if (!$this->config->activeResetter) {
			return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
		}

		$token = $this->request->getGet('token');

		return $this->_render($this->config->views['reset'], [
			'config' => $this->config,
			'token'  => $token,
		]);
	}

	/**
	 * Verifies the code with the email and saves the new password,
	 * if they all pass validation.
	 *
	 * @return mixed
	 */
	public function attemptReset()
	{
		if (!$this->config->activeResetter) {
			return redirect()->route('login')->with('error', lang('Auth.forgotDisabled'));
		}

		$users = model(UserModel::class);

		// First things first - log the reset attempt.
		$users->logResetAttempt(
			$this->request->getPost('email'),
			$this->request->getPost('token'),
			$this->request->getIPAddress(),
			(string) $this->request->getUserAgent()
		);

		$user = $users->where('email', $this->request->getPost('email'))
			->where('reset_hash', $this->request->getPost('token'))
			->first();

		if (is_null($user)) {
			return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
		}

		// Reset token still valid?
		if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
			return redirect()->back()->withInput()->with('error', lang('Auth.resetTokenExpired'));
		}

		// Success! Save the new password, and cleanup the reset hash.
		$user->password 		= $this->request->getPost('password');
		$user->reset_hash 		= null;
		$user->reset_at 		= date('Y-m-d H:i:s');
		$user->reset_expires    = null;
		$user->force_pass_reset = false;
		$users->save($user);

		return redirect()->route('login')->with('message', lang('Auth.resetSuccess'));
	}

	/**
	 * Activate account.
	 *
	 * @return mixed
	 */
	public function activateAccount()
	{
		$users = model(UserModel::class);

		// First things first - log the activation attempt.
		$users->logActivationAttempt(
			$this->request->getGet('token'),
			$this->request->getIPAddress(),
			(string) $this->request->getUserAgent()
		);

		$throttler = service('throttler');

		if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
			return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
		}

		$user = $users->where('activate_hash', $this->request->getGet('token'))
			->where('active', 0)
			->first();

		if (is_null($user)) {
			return redirect()->route('login')->with('error', lang('Auth.activationNoUser'));
		}

		$user->activate();

		$users->save($user);

		return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
	}

	/**
	 * Resend activation account.
	 *
	 * @return mixed
	 */
	public function resendActivateAccount()
	{
		if ($this->config->requireActivation === false) {
			return redirect()->route('login');
		}

		$throttler = service('throttler');

		if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false) {
			return service('response')->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
		}

		$login = urldecode($this->request->getGet('login'));
		$type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		$users = model(UserModel::class);

		$user = $users->where($type, $login)
			->where('active', 0)
			->first();

		if (is_null($user)) {
			return redirect()->route('login')->with('error', lang('Auth.activationNoUser'));
		}

		$activator = service('activator');
		$sent = $activator->send($user);

		if (!$sent) {
			return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
		}

		// Success!
		return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
	}

	protected function _render(string $view, array $data = [])
	{
		return view($view, $data);
	}

	public function checkEmail()
	{
		$users = model(UserModel::class);
		$email = $this->request->getPost('email');
		$result = $users->checkEmail($email);

		$valid = true;
		if ($result > 0) {
			$valid = false;
		} else {
			$valid = true;
		}

		return $this->response->setJSON([
			'valid' => $valid,
		]);
	}

	public function update()
	{
		$users = model(UserModel::class);

		$input = $this->request->getPost([
			'fullname',
			'job',
			'phone',
			'address',
			'birthdate',
			'gender',
			'checkImg'
		]);

		// Upload file
		$file = $this->request->getFile('avatar');
		if ($file) {
			if ($file->isValid() && !$file->hasMoved()) {
				$fileName = $file->getRandomName();
				$file->move(PATH_USER_IMAGE, $fileName);

				$parts = explode('.', $fileName);
				$parts[count($parts) - 1] = 'webp';
				$fileNameNew = implode('.', $parts);
				$data = [
					'resizeX' => '140',
					'resizeY' => '140',
					'ratio' => false,
					'masterDim' => 'auto'
				];
				imageManipulation(PATH_USER_IMAGE, $fileName, $fileNameNew, '', $data);
				deleteImage(PATH_USER_IMAGE, $fileName);
				if (!empty($input['checkImg'])) {
					deleteImage(PATH_USER_IMAGE, $input['checkImg']);
				}
				$input['avatar'] = $fileNameNew;
			}
		}

		$input['id'] = user_id();
		$users->save($input);
		return redirect()->route('user.user.index')->with("message", 'Cập nhật thông tin thành công!');
	}

	public function changePassword()
	{
		$config = config('Auth');
		$users = model(UserModel::class);

		$hashOptions = [
			'cost' => $config->hashCost
		];

		if (!password_verify(base64_encode(hash('sha384', $this->request->getPost('password'), true)), user()->password_hash)) {
			return redirect()->route('user.user.index')->with('error', "Mật khẩu cũ nhập không chính xác. Vui lòng thử lại!");
		}

		$new_password = password_hash(
			base64_encode(
				hash('sha384', $this->request->getPost('new_password'), true)
			),
			$config->hashAlgorithm,
			$hashOptions
		);
		$user['id'] = user_id();
		$user['password_hash'] = $new_password;
		$users->save($user);
		return redirect()->route('user.user.index')->with('message', "Mật khẩu đã được cập nhật thành công!");
	}

	public function postChangeEmail()
	{
		$users = model(UserModel::class);
		$user = $users->where('id', user_id())->first();
		if (!password_verify(base64_encode(hash('sha384', $this->request->getPost('password'), true)), $user->password_hash)) {
			return redirect()->route('user.user.index')->with('error', "Mật khẩu cũ nhập không chính xác. Vui lòng thử lại!");
		}

		if (is_null($user)) {
			return redirect()->route('user.user.index')->with('error', lang('Auth.activationNoUser'));
		}


		$user->new_email = $this->request->getPost('email');
		$user->activate_hash = bin2hex(random_bytes(16));
		$users->save($user);

		if ($this->config->requireActivation !== false) {
			$activator = service('activator');
			$user->email = $user->new_email;
			$sent = $activator->send($user);

			if (!$sent) {
				return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
			}

			// Success!
			return redirect()->route('user.user.index')->with('message', lang('Auth.activationSuccess'));
		}

		// Success!
		return redirect()->route('user.user.index')->with('message', lang('Auth.registerSuccess'));
	}

	public function confirmNewEmail()
	{
		$users = model(UserModel::class);

		$user = $users->where('activate_hash', $this->request->getGet('token'))
			->where('new_email !=', null)
			->first();

		if (is_null($user)) {
			return redirect()->route('user.user.index')->with('error', lang('Auth.activationNoUser'));
		}

		$user->email = $user->new_email;
		$user->new_email = NULL;
		$user->activate_hash = NULL;
		$users->save($user);
		return redirect()->route('user.user.index')->with('message', "Xác nhận thành công! Địa chỉ e-mail mới của bạn hiện đang hoạt động.");
	}

	public function socialLogin()
	{
		try {
			$hybridauth = new Hybridauth($this->getHybridConfig());
			$storage = new Session();

			if (isset($_GET['logout'])) {
				$hybridauth = new Hybridauth($this->getHybridConfig());
				$adapter = $hybridauth->getAdapter($_GET['logout']);
				$adapter->disconnect();
	
				session()->remove('getProvider');
				return redirect()->route('login');
			}

			if (isset($_GET['provider'])) {
				$storage->set('provider', $_GET['provider']);
			}

			if ($provider = $storage->get('provider')) {
				$hybridauth->authenticate($provider);
				$storage->set('provider', null);
			}

			$adapter = $hybridauth->getConnectedAdapters();
			if ($adapter) {
				foreach ($adapter as $key => $val) {
					$userProfile = $val->getUserProfile();
					session()->set('getProvider', $key);
				}
			}

			$getProvider = session()->get('getProvider');
			$config = config('Auth');
			$users = model(UserModel::class);

			$hashOptions = [
				'cost' => $config->hashCost
			];

			$checkUserExists = $users->getUserByProvider($getProvider, $userProfile->identifier);
			if ($checkUserExists == 0) {
				$hash_password = password_hash(
					base64_encode(
						hash('sha384', random_string('alnum', 10), true)
					),
					$config->hashAlgorithm,
					$hashOptions
				);

				$input = [
					'email' => $userProfile->email,
					'password_hash' => $hash_password,
					'fullname' => $userProfile->displayName,
					'provider_name' => $getProvider,
					'provider_uid' => $userProfile->identifier,
					'avatar' => $userProfile->photoURL,
					'active' => STATUS_ACTIVE
				];
				$users->save($input);
			}

			$user_id = $users->getUserDetailByProviderUid($getProvider, $userProfile->identifier);
			session()->set('logged_in', $user_id->id);
			return redirect()->route('user.user.myProfile');
		} catch (\Exception $e) {
			echo 'Oops, we ran into an issue! ' . $e->getMessage();
		}
	}

	private function getHybridConfig()
	{
		$config = [
			'callback' => base_url('social-login'),
			'providers' => [
				'Google' => [
					'enabled' => true,
					'keys' => [
						'id' => getenv('GOOGLE_ID'),
						'secret' => getenv('GOOGLE_SECRET')
					],
					'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
				],
				'Facebook' => [
					'enabled' => true,
					'keys' => [
						'id' => getenv('FACEBOOK_ID'),
						'secret' => getenv('FACEBOOK_SECRET')
					],
				],
			],
			'debug_mode' => false,
		];

		return $config;
	}
}
