<template>
    <div class="modal fade" id="addCopyModal" tabindex="-1" role="dialog" aria-labelledby="addCopyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title title-page text-secondary" id="addCopyModalLabel">
                        Añadir Copia de Libro
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addCopy">
                        <!-- Campo oculto para almacenar book_id -->
                        <input type="hidden" v-model="newCopy.book_id">
                        <div class="form-group">
                            <label for="quantity">Cantidad:</label>
                            <input type="number" class="form-control" id="quantity" v-model="newCopy.quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Estado:</label>
                            <select class="form-control" id="status" v-model="newCopy.status" required @change="handleStatusChange">
                                <option value="Disponible">Disponible</option>
                                <option value="Perdido">Perdido</option>
                            </select>
                        </div>

                        <div v-if="newCopy.status === 'Perdido'" class="form-group">
                            <label for="reason">Razón de la pérdida:</label>
                            <select class="form-control" id="status" v-model="newCopy.reason" required @change="handleStatusChange">
                                <option value="Disponible">Libro(s) disponible(s)</option>
                                <option value="Prestado">Libro(s) prestados(s)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Añadir Copia</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white btn-icon-split mb-4" data-dismiss="modal">
                        <span class="text font-montserrat font-weight-bold">Cerrar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from "toastr";

export default {
    data() {
        return {
            newCopy: {
                book_id: '',
                quantity: '',
                status: 'Disponible',
                reason: '' // Nuevo campo para la razón de la pérdida
            }
        };
    },

    methods: {
        showAddCopyModal(bookId, copyId) {
            if (!bookId || !copyId) {
                console.error('Error: No se proporcionó un book_id o copy_id válido.');
                return;
            }

            this.newCopy.book_id = bookId;
            this.newCopy.id = copyId;
            this.newCopy.quantity = null;
            this.newCopy.status = 'Disponible';
            $("#addCopyModal").modal("show");
        },

        addCopy() {
        const url = `copy/${this.newCopy.id}`;
        axios.post(url, this.newCopy)
            .then(response => {
                // Éxito
                toastr.success('Copia añadida exitosamente.');
                // Restablecer los valores del formulario
                this.resetForm();
            })
            .catch(error => {
                // Error
                toastr.error('Error al añadir copia.');
                console.error(error);
            });
         },
        handleStatusChange() {
            if (this.newCopy.status !== 'Perdido') {
                this.newCopy.reason = '';
            } else {
                if (this.newCopy.reason === 'Disponible') {
                    // Restar de las disponibles
                } else if (this.newCopy.reason === 'Prestado') {
                    // Restar de las prestadas
                }
            }
        },
        resetForm() {
            this.newCopy = {
                book_id: '',
                quantity: '',
                status: 'Disponible',
                reason: ''
            };
        }
    }

};
</script>

<style scoped>
    /* Estilos personalizados */
</style>
