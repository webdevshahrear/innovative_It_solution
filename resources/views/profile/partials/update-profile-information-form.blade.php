<section>
    <header class="mb-4">
        <p class="text-v2-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-4">
            <label class="v2-form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="v2-form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if($errors->get('name'))
                <div class="mt-2 text-danger small">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label class="v2-form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="v2-form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if($errors->get('email'))
                <div class="mt-2 text-danger small">{{ $errors->first('email') }}</div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-lg bg-warning-subtle text-warning border border-warning-subtle">
                    <p class="small mb-2">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="btn btn-sm btn-outline-warning">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium small text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            <button type="submit" class="btn-v2-primary py-2 px-4">{{ __('Update Profile') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-v2-success small mb-0"
                ><i class="fas fa-check-circle me-1"></i> {{ __('Identity Synchronized.') }}</p>
            @endif
        </div>
    </form>
</section>
