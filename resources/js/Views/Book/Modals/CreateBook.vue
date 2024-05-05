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
              Crear Libro
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
            <label for="title" class="form-label">Título</label>
            <input
              type="text"
              id="title"
              class="form-control form-control-user mb-3"
              autofocus
              name="title"
              v-model="form.title"
            />

            <label for="description" class="form-label">Descripción</label>
                <textarea
                type="text"
                id="description"
                class="form-control form-control-user mb-3"
                autofocus
                name="description"
                v-model="form.description"
                rows="3"
                ></textarea>

            <div class="mb-3">
                <label for="author_id" class="form-label">Autor</label>
                <select
                    v-model="form.author_id"
                    class="form-control"
                    id="author_id"
                    name="author_id"
                >
                    <option v-for="author in authors" :value="author.id">{{ author.name }}</option>
                </select>
                </div>
            <div class="mb-3">
                <label for="editorial_id" class="form-label">Editorial</label>
                <select
                    v-model="form.editorial_id"
                    class="form-control"
                    id="editorial_id"
                    name="editorial_id"
                >
                    <option v-for="editorial in editorials" :value="editorial.id">{{ editorial.name }}</option>
                </select>
                </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Categoría</label>
                <select
                    v-model="form.category_id"
                    class="form-control"
                    id="category_id"
                    name="category_id"
                >
                    <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                </select>
              </div>

            <label for="publication_date" class="form-label">Fecha de Publicación</label>
              <input
                type="text"
                id="publication_date"
                class="form-control form-control-user mb-3"
                autofocus
                name="publication_date"
                v-model="form.publication_date"
              />
            <label for="quantity" class="form-label">Cantidad de Libros</label>
            <input
                type="number"
                id="quantity"
                class="form-control form-control-user mb-3"
                name="quantity"
                v-model="form.quantity"
            />

            <label for="image" class="form-label">Catarula</label>
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
            <small class="text-muted">Dimensiones de la imagen mínima:  100x150 / máxima: 400x600</small>
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
  name: "BookCreate",
  created() {
    this.getKeeps();
  },
  data() {
    return {
      form: this.getClearFormObject(),
      authors: [],
      editorials: [],
      categories: [],
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
      formData.append("title", this.form.title);
      formData.append("description", this.form.description);
      formData.append("author_id", this.form.author_id);
      formData.append("editorial_id", this.form.editorial_id);
      formData.append("category_id", this.form.category_id);
      formData.append("publication_date", this.form.publication_date);
      formData.append("quantity", this.form.quantity);

      if (this.image) {
            formData.append("image", this.image);
            formData.append("image_name", this.image.name);
        }
      axios
        .post("/book/create", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.errors = null;
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
        var urlAuthors = "/author/get";
        var urlEditorials = "/editorial/get";
        var urlCategories = "/category/get";
        axios
          .all([
            axios.get(urlAuthors),
            axios.get(urlEditorials),
            axios.get(urlCategories),
          ])
          .then(axios.spread((responseAuthors, responseEditorials, responseCategories) => {
            this.authors = responseAuthors.data.data.map(author => ({
              name: author.attributes.name,
              id: author.id
            }))
            this.editorials = responseEditorials.data.data.map(editorial => ({
              name: editorial.attributes.name,
              id: editorial.id
            }))
            this.categories = responseCategories.data.data.map(category => ({
              name: category.attributes.name,
              id: category.id
            }))
          }))
          .catch((error) => {});
      },
    getClearFormObject() {
      return {
        title: "",
        description: "",
        author_id: "",
        editorial_id: "",
        category_id: "",
        publication_date: "",
      };
    },
  },
};
</script>

<style>
    @import "~toastr/build/toastr.css";
</style>
