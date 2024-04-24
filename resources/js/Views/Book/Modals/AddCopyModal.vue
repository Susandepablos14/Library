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
                            <select class="form-control" id="status" v-model="newCopy.status" required>
                                <option value="Disponible">Disponible</option>
                                <option value="Dañado">Dañado</option>
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
                book_id: null,
                quantity: null,
                status: 'Disponible'
            },
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
            if (!this.newCopy.quantity || !this.newCopy.status || !this.newCopy.id || !this.newCopy.book_id) {
                alert('Por favor, complete todos los campos');
                return;
            }

            const url = `copy/${this.newCopy.id}`;

            const data = {
                id: this.newCopy.id,
                book_id: this.newCopy.book_id,
                quantity: this.newCopy.quantity,
                status: this.newCopy.status
            };

            axios.post(url, data)
                .then(response => {
                    console.log('Respuesta del servidor:', response.data);
                    $("#addCopyModal").modal("hide");
                })
                .catch(error => {
                    console.error('Error al agregar copia:', error.response.data);
                    alert('Error al agregar copia');
                });
        }
    }
};
</script>

<style scoped>
    /* Estilos personalizados */
</style>
