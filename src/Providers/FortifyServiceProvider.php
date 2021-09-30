<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\Fortify\Actions\AuthenticateUser;
use ARKEcosystem\Foundation\Fortify\Actions\CreateNewUser;
use ARKEcosystem\Foundation\Fortify\Actions\ResetUserPassword;
use ARKEcosystem\Foundation\Fortify\Actions\UpdateUserPassword;
use ARKEcosystem\Foundation\Fortify\Actions\UpdateUserProfileInformation;
use ARKEcosystem\Foundation\Fortify\Components\DeleteUserForm;
use ARKEcosystem\Foundation\Fortify\Components\ExportUserData;
use ARKEcosystem\Foundation\Fortify\Components\FooterEmailSubscriptionForm;
use ARKEcosystem\Foundation\Fortify\Components\LogoutOtherBrowserSessionsForm;
use ARKEcosystem\Foundation\Fortify\Components\RegisterForm;
use ARKEcosystem\Foundation\Fortify\Components\ResetPasswordForm;
use ARKEcosystem\Foundation\Fortify\Components\TwoFactorAuthenticationForm;
use ARKEcosystem\Foundation\Fortify\Components\UpdatePasswordForm;
use ARKEcosystem\Foundation\Fortify\Components\UpdateProfileInformationForm;
use ARKEcosystem\Foundation\Fortify\Components\UpdateProfilePhotoForm;
use ARKEcosystem\Foundation\Fortify\Components\UpdateTimezoneForm;
use ARKEcosystem\Foundation\Fortify\Components\VerifyEmail;
use ARKEcosystem\Foundation\Fortify\Http\Controllers\TwoFactorAuthenticatedPasswordResetController;
use ARKEcosystem\Foundation\Fortify\Http\Responses\FailedPasswordResetLinkRequestResponse as FortifyFailedPasswordResetLinkRequestResponse;
use ARKEcosystem\Foundation\Fortify\Http\Responses\SuccessfulPasswordResetLinkRequestResponse as FortifySuccessfulPasswordResetLinkRequestResponse;
use ARKEcosystem\Foundation\Fortify\Responses\FailedTwoFactorLoginResponse;
use ARKEcosystem\Foundation\Fortify\Responses\RegisterResponse;
use ARKEcosystem\Foundation\Fortify\Responses\TwoFactorLoginResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse as FailedTwoFactorLoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResponseBindings();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLoaders();

        $this->registerPublishers();

        $this->registerLivewireComponents();

        $this->registerActions();

        $this->registerViews();

        $this->registerAuthentication();

        $this->registerRoutes();
    }

    /**
     * Register the loaders.
     *
     * @return void
     */
    public function registerLoaders(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'fortify');
    }

    /**
     * Register the publishers.
     *
     * @return void
     */
    public function registerPublishers(): void
    {
        $this->publishes([
            __DIR__.'/../../config/fortify.php' => config_path('fortify.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/newsletter.php',
            'newsletter'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../../config/fortify.php',
            'fortify'
        );

        $this->publishes([
            __DIR__.'/../resources/views/auth'          => resource_path('views/auth'),
            __DIR__.'/../resources/views/components'    => resource_path('views/components'),
            __DIR__.'/../resources/views/profile'       => resource_path('views/profile'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../resources/images' => resource_path('images'),
        ], 'images');
    }

    /**
     * Register the Livewire components.
     *
     * @return void
     */
    public function registerLivewireComponents(): void
    {
        Livewire::component('profile.delete-user-form', DeleteUserForm::class);
        Livewire::component('profile.export-user-data', ExportUserData::class);
        Livewire::component('profile.logout-other-browser-sessions-form', LogoutOtherBrowserSessionsForm::class);
        Livewire::component('profile.two-factor-authentication-form', TwoFactorAuthenticationForm::class);
        Livewire::component('profile.update-password-form', UpdatePasswordForm::class);
        Livewire::component('profile.update-profile-information-form', UpdateProfileInformationForm::class);
        Livewire::component('profile.update-profile-photo-form', UpdateProfilePhotoForm::class);
        Livewire::component('profile.update-timezone-form', UpdateTimezoneForm::class);
        Livewire::component('auth.register-form', RegisterForm::class);
        Livewire::component('auth.reset-password-form', ResetPasswordForm::class);
        Livewire::component('newsletter.footer-subscription-form', FooterEmailSubscriptionForm::class);
        Livewire::component('auth.verify-email', VerifyEmail::class);
    }

    /**
     * Register the actions.
     *
     * @return void
     */
    public function registerActions(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }

    /**
     * Register the views.
     *
     * @return void
     */
    private function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ark-fortify');

        Fortify::loginView(function () {
            return view('ark-fortify::auth.login');
        });

        Fortify::twoFactorChallengeView(function ($request) {
            $request->session()->put([
                'login.idFailure' => $request->session()->get('login.id'),
            ]);

            return view('ark-fortify::auth.two-factor-challenge');
        });

        Fortify::registerView(function ($request) {
            return view('ark-fortify::auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('ark-fortify::auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            $user = Models::user()::where('email', $request->get('email'))->firstOrFail();

            if ($user->two_factor_secret) {
                return redirect()->route('two-factor.reset-password', ['token' => $request->token, 'email' => $user->email]);
            }

            return view('ark-fortify::auth.reset-password', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return view('ark-fortify::auth.verify-email');
        });

        Fortify::confirmPasswordView(function () {
            return view('ark-fortify::auth.confirm-password');
        });
    }

    /**
     * Register the authentication callbacks.
     *
     * @return void
     */
    private function registerAuthentication(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            return (new AuthenticateUser($request))->handle();
        });
    }

    /**
     * Register the response bindings.
     *
     * @return void
     */
    private function registerResponseBindings()
    {
        $this->app->singleton(
            RegisterResponseContract::class,
            RegisterResponse::class
        );

        $this->app->singleton(
            FailedTwoFactorLoginResponseContract::class,
            FailedTwoFactorLoginResponse::class
        );

        $this->app->singleton(
            TwoFactorLoginResponseContract::class,
            TwoFactorLoginResponse::class
        );

        $this->app->singleton(
            FailedPasswordResetLinkRequestResponse::class,
            FortifyFailedPasswordResetLinkRequestResponse::class
        );

        $this->app->singleton(
            SuccessfulPasswordResetLinkRequestResponse::class,
            FortifySuccessfulPasswordResetLinkRequestResponse::class
        );
    }

    public function registerRoutes(): void
    {
        Route::middleware('web')->group(function () {
            Route::view(config('fortify.routes.feedback_thank_you'), 'ark-fortify::profile.feedback-thank-you')
                ->name('profile.feedback.thank-you')
                ->middleware('signed');

            Route::get(config('fortify.routes.two_factor_reset_password'), [TwoFactorAuthenticatedPasswordResetController::class, 'create'])
                ->name('two-factor.reset-password')
                ->middleware('guest');

            Route::post(config('fortify.routes.two_factor_reset_password'), [TwoFactorAuthenticatedPasswordResetController::class, 'store'])
                ->name('two-factor.reset-password-store')
                ->middleware('guest');
        });
    }
}
