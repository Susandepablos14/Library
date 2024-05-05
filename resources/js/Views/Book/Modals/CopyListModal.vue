<template>
    <div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title title-page text-secondary" id="copyModalLabel">
                        Copias del Libro
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addCopy">
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
                        <!-- Botón "Añadir Copia" -->
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Añadir Copia</button>
                        </div>
                    </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título del Libro</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="copy in copies" :key="copy.id">
                                    <td>{{ copy.id }}</td>
                                    <td>{{ copy.book.title }}</td>
                                    <td>{{ copy.quantity }}</td>
                                    <td>{{ copy.status }}</td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white btn-icon-split" data-dismiss="modal">
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
                reason: ''
            }
        };
    },
    components: {
    },
    props: {
        copies: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        showCopiesModal(bookId) {
            this.newCopy.book_id = bookId;
            $("#copyModal").modal("show");
        },
        addCopy() {
            const url = `copy/${this.newCopy.book_id }/book`;
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
                    } else if (this.newCopy.reason === 'Prestado') {
                    }
                }
            },
            resetForm() {
            const bookId = this.newCopy.book_id;
            this.newCopy = {
                book_id: bookId,
                quantity: '',
                status: 'Disponible',
                reason: ''
            };
        }
        }
};
</script>

<style scoped>
    /* Estilos para la tabla con bordes */
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }
</style>
