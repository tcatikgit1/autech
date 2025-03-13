<div id="content-change-password" class="bottom-section tab-pane fade" role="tabpanel" aria-labelledby="tab-change-password">

    <div class="d-flex justify-content-between align-items-center">
        <h5>Cambiar contraseña</h5>
    </div>

    <form id="change-password-form" novalidate>
        @csrf

        {{-- email --}}
        <input type="hidden" name="email" value="{{@$user_info['user']['email']}}">

        {{-- old password --}}
        <div class="mb-3">
            <label class="form-label">Contraseña actual<span class="text-danger">*</span></label>
            <input 
                placeholder="Contraseña actual"
                type="password" 
                class="form-control"
                id="old_password"
                name="old_password"
                required
            >
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        {{-- nueva contraseña --}}
        <div class="mb-3 form-password-toggle">
            <label for="new_password" class="form-label">Nueva contraseña<span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
                <input
                    type="password"
                    name="new_password"
                    class="form-control"
                    id="new_password"
                    placeholder="**********"
                    required
                    aria-describedby="password"
                >
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        {{-- nueva contraseña confirmacion --}}
        <div class="mb-3 form-password-toggle">
            <label for="new_password_confirmation" class="form-label">Confirmar contraseña<span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
                <input 
                    type="password" 
                    name="new_password_confirmation" 
                    class="form-control" 
                    id="new_password_confirmation"
                    placeholder="**********"
                    required
                >
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        <div class="mt-4">
            <button type="submit" id="submit-change-password" class="btn btn-primary btn-lg">Cambiar</button>
        </div>
    </form>
</div>
