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
                    <button type="button" class="btn btn-danger text-white btn-icon-split mb-4" data-dismiss="modal">
                        <span class="text font-montserrat font-weight-bold">Cerrar</span>
                    </button>
                    <button type="button" class="btn btn-primary text-white btn-icon-split mb-4" @click="showAddCopy(copies)">
                        <span class="text font-montserrat font-weight-bold">Añadir copia</span>
                    </button>
                </div>
            </div>
        </div>
        <AddCopyModal ref="addCopyModalRef"></AddCopyModal>
    </div>
</template>

<script>
import AddCopyModal from "./AddCopyModal";

export default {
    components: {
        AddCopyModal
    },
    props: {
        copies: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        showCopiesModal() {
            $("#copyModal").modal("show");
        },
        showAddCopy(copies) {
            if (!Array.isArray(copies) || copies.length === 0) {
                console.error('Error: No se proporcionó un array válido de copias.');
                return;
            }

            const bookId = copies[0].book_id;
            const copyId = copies[0] ? copies[0].id : null;

            this.$refs.addCopyModalRef.showAddCopyModal(bookId, copyId);
        },

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
