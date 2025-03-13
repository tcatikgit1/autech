<div class="modal fade" id="modal-form-advertisement" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple" role="document">
        <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="text-center mb-6">
                <h4 class="mb-2 modal-title">Crear anuncio</h4> {{-- Este texto cambia al editar un anuncio --}}
                <p class="modal-subtitle">Publica tu anuncio en cuestión de segundos</p> {{-- Este texto cambia al editar un anuncio --}}
              </div>
              <form id="advertisement-form" class="row g-6" novalidate enctype="multipart/form-data">
                @csrf

                <input type="hidden" id="anuncioId" name="anuncioId">

                {{-- tipo de anuncio --}}
                <input type="hidden" name="tipo_anuncio" value="{{ session()->get('user')['tipo'] == 'autonomo' ? 'demanda' : 'oferta' }}"> {{-- TODO: El tipo de anuncio cambiará en base al tipo de usuario o modo seleccionado --}}

                {{-- autonomo o cliente ID --}}
                <input type="hidden" id="{{ session()->get('user')['tipo'].'_id' }}" name="{{ session()->get('user')['tipo'].'_id' }}" value="{{ session()->get('user')['tipo'] == 'autonomo' ? session()->get('autonomo')['_id'] : session()->get('cliente')['_id'] }}">

                {{-- Titulo --}}
                <div class="col-12 col-md-6">
                  <label class="form-label" for="titulo">Título<span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    id="titulo" 
                    name="titulo" 
                    class="form-control" 
                    placeholder="Título"
                  />
                  <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Precio --}}
                <div class="col-12 col-md-6">
                  <label class="form-label" for="presupuesto">Precio/h<span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    id="presupuesto" 
                    name="presupuesto" 
                    class="form-control" 
                    placeholder="Precio/h"
                    required
                    max="10000"
                  />
                  <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Descripcion --}}
                <div class="col-12">
                  <label class="form-label" for="descripcion">Descripción<span class="text-danger">*</span></label>
                  <textarea 
                    rows="3"
                    id="descripcion" 
                    name="descripcion" 
                    class="form-control" 
                    placeholder="Descripción"
                    required
                  ></textarea >
                  <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Ubicación --}}
                <div class="col-12 col-md-6"> {{-- TODO: Hacer la ubicaion mediante la API de google --}}
                  <label class="form-label" for="ubicacion">Ubicación<span class="text-danger">Pendiente</span></label> 
                  <input type="text" id="ubicacion" name="ubicacion" class="form-control" placeholder="Madrid, España" value="" />
                </div>
                <input type="hidden" id="place_id_adv" name="place_id">
                <input type="hidden" id="place_lat_adv" name="place_lat">
                <input type="hidden" id="place_long_adv" name="place_long">
                <input type="hidden" id="place_name_adv" name="place_name">

                {{-- Estado --}}
                <div class="col-12 col-md-6">
                  <label class="form-label" for="is_visible">Estado</label>
                  <select id="is_visible" name="is_visible" class="select2 form-select">
                    <option selected disabled>Seleccione una opcion</option>
                    <option value="true">Visible</option>
                    <option value="false">No visible</option>
                  </select>
                  <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Profesión --}}
                <div class="col-12 col-md-6">
                    <label class="form-label" for="select-profesion-adv">Sector<span class="text-danger">*</span></label>
                    <select id="select-profesion-adv" name="profesion_id" class="select2 form-select populate-profesion" data-target="#select-habilidades-adv" required>
                        <option selected disabled>Seleccione una opción</option>
                    </select>
                    <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Habilidades de profesion --}}
                <div class="col-12 col-md-6">
                    <label class="form-label" for="select-habilidades-adv">Habilidades del sector</label>
                    <div class="select2-info">
                        <select id="select-habilidades-adv" name="habilidades[]" class="select2 form-select populate-habilidades" multiple data-parent-select-profesion-id="select-profesion-adv">
                          {{-- Las opciones se cargan mediante AJAX --}}
                        </select>
                    </div>
                </div>

                {{-- Habilidades generales --}}
                <div class="col-12 col-md-6">
                    <label class="form-label" for="select-habilidades-generales-adv">Habilidades generales</label>
                    <div class="select2-info">
                        <select id="select-habilidades-generales-adv" name="habilidades_generales[]" class="select2 form-select populate-habilidades-generales" multiple>
                          {{-- Las opciones se cargan mediante AJAX --}}
                        </select>
                    </div>
                </div>

                {{-- <div class="dz-message needsclick">
                  Drop files here or click to upload
                  <span class="note needsclick">(This is just a demo dropzone. Selected files are <span class="fw-medium">not</span> actually uploaded.)</span>
                </div>
                <div class="fallback">
                  <input name="file" type="file" />
                </div> --}}

                <div class="mb-3"> {{-- TODO: Pendiente, no funciona al enviar hacia la API --}}
                    <label for="images" class="form-label">Imágenes</label>
                    <div id="dropzone-adv" class="dropzone border border-dashed p-3" style="min-height: 150px;">
                        <div class="dz-message text-center text-muted">
                            Arrastra las imágenes aquí o haz clic para subir
                        </div>
                    </div>
                    <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Imagenes antiguas al editar --}}
                <input type="hidden" id="old-images-input" name="oldImages">

                {{-- Orden de las imagenes --}}
                <input type="hidden" id="file-order-input" name="fileOrder">
                
                <div class="col-12 text-center d-flex justify-content-start gap-2">
                  <button type="submit" class="btn btn-primary">Guardar anuncio</button>
                  <button type="button" class="btn btn-secondary renewal-btn d-none">Renovar anuncio <i class="ms-1 ti ti-help" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Renovar el anuncio hará que aparezca más arriba en el listado" data-bs-original-title="Renovar el anuncio hará que aparezca más arriba en el listado"></i></button>
                  <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
              </form>
            </div>
          </div>
    </div>
  </div>