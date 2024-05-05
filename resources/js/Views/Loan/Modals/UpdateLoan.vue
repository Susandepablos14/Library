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
               Modificar Autor
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

            <label for="biography" class="form-label">Biografía</label>
            <textarea
            type="text"
            id="biography"
            class="form-control form-control-user mb-3"
            autofocus
            name="biography"
            v-model="form.biography"
            rows="3"
            ></textarea>

            <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
            <input
              type="date"
              id="birthdate"
              class="form-control form-control-user mb-3"
              autofocus
              name="birthdate"
              v-model="form.birthdate"
            />

            <div class="mb-3">
                <label for="country_id" class="form-label">Nacionalidad</label>
                <select
                    v-model="form.country_id"
                    class="form-control"
                    id="country_id"
                    name="country_id"
                >
                    <option v-for="country in countries" :value="country.id">{{ country.nationality }}</option>
                </select>
              </div>

            <div>
                <label class="form-label mb-2">{{ imageLabel }}</label>
                <span v-if="isNewImage" >{{ image.name }}</span>
                <span v-else>{{ imageName }}</span>

                <div class="input-container">
                    <input
                        v-if="!isNewImage"
                        type="file"
                        id="image"
                        class="form-control form-control-user mb-3 mt-3"
                        autofocus
                        name="image"
                        @change="uploadImage"
                    />
                    <button
                        v-else
                        type="button"
                        class="btn btn-danger mb-3 mt-3"
                        @click="removeImage"
                    >
                        Remover
                    </button>
                </div>
            </div>
              <small class="text-muted">Dimensiones de la imagen mínima: 30x30 / máxima: 80x80</small>
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
  name: "AuthorUpdate",
  components: {},

  created() {
    this.getKeeps();
  },
  data() {
    return {
      form: this.getClearFormObject(),
      permissions: [],
      image: null,
      imageName: '',
      isNewImage: false,
      originalImageName: '',
      };
    },
    computed: {
    imageLabel() {
      return this.isNewImage ? 'Archivo Nuevo:' : 'Archivo Actual:';
        },
    },
    methods: {
        uploadImage(event) {
            if (event.target.files.length > 0) {
            this.image = event.target.files[0];
            this.imageName = '';
            this.isNewImage = true;
            }
        },
        removeImage() {
            this.image = null;
            this.isNewImage = false;
            this.imageName = this.originalImageName;
        },
    createPermission: function () {
      const formData = new FormData();
      formData.append("country_id", this.form.country_id);
        if (this.image) {
            formData.append("image", this.image);
            formData.append("image_name", this.image.name);
        }

        for (let key in this.form) {
            formData.append(key, this.form[key]);
        }

        var url = "/author/" + this.form.id;
        axios
            .post(url, formData)
        .then((response) => {
          this.errors = [];
          this.getClearFormObject();
          toastr.success("Autor Modificado");
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
    getKeeps() {
        var urlCountries = "/country/get";
        axios
          .all([
            axios.get(urlCountries),
          ])
          .then(axios.spread((responseCountries) => {
            this.countries = responseCountries.data.data.map(country => ({
              nationality: country.attributes.nationality,
              id: country.id
            }));
          }))
          .catch((error) => {});
    },

    UpdateGetRol(role) {
      this.form.id = role.id|| "";
      this.form.name = role.attributes.name|| "";
      this.form.biography = role.attributes.biography|| "";
      this.form.birthdate = role.attributes.birthdate|| "";
      this.form.country_id = role.attributes.country_id|| "";
      this.imageName = role.relationships.image.attributes.name;
      this.originalImageName = this.imageName
    },
    getClearFormObject() {
      return {
        id: "",
        name: "",
        biography: "",
        birthdate: "",
        country_id: "",
      };
    },
  },
};
</script>
<style>
@import "~toastr/build/toastr.css";
</style>
