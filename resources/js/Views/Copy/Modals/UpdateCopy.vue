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
               Modificar Libro
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
                type="date"
                id="publication_date"
                class="form-control form-control-user mb-3"
                autofocus
                name="publication_date"
                v-model="form.publication_date"
              />

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
                <small class="text-muted">Dimensiones de la imagen mínima:  100x150 / máxima: 400x600</small>
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
  name: "BookUpdate",
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
      authors: [],
      editorials: [],
      categories: [],
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
      formData.append("author_id", this.form.author_id);
      formData.append("editorial_id", this.form.editorial_id);
      formData.append("category_id", this.form.category_id);
        if (this.image) {
            formData.append("image", this.image);
            formData.append("image_name", this.image.name);
        }

        for (let key in this.form) {
            formData.append(key, this.form[key]);
        }

        var url = "/book/" + this.form.id;
        axios
            .post(url, formData)
        .then((response) => {
          this.errors = [];
          this.getClearFormObject();
          toastr.success("Libro Modificado");
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

    UpdateGetRol(role) {
      this.form.id = role.id|| "";
      this.form.title = role.attributes.title|| "";
      this.form.description = role.attributes.description|| "";
      this.form.author_id = role.attributes.author_id|| "";
      this.form.editorial_id = role.attributes.editorial_id|| "";
      this.form.category_id = role.attributes.category_id|| "";
      this.form.publication_date = role.attributes.publication_date|| "";
      this.imageName = role.relationships.image.attributes.name;
      this.originalImageName = this.imageName
    },
    getClearFormObject() {
      return {
        id: "",
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
