<template>
    <div class="row justify-content-center">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Países</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Data Países
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
                                >Crear Pais</span
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
                                <th>Nombre</th>
                                <th>Nacionalidad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Nacionalidad</th>
                                <th>Acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr v-for="keep in keeps" :key="keep.id">
                                <td>{{ keep.id }}</td>
                                <td>{{ keep.attributes.name }}</td>
                                <td>{{ keep.attributes.nationality }}</td>
                                <td>
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
    </div>
</template>

<script>
import axios from "axios";
import CreateRol from "../Modals/CreateCountry.vue";
import UpdateRol from "../Modals/UpdateCountry.vue";
import Swal from "sweetalert2";


export default {
    name: "CountryDataTable",
    components: {
        CreateRol,
        UpdateRol,

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
        };
    },
    methods: {
        getKeeps: function () {
            var urlKeeps = "/country/get";
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
                    var url = "/country/delete/" + keep.id;
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
    },
};
</script>
<style>
@import "~sweetalert2/dist/sweetalert2.css";
</style>
