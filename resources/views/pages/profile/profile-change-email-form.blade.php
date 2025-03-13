<div id="content-change-email" class="bottom-section tab-pane fade" role="tabpanel" aria-labelledby="tab-change-email">

    <div class="d-flex justify-content-between align-items-center">
        <h5>Cambiar email</h5>
    </div>

    <form id="change-email-form" novalidate>
        @csrf

        {{-- email antiguo --}}
        <div class="mb-3">
            <label class="form-label">Email actual<span class="text-danger">*</span></label>
            <input 
                type="email" 
                class="form-control"
                value="{{@$user_info['user']['email']}}" 
                id="old_email"
                disabled
            >
            <input type="hidden" name="old_email" value="{{@$user_info['user']['email']}}">
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        {{-- nuevo email --}}
        <div class="mb-3">
            <label for="new_email" class="form-label">Nuevo email<span class="text-danger">*</span></label>
            <input 
                type="email" 
                name="new_email" 
                class="form-control" 
                id="new_email"
                placeholder="example@domain.com"
                required
            >
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        {{-- nuevo email confirmacion --}}
        <div class="mb-3">
            <label for="new_email_confirmation" class="form-label">Confirmar email<span class="text-danger">*</span></label>
            <input 
                type="email" 
                name="new_email_confirmation" 
                class="form-control" 
                id="new_email_confirmation"
                placeholder="example@domain.com"
                required
            >
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        <div class="mt-4">
            <button type="submit" id="submit-change-email" class="btn btn-primary btn-lg">Cambiar</button>
        </div>
    </form>
</div>
