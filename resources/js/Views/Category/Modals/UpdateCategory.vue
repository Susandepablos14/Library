<template>
  <form>
    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal2"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header py-2">
            <h5 class="modal-title title-page text-secondary" id="exampleModalLabel">
               Modificar Categoria
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
              <span class="text font-montserrat font-weight-bold">Cancelar</span
              >
            </a>
            <a
              v-on:click.prevent="createPermission()"
              class="btn btn-primary text-white btn-icon-split mb-4"
            >
              <span class="text font-montserrat font-weight-bold"
                >Modificar </span
              >
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
  name: "CategoryUpdate",
  components: {},

  created() {},
  data() {
    return {
      form: this.getClearFormObject(),
      permissions: [],
    };
  },
  methods: {
    createPermission: function () {
      var url = "/category/" + this.form.id;
      axios
        .post(url, this.form)
        .then((response) => {
          this.errors = [];
          this.getClearFormObject();
          toastr.success("Categoria Modificada");
          $("#exampleModal2").modal("hide");
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

    UpdateGetRol(role) {
      this.form.id = role.id|| "";
      this.form.name = role.attributes.name|| "";
      this.form.description = role.attributes.description|| "";
    },
    getClearFormObject() {
      return {
        id: "",
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
