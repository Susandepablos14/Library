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
               Modificar País
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
              type="name"
              id="name"
              class="form-control form-control-user mb-3"
              autofocus
              name="name"
              v-model="form.name"
            />
            <label for="nationality" class="form-label">Nacionalidad</label>

            <input
              type="text"
              id="nationality"
              class="form-control form-control-user mb-3"
              autofocus
              name="nationality"
              v-model="form.nationality"
            >

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
              v-on:click.prevent="createCountry()"
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
  name: "CountryUpdate",
  components: {},

  created() {},
  data() {
    return {
      form: this.getClearFormObject(),
      permissions: [],
      };
    },
    methods: {

    createCountry: function () {
      const formData = new FormData();

        for (let key in this.form) {
            formData.append(key, this.form[key]);
        }

        var url = "/country/" + this.form.id;
        axios
            .post(url, formData)
        .then((response) => {
          this.errors = [];
          this.getClearFormObject();
          toastr.success("País Modificado");
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
      this.form.nationality = role.attributes.nationality|| "";
    },
    getClearFormObject() {
      return {
        id: "",
        name: "",
        nationality: "",
      };
    },
  },
};
</script>
<style>
@import "~toastr/build/toastr.css";
</style>
