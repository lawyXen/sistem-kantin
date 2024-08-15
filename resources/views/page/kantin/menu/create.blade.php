@extends('template.index')

@section('title')
<title>{{ isset($menu) ? 'Edit Menu' : 'Buat Menu Baru' }}</title>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>{{ isset($menu) ? 'Edit Menu Kantin' : 'Tambah Menu Kantin' }}</strong></h1>

    <!-- Form tambah/edit menu -->
    <form id="formMenu">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal"
                    value="{{ isset($menu) ? $menu->created_at->format('Y-m-d') : '' }}" required>
            </div>
        </div>

        <!-- Wizard Navigation -->
        <div class="wizard">
            <div class="wizard-step">
                <div class="mb-3">
                    <label for="menu_pagi_makanan" class="form-label">Menu Makan Pagi</label>
                    <textarea class="form-control" id="menu_pagi_makanan" name="menu_pagi_makanan" rows="10"
                        required>{{ isset($menu) ? $menu->menu_sarapan : '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status_pagi" class="form-label">Status Makan Pagi</label>
                    <select class="form-control" id="status_pagi" name="status_pagi" required>
                        <option value="Makan Seperti Biasanya" {{ isset($menu) && $menu->status_sarapan == 'Makan
                            Seperti Biasanya' ?
                            'selected' : '' }}>Makan Seperti Biasanya</option>
                        <option value="Makan Prasmanan" {{ isset($menu) && $menu->status_sarapan == 'Makan Prasmanan' ?
                            'selected' : '' }}>Makan Prasmanan</option>
                        <option value="Tidak Ada Makan" {{ isset($menu) && $menu->status_sarapan == 'Tidak Ada Makan' ?
                            'selected' : '' }}>Tidak Ada Makan</option>
                    </select>
                </div>
                <button type="button" class="btn btn-secondary"
                    onclick="cancelForm('{{ route('menu.index') }}')">Batal</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
            </div>
            <div class="wizard-step d-none">
                <div class="mb-3">
                    <label for="menu_siang_makanan" class="form-label">Menu Makan Siang</label>
                    <textarea class="form-control" id="menu_siang_makanan" name="menu_siang_makanan" rows="10"
                        required>{{ isset($menu) ? $menu->menu_siang : '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status_siang" class="form-label">Status Makan Siang</label>
                    <select class="form-control" id="status_siang" name="status_siang" required>
                        <option value="Makan Seperti Biasanya" {{ isset($menu) && $menu->status_siang == 'Makan Seperti
                            Biasanya' ? 'selected'
                            : '' }}>Makan Seperti Biasanya</option>
                        <option value="Makan Prasmanan" {{ isset($menu) && $menu->status_siang == 'Makan Prasmanan' ?
                            'selected'
                            : '' }}>Makan Prasmanan</option>
                        <option value="Tidak Ada Makan" {{ isset($menu) && $menu->status_siang == 'Tidak Ada Makan' ?
                            'selected'
                            : '' }}>Tidak Ada Makan</option>
                    </select>
                </div>
                <button type="button" class="btn btn-secondary"
                    onclick="cancelForm('{{ route('menu.index') }}')">Batal</button>
                <button type="button" class="btn btn-secondary" onclick="prevStep(0)">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next</button>
            </div>
            <div class="wizard-step d-none">
                <div class="mb-3">
                    <label for="menu_malam_makanan" class="form-label">Menu Makan Malam</label>
                    <textarea class="form-control" id="menu_malam_makanan" name="menu_malam_makanan" rows="10"
                        required>{{ isset($menu) ? $menu->menu_malam : '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status_malam" class="form-label">Status Makan Malam</label>
                    <select class="form-control" id="status_malam" name="status_malam" required>
                        <option value="Makan Seperti Biasanya" {{ isset($menu) && $menu->status_malam == 'Makan Seperti
                            Biasanya' ? 'selected'
                            : '' }}>Makan Seperti Biasanya</option>
                        <option value="Makan Prasmanan" {{ isset($menu) && $menu->status_malam == 'Makan Prasmanan' ?
                            'selected'
                            : '' }}>Makan Prasmanan</option>
                        <option value="Tidak Ada Makan" {{ isset($menu) && $menu->status_malam == 'Tidak Ada Makan' ?
                            'selected'
                            : '' }}>Tidak Ada Makan</option>
                    </select>
                </div>
                <button type="button" class="btn btn-secondary"
                    onclick="cancelForm('{{ route('menu.index') }}')">Batal</button>
                <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Previous</button>
                <button type="submit" class="btn btn-primary" id="submitButton" onclick="save_data('#formMenu', '#submitButton', 
                    '{{ isset($menu) ? route('menu.update', $menu->id) : route('menu.store') }}', 
                    '{{ isset($menu) ? 'PUT' : 'POST' }}');">{{
                    isset($menu) ? 'Simpan Perubahan' : 'Simpan' }}</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    var currentStep = 0;
    function showStep(step) {
        var steps = document.querySelectorAll('.wizard-step');
        steps.forEach(function(stepElement, index) {
            stepElement.classList.toggle('d-none', index !== step);
        });
    }

    function nextStep(step) {
        currentStep = step;
        showStep(step);
    }

    function prevStep(step) {
        currentStep = step;
        showStep(step);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var pagiTextarea = document.getElementById('menu_pagi_makanan');
        var siangTextarea = document.getElementById('menu_siang_makanan');
        var malamTextarea = document.getElementById('menu_malam_makanan');

        sceditor.create(pagiTextarea, {
            format: 'xhtml',
            style: '{{ asset('editor/minified/themes/content/default.min.css') }}'
        });

        sceditor.create(siangTextarea, {
            format: 'xhtml',
            style: '{{ asset('editor/minified/themes/content/default.min.css') }}'
        });

        sceditor.create(malamTextarea, {
            format: 'xhtml',
            style: '{{ asset('editor/minified/themes/content/default.min.css') }}'
        });

        showStep(currentStep);
    });
</script>
@endsection