<template>
    <form>
      <!-- Modal -->
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header py-2">
              <h5
                class="modal-title title-page text-secondary"
                id="exampleModalLabel"
              >
                Crear Categoria
              </h5>
              <a
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </a>
            </div>
            <div class="modal-body">

              <label for="name" class="form-label">Nombre</label>
              <input
                type="text"
                id="name"
                class="form-control form-control-user mb-3"
                autofocus
                name="name"
                v-model="form.name"
              />
              <label for="description" class="form-label">Descripción</label>
              <input
                type="text"
                id="description"
                class="form-control form-control-user mb-3"
                autofocus
                name="description"
                v-model="form.description"
              />

              </div>
              <div class="modal-footer">
                <a
                  class="btn btn-danger text-white btn-icon-split mb-4"
                  data-dismiss="modal"
                >
                  <span class="text font-montserrat font-weight-bold">Cancelar</span>
                </a>
                <a
                  v-on:click.prevent="createNewsCategory()"
                  class="btn btn-primary text-white btn-icon-split mb-4"
                >
                  <span class="text font-montserrat font-weight-bold">Crear</span>
                </a>
              </div>
            </div>
          </div>
        </div>
    </form>
</template>

<script>
import axios from "axios";
import toastr from "toastr";

export default {
    name: "CategoryCreate",
    created() {},
    data() {
    return {
        form: this.getClearFormObject(),
    };
    },
    methods: {
    createNewsCategory() {
        const formData = new FormData();
        formData.append("name", this.form.name);
        formData.append("description", this.form.description);

        axios
        .post("/category/create", formData, {
            headers: {
            "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            this.form = this.getClearFormObject();
            toastr.success("Creado exitosamente.");
            $("#exampleModal").modal("hide");
            this.$emit("GetCreatedRol");
            window.location.reload();
        })
        .catch((error) => {
        if (error.response.status == 422) {
            this.errors = error.response.data.errors;
        }
        for (error in this.errors) {
            toastr.error(this.errors[error]);
        }
        });
    },
    getClearFormObject() {
    return {
        name: "",
        description: "",
    };
    },
},
};
</script>

<style>
    @import "~toastr/build/toastr.css";
</style>
