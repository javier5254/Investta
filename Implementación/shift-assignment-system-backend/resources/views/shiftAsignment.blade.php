<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Asignación del turno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="turnoForm">
                        @csrf
                        <div class="mb-3">
                            <input placeholder="Escribe tu nombre" type="text" class="form-control w-full" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <input placeholder="Escribe tu documento de identidad" type="text" class="form-control w-full" id="dni" name="dni" required>
                        </div>
                        <div class="mb-3">
                            <select class="form-select w-full" id="servicio" name="servicio" required>
                                <option value="">Seleccione un servicio</option>
                                @foreach($services as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="button" onclick="submitForm()" class="btn btn-primary w-full bg-slate-400 rounded py-2">Registrar Turno</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function submitForm() {
        const formData = new FormData(document.getElementById('turnoForm'));

        // Primera solicitud POST a /api/patient
        fetch('/api/patient', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al crear el paciente');
                }
                return response.json();
            })
            .then(data => {
                // Obtener el ID del paciente creado
                const pacienteId = data.patient.id;

                // Obtener el documento del paciente y tomar los primeros 3 dígitos
                let pacienteDocumento = formData.get('dni');
                pacienteDocumento = pacienteDocumento.substring(0, 3);

                // Obtener el servicio seleccionado y sus iniciales
                const serviceId = document.getElementById('servicio').value;
                const serviceDescription = document.querySelector(`#servicio option[value="${serviceId}"]`).textContent;
                const serviceInitials = serviceDescription.split(' ').map(word => word.charAt(0)).join('');
                const code = serviceInitials + '_' + pacienteDocumento;
                // Segunda solicitud POST a /api/shift con el ID del paciente
                return fetch('/api/shift', {
                    method: 'POST',
                    body: JSON.stringify({
                        patient_id: pacienteId,
                        service_id: document.getElementById('servicio').value,
                        state: 'pending',
                        code: code
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al asignar el turno');
                }
                return response.json();
            })
            .then(data => {
                // Éxito, muestra una alerta bonita con el mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Turno asignado correctamente',
                });
            })
            .catch(error => {
                // Error, muestra una alerta bonita con el mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message,
                });
            });
    }
</script>
