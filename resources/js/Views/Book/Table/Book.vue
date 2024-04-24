<template>
    <div class="row justify-content-center">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Libros</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Data Libros
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="col text-right">
                        <a
                            data-toggle="modal"
                            v-on:click.prevent="CreateRol()"
                            v-if="create"
                            class="btn btn-primary text-white btn-icon-split mb-4"
                        >
                            <i class="fas fa-check"></i>
                            <span class="text font-montserrat font-weight-bold"
                                >Crear Libro</span
                            >
                        </a>
                    </div>
                    <table
                        class="table table-bordered"
                        id="dataTable"
                        width="100%"
                        cellspacing="0"
                    >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Autor</th>
                                <th>Editorial</th>
                                <th>Categoría</th>
                                <th>Fecha de Publicación</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Autor</th>
                                <th>Editorial</th>
                                <th>Categoría</th>
                                <th>Fecha de Publicación</th>
                                <th>Acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr v-for="keep in keeps" :key="keep.id">
                                <td>{{ keep.id }}</td>
                                <td>{{ keep.attributes.title }}</td>
                                <td class="text-center"  style="max-width: 400px; overflow: auto;">
                                    <template v-if="keep.showDescription">
                                        {{ keep.attributes.description }}
                                    </template>
                                    <i
                                        v-on:click.prevent="toggleDescription(keep)"
                                        class="ico fas fa-eye fa-lg text-secondary"
                                        style="cursor: pointer;"
                                        title="Ver Descripción"
                                    ></i>
                                </td>
                                <td>{{ keep.relationships.author.attributes.name }}</td>
                                <td>{{ keep.relationships.editorial.attributes.name }}</td>
                                <td>{{ keep.relationships.category.attributes.name }}</td>
                                <td>{{ keep.attributes.publication_date }}</td>
                                <td>
                                    <i
                                        v-on:click.prevent="
                                            showCopies(keep)
                                        "
                                        v-if="
                                            updated &&
                                            !keep.attributes.deleted_at
                                        "
                                        class="ico fas fa-book fa-lg text-secondary"
                                        style="cursor: pointer"
                                        title="Copias"
                                    ></i>
                                    <i
                                        v-on:click.prevent="
                                        showImageModal(keep)"
                                        v-if="
                                        !keep.attributes.deleted_at"
                                        class="ico fas fa-image fa-lg text-secondary"
                                        style="cursor: pointer;"
                                        title="Ver Imagen">
                                    </i>
                                    <i
                                        v-on:click.prevent="
                                            UpdatedPermission(keep)
                                        "
                                        v-if="
                                            updated &&
                                            !keep.attributes.deleted_at
                                        "
                                        class="ico fas fa-edit fa-lg text-secondary"
                                        style="cursor: pointer"
                                        title="editar"
                                    ></i>

                                    <i
                                        v-on:click.prevent="
                                            deletePermission(keep)
                                        "
                                        v-if="deletet"
                                        :class="
                                            keep.attributes.deleted_at
                                                ? 'ico fas fa-trash-restore-alt fa-lg text-secondary'
                                                : 'ico fas fa-trash fa-lg text-secondary'
                                        "
                                        style="cursor: pointer"
                                        title="Borrar"
                                    ></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <create-rol @GetCreatedRol="GetCreatedRol" />
        <update-rol @GetCreatedRol="GetCreatedRol" ref="componente" />
        <image-viewer :imageUrl="imageUrl" />
        <CopyListModal :copies="copies" ref="copyListComponent" />
        <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="descriptionModalLabel">Descripción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p style="word-wrap: break-word;">{{ selectedDescription }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from "axios";
import CreateRol from "../Modals/CreateBook.vue";
import UpdateRol from "../Modals/UpdateBook.vue";
import Swal from "sweetalert2";
import ImageViewer from "../../../components/ImageViewer";
import CopyListModal from "../Modals/CopyListModal";

export default {
    name: "BookDataTable",
    components: {
        CreateRol,
        UpdateRol,
        ImageViewer,
        CopyListModal
    },
    props: {
        create: {
            type: String,
            default: 0,
        },
        deletet: {
            type: String,
            default: 0,
        },
        updated: {
            type: String,
            default: 0,
        },
    },
    created() {
        this.getKeeps();
    },
    data() {
        return {
            keeps: [],
            imageUrl: '',
            selectedDescription: '',
            copies: [],
        };
    },
    methods: {
        getKeeps: function () {
            var urlKeeps = "/book/get";
            axios
                .get(urlKeeps)
                .then((response) => {
                    this.keeps = response.data.data;
                    $("#dataTable").DataTable().destroy();
                    this.$nextTick(function () {
                        $("#dataTable").DataTable({
                            // DataTable options here...
                        });
                    });
                })
                .catch((err) => {});
        },
        deletePermission: function (keep) {
            var actionText = keep.attributes.deleted_at ? "restaurar" : "eliminar";
            var successText = keep.attributes.deleted_at ? "restaurado" : "eliminado";

            Swal.fire({
                title: `¿Estás seguro de ${actionText} este elemento?`,
                text: `El registro será ${successText}.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.value) {
                    var url = "/book/delete/" + keep.id;
                    axios.delete(url).then((response) => {
                        Swal.fire(
                            `¡${successText.charAt(0).toUpperCase() + successText.slice(1)}!`,
                            `El registro ha sido ${successText}.`,
                            "success"
                        );
                        this.getKeeps();
                    }).catch((error) => {
                        Swal.fire(
                            "Error",
                            `Hubo un problema al intentar ${actionText} el registro.`,
                            "error"
                        );
                    });
                }
            });
        },

        CreateRol: function () {
            $("#exampleModal").modal("show");
        },

        UpdatedPermission(permission) {
            this.$refs.componente.UpdateGetRol(permission);
            $("#exampleModal2").modal("show");
        },

        GetCreatedRol: function () {
            this.getKeeps();
        },
        showImageModal(keep) {
            if (keep.relationships.image && keep.relationships.image.attributes.path) {
                const imagePath = keep.relationships.image.attributes.path;
                this.imageUrl = '/' + imagePath;
                $('#imageModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No hay imagen disponible.'
                });
            }
        },
        toggleDescription(keep) {
            this.selectedDescription = keep.attributes.description;
            $('#descriptionModal').modal('show');
        },
        showCopies(keep) {
        const url = `/book/${keep.id}/copies`;
        axios.get(url)
            .then(response => {
                this.copies = response.data.data;
                this.$refs.copyListComponent.showCopiesModal();
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al obtener las copias del libro.'
                });
            });
        },
    },
};
</script>
<style>
@import "~sweetalert2/dist/sweetalert2.css";
</style>
