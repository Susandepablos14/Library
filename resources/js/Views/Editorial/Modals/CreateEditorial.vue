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
              Crear Editorial
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

            <label for="address" class="form-label">Dirección</label>
            <input
              type="text"
              id="address"
              class="form-control form-control-user mb-3"
              autofocus
              name="address"
              v-model="form.address"
            />

            <label for="phone" class="form-label">Número de Teléfono</label>
            <input
                type="text"
                id="phone"
                class="form-control form-control-user mb-3"
                autofocus
                name="phone"
                v-model="form.phone"
                placeholder="+"
            />

            <label for="email" class="form-label">Correo</label>
            <input
              type="text"
              id="email"
              class="form-control form-control-user mb-3"
              autofocus
              name="email"
              v-model="form.email"
            />

            <div class="mb-3">
                <label for="country_id" class="form-label">País</label>
                <select
                    v-model="form.country_id"
                    class="form-control"
                    id="country_id"
                    name="country_id"
                >
                    <option v-for="country in countries" :value="country.id">{{ country.name }}</option>
                </select>
              </div>

            <label for="image" class="form-label">Logo</label>
            <input
                v-if="!image"
                type="file"
                id="image"
                class="form-control form-control-user mb-3"
                autofocus
                name="image"
                @change="uploadImage"
            />
            <div v-else>
            <button
                type="button"
                class="btn btn-danger mb-3"
                @click="removeImage"
            >
                Remover
            </button>
            <div>
                <label for="image" class="form-label">Nombre del logo</label>
                <input
                    type="text"
                    id="image_name"
                    class="form-control form-control-user mb-3"
                    autofocus
                    name="image_name"
                    v-model="image.name"
                />
            </div>
            </div>
            <small class="text-muted">Dimensiones de la imagen mínima:  30x30 / máxima: 80x80</small>
          </div>
          <div class="modal-footer">
            <a
              class="btn btn-danger text-white btn-icon-split mb-4"
              data-dismiss="modal"
            >
              <span class="text font-montserrat font-weight-bold"
                >Cancelar</span
              >
            </a>
            <a
              v-on:click.prevent="createArtist()"
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
  name: "AuthorCreate",
  created() {
    this.getKeeps();
  },
  data() {
    return {
      form: this.getClearFormObject(),
      countries: [],
      image: null,
    };
  },
  methods: {
    uploadImage(event) {
      this.image = event.target.files[0];
    },
    removeImage() {
      this.image = null;
    },
    createArtist() {
      const formData = new FormData();
      formData.append("name", this.form.name);
      formData.append("address", this.form.address);
      formData.append("phone", this.form.phone);
      formData.append("email", this.form.email);
      formData.append("country_id", this.form.country_id);

      if (this.image) {
            formData.append("image", this.image);
            formData.append("image_name", this.image.name);
        }
      axios
        .post("/editorial/create", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.image = null;
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
    getKeeps() {
        var urlCountries = "/country/get";
        axios
          .all([
            axios.get(urlCountries),
          ])
          .then(axios.spread((responseCountries) => {
            this.countries = responseCountries.data.data.map(country => ({
              name: country.attributes.name,
              id: country.id
            }));
          }))
          .catch((error) => {});
      },
    getClearFormObject() {
      return {
        name: "",
        address: "",
        phone: "+",
        email: "",
        country_id: "",
      };
    },
  },
};
</script>

<style>
    @import "~toastr/build/toastr.css";
</style>
