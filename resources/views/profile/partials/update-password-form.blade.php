<section>
    <header class="mb-4">
        <p class="text-v2-muted small">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-4">
            <label class="v2-form-label">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="v2-form-control" autocomplete="current-password" />
            @if($errors->updatePassword->get('current_password'))
                <div class="mt-2 text-danger small">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label class="v2-form-label">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="v2-form-control" autocomplete="new-password" />
            @if($errors->updatePassword->get('password'))
                <div class="mt-2 text-danger small">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label class="v2-form-label">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="v2-form-control" autocomplete="new-password" />
            @if($errors->updatePassword->get('password_confirmation'))
                <div class="mt-2 text-danger small">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            <button type="submit" class="btn-v2-primary py-2 px-4">{{ __('Update Credentials') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-v2-success small mb-0"
                ><i class="fas fa-shield-alt me-1"></i> {{ __('Security Patch Applied.') }}</p>
            @endif
        </div>
    </form>
</section>
