<section>
    <header class="mb-4">
        <p class="text-v2-muted small">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        class="btn btn-outline-danger py-2 px-4 shadow-sm"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    ><i class="fas fa-user-slash me-2"></i> {{ __('Decommission Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4 rounded-4" style="background: #1a1a1a; border: 1px solid rgba(220, 53, 69, 0.2);">
            @csrf
            @method('delete')

            <h5 class="fw-bold text-v2-white mb-3">
                {{ __('Confirm Decommissioning') }}
            </h5>

            <p class="small text-v2-muted mb-4">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mb-4">
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="v2-form-control"
                    placeholder="{{ __('Verification Password') }}"
                />
                @if($errors->userDeletion->get('password'))
                    <div class="mt-2 text-danger small">{{ $errors->userDeletion->first('password') }}</div>
                @endif
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top border-v2">
                <button type="button" class="btn btn-outline-secondary px-4 py-2" x-on:click="$dispatch('close')">
                    {{ __('Abort') }}
                </button>

                <button type="submit" class="btn btn-danger px-4 py-2 shadow-sm">
                    {{ __('Confirm Deletion') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
