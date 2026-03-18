document.addEventListener('DOMContentLoaded', () => {
            // const menuToggle = document.getElementById('menu-toggle');
            // const sidebar = document.getElementById('sidebar');
            // if (menuToggle) {
            //     menuToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
            // }

            function openModal(modal) {
                if (!modal) return;
                document.body.classList.add('modal-open');
                modal.style.display = 'flex';
            }

            function closeModal(modal) {
                if (!modal) return;
                document.body.classList.remove('modal-open');
                modal.style.display = 'none';
            }

            const diasSemana = ["LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO", "DOMINGO"];

            function createScheduleRow(id, dia = '', horaInicio = '', horaFin = '', namePrefix = 'create') {
                const row = document.createElement('div');
                row.className = 'schedule-row';

                if (id !== null && id !== undefined && id !== '') {
                    const idForm = document.createElement('input');
                    idForm.type = 'hidden';
                    idForm.name = 'idHorario[]';
                    idForm.value = id;
                    row.appendChild(idForm);
                }

                const diaFormGroup = document.createElement('div');
                diaFormGroup.className = 'form-group';
                diaFormGroup.innerHTML = `<label>Día</label><select name="${namePrefix}Dias[]" required><option value="">Seleccione día...</option>${diasSemana.map(d => `<option value="${d}">${d.charAt(0).toUpperCase() + d.slice(1).toLowerCase()}</option>`).join('')}</select>`;
                
                const inicioFormGroup = document.createElement('div');
                inicioFormGroup.className = 'form-group';
                inicioFormGroup.innerHTML = `<label>Hora Inicio</label><input type="time" name="${namePrefix}HoraInicio[]" required>`;

                const finFormGroup = document.createElement('div');
                finFormGroup.className = 'form-group';
                finFormGroup.innerHTML = `<label>Hora Fin</label><input type="time" name="${namePrefix}HoraFin[]" required>`;
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger remove-schedule-btn';
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = () => row.remove();
                
                row.appendChild(diaFormGroup);
                row.appendChild(inicioFormGroup);
                row.appendChild(finFormGroup);
                row.appendChild(removeBtn);

                if (dia) diaFormGroup.querySelector('select').value = dia;
                if (horaInicio) inicioFormGroup.querySelector('input').value = horaInicio;
                if (horaFin) finFormGroup.querySelector('input').value = horaFin;

                return row;
            }

            const createContainer = document.getElementById('createScheduleContainer');
            document.getElementById('addCreateScheduleBtn')?.addEventListener('click', () => {
                createContainer.appendChild(createScheduleRow(null, '', '', '', 'create'));
            });

            const editContainer = document.getElementById('editScheduleContainer');
            document.getElementById('addEditScheduleBtn')?.addEventListener('click', () => {
                editContainer.appendChild(createScheduleRow(null, '', '', '', 'edit'));
            });

            const createModal = document.getElementById('createWorkshopModal');
            const createForm = document.getElementById('createWorkshopForm');
            document.getElementById('openCreateModalBtn')?.addEventListener('click', () => {
                createForm?.reset();
                if (createContainer) createContainer.innerHTML = ''; 
                createContainer?.appendChild(createScheduleRow(null, '', '', '', 'create'));
                openModal(createModal);
            });

            const editModal = document.getElementById('editWorkshopModal');
            const editForm = document.getElementById('editWorkshopForm');
            const editModalTitle = document.getElementById('editModalTitle');
            
            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('edit-btn')) {
                    const button = event.target;
                    
                    if(editModalTitle) editModalTitle.textContent = `Editar Taller: ${button.dataset.nombre}`;
                    document.getElementById('editWorkshopId').value = button.dataset.id;
                    document.getElementById('editNombre').value = button.dataset.nombre;
                    document.getElementById('editDiscipline').value = button.dataset.disciplina;
                    document.getElementById('editVacancies').value = button.dataset.vacantes;
                    document.getElementById('editCost').value = button.dataset.costoMatricula;
                    document.getElementById('editMonthlyFee').value = button.dataset.costoMensualidad;
                    document.getElementById('editStatus').value = button.dataset.activo;
                    document.getElementById('editCategory').value = button.dataset.categoria;
                    document.getElementById('editTeacher').value = button.dataset.docente;
                    document.getElementById('editLugar').value = button.dataset.lugar;
                    
                    if (editContainer) editContainer.innerHTML = '';
                    try {
                        const arrayHorarios = JSON.parse(button.dataset.horarios);
                        if (Array.isArray(arrayHorarios) && arrayHorarios.length > 0) {
                            arrayHorarios.forEach(horario => {
                                editContainer?.appendChild(createScheduleRow(horario.id, horario.dia_semana, horario.hora_inicio, horario.hora_fin, 'edit'));
                            });
                        } else {
                            editContainer?.appendChild(createScheduleRow(null, '', '', '', 'edit'));
                        }
                    } catch (e) {
                         editContainer?.appendChild(createScheduleRow(null, '', '', '', 'edit'));
                    }

                    if (editForm) editForm.action = '{{url('admin/talleres')}}/' + button.dataset.id;
                    
                    openModal(editModal);
                }

                if (event.target.classList.contains('delete-btn')) {
                    const deleteButton = event.target;
                    const matriculasCount = parseInt(deleteButton.dataset.matriculas, 10);

                    if (matriculasCount > 0) {
                        event.preventDefault(); 
                        const alertModal = document.getElementById('deleteAlertModal');
                        openModal(alertModal);
                    }
                }
            });

            document.querySelectorAll('.modal').forEach(modal => {
                const closeButton = modal.querySelector('.close-icon');
                const cancelButton = modal.querySelector('.cancel-btn');
                const okButton = modal.querySelector('.ok-btn');
                
                closeButton?.addEventListener('click', () => closeModal(modal));
                cancelButton?.addEventListener('click', () => closeModal(modal));
                okButton?.addEventListener('click', () => closeModal(modal));
                
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal(modal);
                });
            });
        });